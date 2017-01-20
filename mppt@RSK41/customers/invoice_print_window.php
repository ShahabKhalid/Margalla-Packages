<!DOCTYPE HTML>
<html>
<head>
<title>Margalla Packages Islamabad</title>
<link rel="shortcut icon" type="image/png" href="../../favicon.png">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; width: 800px; }

tr.vendorListHeading {
    background-color: #1a4567 !important;
    -webkit-print-color-adjust: exact;
}
    .vendorListHeading th {
    color: white !important;
}}



#bg
{
	position: absolute;
	top:40%;
	left:5%;
	width: 800px;
	height: 400px;
	opacity: 0.1;
}

</style>
</head>
<body onload="init()" style="background-color:white;">
<?php
require "../123321.php";
if(isset($_GET['id'])) {
$inv_id = $_GET['id'];
$qry = "SELECT * FROM `invoice` WHERE `id` = '$inv_id'";
}
else if(isset($_GET['no'])) {
$inv_no = $_GET['no'];
$qry = "SELECT * FROM `invoice` WHERE `no` = '$inv_no'";
}
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row = mysqli_fetch_array($run);
$date = $row['date'];
$rateby = $row['rateby'];
$advance = $row['advance'];
$inv_no = $row['no'];
$refNo = $row['id'];
$qry = "SELECT * FROM `customers` WHERE `id` = '".$row['customer']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row2 = mysqli_fetch_array($run);
$custID = $row2['id'];
$custName = $row2['name'];

$qry = "SELECT * FROM `employee` WHERE `id` = '".$row['salerep']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row2 = mysqli_fetch_array($run);
$sRepName = $row2['name'];
?>
<div class="container" style="position:relative;left:-40px;">
<img src="favicon.png" id="bg">
<div class="row">
<div class="col-sm-8">
<img style="width:800px;" src="logo.jpg">
</div>
<div class="col-sm-4 text-right"><h1 style="font-weight:bolder;">INVOICE</h1>
<span style="font-size:14px;"><b>Invoice #: </b>INV-<?php echo $inv_no; ?><br><b>Date: </b><?php echo $date; ?></span></div>
</div>
<div class="row">
  <br>
	<div class="col-sm-1"><span style="font-size:14px;"><b>Mob: </b></span></div>
	<div class="col-sm-3 text-left"><span style="font-size:14px;"><b>0333-5552099<br>0300-5552099</b></span></div>
		<div class="col-sm-1"><span style="font-size:14px;"><b>PTCL:</b></span></div>
	<div class="col-sm-3 text-left"><span style="font-size:14px;"><b>051-4575289<br>051-4575290</b></span></div>
	<div class="col-sm-4 text-right"><span style="font-size:14px;"><b>Sale Rep</b><br>( <?php echo $sRepName; ?> )</span></div>
</div>
<br>
<div class="row">
	<div class="col-sm-4 text-center"><span style="font-size:14px;"><b>Customer MPC-<?php echo $custID; ?></b><br>( <?php echo $custName; ?> )</span></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4 text-right"><br><span style="font-size:14px;"><b>Ref Number: </b><?php echo $refNo; ?></span></div>
</div><br>
<div class="row" id="r3" style="background-color:rgba(0,0,0,0.7);color:white;border-bottom:2px solid black;">
	<div class="col-sm-3"><b>Particulars</b></div>
	<div class="col-sm-1"><b>Material</b></div>
	<div class="col-sm-2"><b>Bags</b></div>
	<div class="col-sm-2"><b>Weight</b></div>
	<div class="col-sm-2"><b>Rate</b></div>
	<div class="col-sm-2 text-right"><b>Amount</b></div>
