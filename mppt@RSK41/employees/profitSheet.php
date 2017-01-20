<div class="container addBox" style="width:95%">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Employee Profit Sheet</h1>
<style type="text/css">
#hoverX:hover
{
	background-color: green;
	color:white;
	font-weight: bold;
}

#scroll
{
	max-height: 500px;
	overflow-y: scroll;
}
</style>
</div>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `employee` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);

if(!isset($_GET['year']) && !isset($_GET['month']))
{
$year = date("Y");
$month = date("m");
}
else
{
$year = $_GET['year'];
$month = $_GET['month'];
}
		switch ($month) {
      case 1:
        $monthT = "Jan";
        break;
      case 2:
        $monthT = "Feb";
        break;
      case 3:
        $monthT = "March";
        break;
      case 4:
        $monthT = "April";
        break;
      case 5:
        $monthT = "May";
        break;
      case 6:
        $monthT = "June";
        break;
      case 7:
        $monthT = "July";
        break;
      case 8:
        $monthT = "Aug";
        break;
      case 9:
        $monthT = "Sep";
        break;
      case 10:
        $monthT = "Oct";
        break;
      case 11:
        $monthT = "Nov";
        break;
      case 12:
        $monthT = "Dec";
        break;

      default:
        $monthT = "Unknown";
        break;
    }
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ID: MPE-<?php echo $id; ?></span>
</div>
</div>
<input type="hidden" id="empid" value="<?php echo $id; ?>">
<div class="row" id="r1"><div class="col-md-2"><label>Name</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-3 text-left"><span style="font-size:18px;"><?php echo $data['contact']; ?></span></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Address</label></div><div class="col-md-10 text-left"><span style="font-size:18px;"><?php echo $data['address']; ?></span></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Month-Year</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $monthT."-".$year; ?></span></div><div class="col-md-3"><label>Month</label></div>
<div class="col-md-3 text-left">	
<select id="monthOpt" onchange="updatePSMonth()">
		<option value="1" <?php if(intval($month) == 1) echo "selected"; ?>>Jan</option>
		<option value="2" <?php if(intval($month) == 2) echo "selected"; ?>>Feb</option>
		<option value="3" <?php if(intval($month) == 3) echo "selected"; ?>>March</option>
		<option value="4" <?php if(intval($month) == 4) echo "selected"; ?>>April</option>
		<option value="5" <?php if(intval($month) == 5) echo "selected"; ?>>May</option>
		<option value="6" <?php if(intval($month) == 6) echo "selected"; ?>>June</option>
		<option value="7" <?php if(intval($month) == 7) echo "selected"; ?>>July</option>
		<option value="8" <?php if(intval($month) == 8) echo "selected"; ?>>Aug</option>
		<option value="9" <?php if(intval($month) == 9) echo "selected"; ?>>Sep</option>
		<option value="10" <?php if(intval($month) == 10) echo "selected"; ?>>Oct</option>
		<option value="11" <?php if(intval($month) == 11) echo "selected"; ?>>Nov</option>
		<option value="12" <?php if(intval($month) == 12) echo "selected"; ?>>Dec</option>
	</select>

</div></div>
<br><br>
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
<div id="scroll">
<?php
$qry = "SELECT i.*,c.name as cName FROM `invoice` i, customers c WHERE i.customer = c.id and i.`salerep` = '$id' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' order by i.no";
//echo $qry;
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_profit = 0;
$total_ld = 0;
$total_hd = 0;
while($data = mysqli_fetch_array($run))
{
$advance = intval($data['advance']);


			$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material = 'LD' group by i.id";
			$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
			$ldCount = mysqli_num_rows($run2);
			$data2 = mysqli_fetch_array($run2);

			$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material != 'LD' group by i.id";
			//echo $qry;
			$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
			$hdCount = mysqli_num_rows($run2);
			$data3 = mysqli_fetch_array($run2);
?>
<div class="row" id="hoverX" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1 pointer" onclick="viewInvoice('<?php echo $data['no'] ?>')">INV-<?php echo $data['no'] ?></div>
	<div class="col-sm-2"><?php echo $data['cName'] ?></div>
	<div class="col-sm-1"><?php echo $data['date'] ?></div>
	<div class="col-sm-1"><?php $total_ld += floatval($data2['weices']); echo round( $data2['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"><?php echo round( $data['ldRate'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1">Rs. <?php $total_ldProfit += intval($data['ldRate']) * floatval($data2['weices']); $total_profit += intval($data['ldRate']) * $data2['weices'];echo round( intval($data['ldRate'])  * $data2['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"><?php $total_hd += floatval($data3['weices']); echo round( $data3['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"><?php echo round( $data['hdRate'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1">Rs. <?php $total_hdProfit += intval($data['hdRate']) * floatval($data3['weices']); $total_profit += intval($data['hdRate'])  * $data3['weices'];echo round( intval($data['hdRate'])  * $data3['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	
	
	<div class="col-sm-2">Rs. <?php echo round( intval($data['hdRate'])  * $data3['weices'] + intval($data['ldRate'])  * $data2['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
</div>
<?php
}
?>
</div>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Total</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1"><?php echo round( $total_ld, 1, PHP_ROUND_HALF_UP); ?> Kg</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1">Rs. <?php echo round( $total_ldProfit, 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"><?php echo round( $total_hd, 1, PHP_ROUND_HALF_UP); ?> Kg</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1">Rs. <?php echo round( $total_hdProfit, 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-2">Rs. <?php echo round( $total_profit, 1, PHP_ROUND_HALF_UP); ?></div>
</div><br><br>
<a href="javascript:void()" onclick="pageLoad('employees/overallprofitSheet.php?id=<?php echo $id; ?>')">Overall ProfitSheet</a> | 
<a href="javascript:void()" onclick="pageLoad('employees/performance.php?id=<?php echo $id; ?>')">Emplyee Performance</a> | 
<a href="javascript:void()" onclick="exportProfitSheet('<?php echo $id; ?>','<?php echo $month; ?>','<?php echo $year; ?>')">Export to Excel</a>
<!-- 	<a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a> -->
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function exportProfitSheet(id,m,y)
{
	window.open("employees/exportprofitSheet.php?id="+id+"&month="+m+"&year="+y);
}

function printView(id)
{
	window.open("customers/customer_ledger_print.php?id="+id);
}
function viewPayment(id)
{
    pageLoad("customers/payment_update.php?id="+id);
}

function viewInvoice(no)
{
	pageLoad("customers/invoice_print.php?no="+no);
}
function updatePSMonth()
{
	var month = $("#monthOpt").val();
	var id = $("#empid").val();
	//alert(month);
	pageLoad('employees/profitSheet.php?year=2016&month='+month+'&id='+id);
}
</script>
