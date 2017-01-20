<div class="container addBox" style="width:95%">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Employee Profit Sheet</h1>
</div>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `employee` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ID: MPE-<?php echo $id; ?></span>
</div>
</div>

<div class="row" id="r1"><div class="col-md-2"><label>Name</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-3 text-left"><span style="font-size:18px;"><?php echo $data['contact']; ?></span></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Address</label></div><div class="col-md-10 text-left"><span style="font-size:18px;"><?php echo $data['address']; ?></span></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Dated</label></div><div class="col-md-10 text-left"><span style="font-size:18px;"><?php echo date("Y-m-d"); ?></span></div><div class="col-md-3"></div></div>
<br>
<div class="row" id="r1"><div class="col-md-12 text-center"><span style="font-size:18px;text-decoration:underline;font-weight:bold;">Whole Profit Sheet</span></div><div class="col-md-3"></div></div>
<br><br><br>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1">Inv #</div>
	<div class="col-sm-2">Customer</div>
	<div class="col-sm-1">Inv. Date</div>
	<div class="col-sm-1">LD(kg/p)</div>
	<div class="col-sm-1">LD Rate</div>
	<div class="col-sm-1">LD Total</div>
	<div class="col-sm-1">HD(kg/p)</div>
	<div class="col-sm-1">HD Rate</div>
	<div class="col-sm-1">HD Total</div>
	<div class="col-sm-2">Total</div>
</div>
<?php
$qry = "SELECT i.*,c.name as cName FROM `invoice` i, customers c WHERE i.customer = c.id and i.`salerep` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_profit = 0;
while($data = mysqli_fetch_array($run))
{
$advance = floatval($data['advance']);


$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material like '%LD%' group by i.id";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$ldCount = mysqli_num_rows($run2);
$data2 = mysqli_fetch_array($run2);

$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material not like '%LD%' group by i.id";
//echo $qry;
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$hdCount = mysqli_num_rows($run2);
$data3 = mysqli_fetch_array($run2);
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1 pointer" onclick="viewInvoice('<?php echo $data['id'] ?>')">INV-<?php echo $data['no'] ?></div>
	<div class="col-sm-2"><?php echo $data['cName'] ?></div>
	<div class="col-sm-1"><?php echo $data['date'] ?></div>
	<div class="col-sm-1"><?php echo round(floatval($data2['weices']), 1, PHP_ROUND_HALF_EVEN); ?></div>
	<div class="col-sm-1"><?php echo floatval( $data['ldRate']); ?></div>
	<div class="col-sm-1">Rs. <?php $total_profit += floatval($data['ldRate']) * floatval($data2['weices']);echo round(floatval($data['ldRate']) * floatval($data2['weices']), 1, PHP_ROUND_HALF_EVEN); ?></div>
	<div class="col-sm-1"><?php echo round(floatval( $data3['weices']), 1, PHP_ROUND_HALF_EVEN); ?></div>
	<div class="col-sm-1"><?php echo floatval( $data['hdRate']); ?></div>
	<div class="col-sm-1">Rs. <?php $total_profit += floatval($data['hdRate']) * floatval($data3['weices']);echo round(floatval($data['hdRate']) * floatval($data3['weices']), 1, PHP_ROUND_HALF_EVEN); ?></div>
	<div class="col-sm-2">Rs. <?php echo round(floatval( floatval($data['hdRate']) * floatval($data3['weices']) + floatval($data['ldRate']) * floatval($data2['weices'])), 1, PHP_ROUND_HALF_EVEN); ?></div>
</div>
<?php
}
?>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-5"></div>
	<div class="col-sm-1">Total</div>
	<div class="col-sm-2">Rs. <?php echo round( $total_profit, 2, PHP_ROUND_HALF_UP); ?></div>
</div><br><br>
<a href="javascript:void()" onclick="pageLoad('employees/profitSheet.php?id=<?php echo $id; ?>')">Monthly ProfitSheet</a> | 
<a href="javascript:void()" onclick="pageLoad('employees/performance.php?id=<?php echo $id; ?>')">Emplyee Performance</a> | 
<a href="javascript:void()" onclick="exportoverallProfitSheet('<?php echo $id; ?>')">Export to Excel</a>
<!-- 	<a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a> -->
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function exportoverallProfitSheet(id)
{
	window.open("employees/exportoverallprofitSheet.php?id="+id);
}

function printView(id)
{
	window.open("customers/customer_ledger_print.php?id="+id);
}
function viewPayment(id)
{
    pageLoad("customers/payment_update.php?id="+id);
}

function viewInvoice(id)
{
	pageLoad("customers/invoice_print.php?id="+id);
}
</script>