</div>
<div style="min-height:400px;">
<?php
$qry2 = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$row['no']."' order by `exp_name`";
$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
$oldExp = "";
$newExp = "";
$first = 0;
$same = 0;
$total = 0;
$all_total = 0;
$total_weight = 0;
$total_bag = 0;
while($row2 = mysqli_fetch_array($run2))
{
$newExp = $row2['exp_name'];
if($first == 0){
$same = 1;
}
else
{
	if($newExp == $oldExp) $same = 1;
	else $same = 0;
}
if($same == 0)
{
?>
<div class="row" id="r3" >
	<div class="col-xs-3" style="border:1px solid black;">

	</div>
	<div class="col-xs-1" style="border:1px solid black;">

	</div>
	<div class="col-xs-2" style="border:1px solid black;">

	</div>
	<div class="col-xs-2" style="border:1px solid black;">

	</div>
	<div class="col-xs-2" style="border:1px solid black;">

	</div>
	<div class="col-xs-2" style="border:1px solid black;">Rs.
	<?php echo $total; $all_total += $total; ?>
	</div>
</div>
<br>
<?php
$total = 0;
$same = 1;
}
?>
<div class="row" id="r3">
	<div class="col-xs-3" style="border:1px solid black;">
	<?php
		if($row2['exp_name'] == "--") echo "BAG SIZE ".$row2['size'];
		else echo $row2['exp_name']." Charges";
	?>
	</div>
	<div class="col-xs-1" style="border:1px solid black;">
	<?php
		if($row2['exp_name'] == "--") echo $row2['material'];
		else echo "--";
	?>
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
	<?php
		if($row2['exp_name'] == "--") { echo $row2['bag']; $total_bag += floatval($row2['bag']); }
		else echo "--";
	?>
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
	<?php
	if($row2['exp_name'] == "--") { echo $row2['weices']; $total_weight += floatval($row2['weices']); }
	else echo "--";
	?>
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
	<?php
	if($row2['exp_name'] == "--") echo $row2['rate'];
	else echo "--";
	?>
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
	<?php
		if($row2['exp_name'] == "--") { echo "Rs. ".floatval($row2['weices']) * floatval($row2['rate']);
			if($same == 1) $total += floatval($row2['weices']) * floatval($row2['rate']);
		}
		else { echo "Rs. ".$row2['charges'];
			if($same == 1) $total += floatval($row2['charges']);
		}
	?>
	</div>
</div>
<?php
$oldExp = $newExp;
$first = 1;
}
?>
<div class="row" id="r3">
	<div class="col-xs-3" style="border:1px solid black;">
	--
	</div>
	<div class="col-xs-1" style="border:1px solid black;">
--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">Rs.
	<?php echo floatval($total); $all_total += $total; ?>
	</div>
</div>
<?php
$qry = "SELECT * FROM payments_recv WHERE inv_no = '".$inv_no."' and advance = '1'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($row = mysqli_fetch_array($run))
{
?>
<div class="row" id="r3">
	<div class="col-xs-3" style="border:1px solid black;">Advance
	</div>
	<div class="col-xs-1" style="border:1px solid black;">--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">--
	</div>
	<div class="col-xs-2" >Rs. <?php echo $advance = $row['amount']; ?>
	</div>
</div>
<?php
}
 ?>
<div class="row" id="r3">
	<div class="col-xs-3" style="border:1px solid black;"> 
		TOTAL
	</div>
	<div class="col-xs-1" style="border:1px solid black;">
	--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
		<?php echo $total_bag; ?>
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
		<?php echo $total_weight; ?>
	</div>
	<div class="col-xs-2" style="border:1px solid black;">
	--
	</div>
	<div class="col-xs-2" style="border:1px solid black;">Rs.
	<?php echo floatval($all_total) - floatval($advance); ?>
	</div>
</div><br><br>
<div style="position:fixed;bottom:0px;width:100%;left:0px;">
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-4"><span style="font-size:14px;"><b>Sheikh  Zubair Sb.<br>(C.E.O)</b></span></div>
	<div class="col-sm-6"></div>
</div><br><br>
<div class="row">
	<div class="col-sm-12 text-center"><span style="font-size:14px;">Bags will deliver within 10 days after placing your order<br>
	Thankyou for your business</span></div>
</div><br>
</div>
<script>
function init() {
    window.print();
    window.close();
}
</script>
</body>
