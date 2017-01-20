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
$bill_id = $_GET['id'];
$qry = "SELECT b.*,v.name as vName FROM `bill` b,`vendor` v WHERE b.vendor = v.id and b.id = '".$bill_id."' LIMIT 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row = mysqli_fetch_array($run);
?>
<div class="container" style="position:relative;left:-40px;">
<img src="../../favicon.png" id="bg">
<div class="row">
<div class="col-sm-8">
<img style="width:800px;" src="../../images/logo.jpg">
</div>
<div class="col-sm-4 text-right"><h1 style="font-weight:bolder;">BILL</h1>
<span style="font-size:20px;"><b>Bill #: </b>BILL-<?php echo $bill_id; ?><br><b>Date: </b><?php echo $row['date']; ?></span></div>
</div>
<br>
<br>
<div class="row">
	<div class="col-sm-1"><span style="font-size:20px;"><b>Mob: </b></span></div>
	<div class="col-sm-3 text-left"><span style="font-size:20px;"><b>0333-5552099<br>0300-5552099</b></span></div>
		<div class="col-sm-1"><span style="font-size:20px;"><b>PTCL:</b></span></div>
	<div class="col-sm-3 text-left"><span style="font-size:20px;"><b>051-4448811</b></span></div>
	<div class="col-sm-4 text-center"></div>
</div>
<br>
<br>
<br>
<div class="row">
	<div class="col-sm-4 text-center"><span style="font-size:20px;"><b>Vendor</b><br>( <?php echo $row['vName']; ?> )</span></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><br><span style="font-size:20px;"><b>Ref Number: </b><?php echo $row['ref']; ?></span></div>
</div><br>
<br>
<div class="row" id="r3" style="background-color:rgba(0,0,0,0.7);color:white;border-bottom:2px solid black;">
	<div class="col-md-2">Sub Ref #</div>
	<div class="col-md-2">Billing Name</div>
	<div class="col-md-2">Particular</div>
	<div class="col-md-2">Weight/Size</div>
	<div class="col-md-2">Rate</div>
	<div class="col-md-2">Bill Amount</div>
</div>
<?php
$qry2 = "SELECT bd.*,c.name as cName FROM `bill_detail` bd,`customers` c WHERE bd.biller_id = c.id and bd.ref = '".$row['ref']."' order by bd.ref2";
$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
$oldExp = "";
$newExp = "";
$first = 0;
$same = 0;
$total = 0;
$all_total = 0;
while($row2 = mysqli_fetch_array($run2))
{
$newExp = $row2['ref2'];
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
<div class="row" id="r3" style="border-top:1px solid black;">
	<div class="col-md-3">

	</div>
	<div class="col-md-1">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">Rs. 
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
	<div class="col-md-2">
	<?php 
		echo $row2['ref2'];
	?>	
	</div>
	<div class="col-md-2">
	<?php 
		echo $row2['cName']; 
	?>	
	</div>
	<div class="col-md-2">
	<?php
		echo $row2['particular']; 
	?>
	</div>
	<div class="col-md-2">
	<?php
	echo $row2['weices']; 
	?>
	</div>
	<div class="col-md-2">
	<?php
	echo $row2['rate']; 
	?>
	</div>
	<div class="col-md-2">
	<?php
		echo "Rs. ".intval($row2['weices']) * intval($row2['rate']); 
		$total += intval($row2['weices']) * intval($row2['rate']);
	?>
	</div>
</div>
<?php
$oldExp = $newExp;
$first = 1;
}
?>
<div class="row" id="r3" style="border-top:1px solid black;">
	<div class="col-md-3">

	</div>
	<div class="col-md-1">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">Rs. 
	<?php echo $total; $all_total += $total; ?>
	</div>
</div>
<br><br><br>
<div class="row" id="r3" style="border-top:2px solid black;">
	<div class="col-sm-3">

	</div>
	<div class="col-sm-1">

	</div>
	<div class="col-sm-2">

	</div>
	<div class="col-sm-2">

	</div>
	<div class="col-sm-2">
	Total
	</div>
	<div class="col-sm-2">Rs. 
	<?php echo $all_total; ?>
	</div>
</div>
<br><br>
<br>
<br>
<div class="row">
	<div class="col-sm-4 text-left"><span style="font-size:20px;"><b>Sheikh  Zubair Sb.<br>(C.E.O)</b></span></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
</div><br>
<div class="row">
	<div class="col-sm-12 text-center"><span style="font-size:20px;">Computerized print for bill!</span></div>
</div><br>
</div>
<script>
function init() {
    window.print();
    window.close();
}
</script>
</body>