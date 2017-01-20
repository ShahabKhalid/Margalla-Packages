<div class="container addBox">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Vendor Ledger / Statement</h1>
</div>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `vendor` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ID: VEND-<?php echo $id; ?></span>
</div>
</div>

<div class="row" id="r1"><div class="col-md-2"><label>Name</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-3 text-left"><span style="font-size:18px;"><?php echo $data['contact']; ?></span></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Address</label></div><div class="col-md-10 text-left"><span style="font-size:18px;"><?php echo $data['address']; ?></span></div><div class="col-md-3"></div></div>
<br><br><br>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Particular</div>
	<div class="col-sm-1">Bill #</div>
	<div class="col-sm-1">Bill. Date</div>
	<div class="col-sm-1">Pay. #</div>
	<div class="col-sm-1">Pay. Date</div>
	<div class="col-sm-2">Debit</div>
	<div class="col-sm-2">Credit</div>
	<div class="col-sm-2">Balance</div>
</div>
<?php
$qry = "SELECT * FROM `bill` WHERE `vendor` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_balance = 0;
while($data = mysqli_fetch_array($run))
{
$advance = 0;
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Bill</div>
	<div class="col-sm-1 pointer" onclick="viewBill('<?php echo $data['id'] ?>')">BILL-<?php echo $data['id'] ?></div>
	<div class="col-sm-1"><?php echo $data['date'] ?></div>
	<div class="col-sm-1">--</div>
	<div class="col-sm-1">--</div>
	<div class="col-sm-2">--</div>
	<?php
	$qry = "SELECT * FROM `bill_detail` WHERE `ref` = '".$data['ref']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
		$total += floatval($data2['weices']) * floatval($data2['rate']);
	}
	?>
	<div class="col-sm-2"><?php echo number_format($total); ?></div>
	<div class="col-sm-2"><?php $balance = $advance - $total; $total_balance += $balance; echo number_format($balance); ?></div>
</div>
<?php
	$qry = "SELECT * FROM `payments_paid` WHERE `bill_no` = '".$data['id']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
	?>
		<div class="row" style="width:95%;position:relative;margin:0 auto;">
			<div class="col-sm-2">Cash</div>
			<div class="col-sm-1 pointer" onclick="viewBill('<?php echo $data['bill_no'] ?>')">BILL-<?php echo $data2['bill_no']; ?></div>
			<div class="col-sm-1">--</div>
			<div class="col-sm-1 pointer" onclick="viewPayment('<?php echo $data2['id'] ?>')">PD-<?php echo $data2['id']; ?></div>
			<div class="col-sm-1"><?php echo $data2['paid_date']; ?></div>
			<div class="col-sm-2"><?php echo number_format($data2['amount']); ?></div>
			<div class="col-sm-2">--</div>
			<div class="col-sm-2"><?php $balance += floatval($data2['amount']); echo number_format($balance);
			$total_balance += floatval($data2['amount']); ?></div>
		</div>
	<?php
	}
	echo "<br>";
}
?>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2">Total</div>
	<div class="col-sm-2">Rs. <?php echo number_format($total_balance); ?></div>
</div>
<a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function printView(id)
{
	window.open("vendors/vendor_ledger_print.php?id="+id);
}
function viewPayment(id)
{
    pageLoad("vendors/payment_update.php?id="+id);
}

function viewBill(id)
{
	pageLoad("vendors/bill_detail.php?id="+id);
}
</script>
