<!DOCTYPE HTML>
<html>
<head>
<title>Margalla Packages Islamabad</title>
<link rel="shortcut icon" type="image/png" href="../../favicon.png">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<style>
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; }
}
</style>
</head>
<body onload="init()" style="background-color:white;">
<br>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `vendor` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<div class="container" style="position:relative;left:-40px;">
<div>
<div class="row">
<div class="col-sm-8">
<img style="width:800px;" src="../../images/logo.jpg">
</div>
<div class="col-sm-4 text-right">
<span style="font-size:20px;"><b>ID: </b> MPV-<?php echo $id; ?></span></div>
</div>
</div>
<br><br>
<div class="row">
<div class="col-md-10">
<h1 class="text-center" >Vendor Ledger</h1>
</div>

</div>
<div style="position:relative;left:20px;">
<label style="font-size:18px;">Name: </label><span style="font-size:18px;"><?php echo " ".$data['name']; ?></span><br>
<label style="font-size:18px;">Contact # </label><span style="font-size:18px;"><?php echo " ".$data['contact']; ?></span><br>
<label style="font-size:18px;">Address: </label><span style="font-size:18px;"><?php echo " ".$data['address']; ?></span><br>
</div>
<div class="row" style="font-size:14px;border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
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
<div class="row" style="font-size:14px;border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2 text-right"></div>
	<div class="col-sm-1 text-right"></div>
	<div class="col-sm-1 text-right"></div>
	<div class="col-sm-1 text-right"></div>
	<div class="col-sm-2 text-right"></div>
	<div class="col-sm-2 text-right">Total</div>
	<div class="col-sm-2 text-right" style="padding-right:30px;">Rs. <?php echo $total_balance; ?></div>
</div>
</div><br>
<script>
function init() {
    window.print();
    window.close();
}
</script>
</body>
