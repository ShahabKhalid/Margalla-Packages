<!DOCTYPE HTML>
<html>
<head>
<title>Invoice List</title>
<link rel="shortcut icon" type="image/png" href="../../favicon.png">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<style>
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm;}
}
</style>
</head>
<body onload="init()" style="background-color:white;">
<br>
<?php
require "../123321.php";
?>
<div class="container" style="position:relative;left:-50px;width:800px;">
<div>
<div class="row">
<div class="col-xs-8">
<img style="width:800px;" src="logo.jpg">
</div>
<div class="col-xs-4 text-right">
<span style="font-size:20px;"></span></div>
</div>
</div>
<br><br>
<div class="row">
<div class="col-xs-12">
<h1 class="text-center" >Invoice List</h1>
<br>
</div>

</div>
<div class="row row_inv" style="background-color:rgba(0,0,0,.7);color:white;">
	<div class="col-md-6">
		<div class="row">
			<div class="col-xs-1 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;">Sr.</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;" onclick="updateInvoiceList('date')">Date</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;" onclick="updateInvoiceList('no')">Inv. #<br>/Ref #</div>
			<div class="col-xs-3 border3 head_"  style="border:1px solid black;height:60px;padding-left:2px;" onclick="updateInvoiceList('cName')">Party Name</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;" onclick="updateInvoiceList('eName')">Sales Rep.</div>
			<div class="col-xs-2 border3 head_">Weight / Pieces</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;" >Block Charges</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;">0. Charge</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;">Total</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;">Advance</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;">Balance</div>
			<div class="col-xs-2 border3 head_" style="border:1px solid black;height:60px;padding-left:2px;">Payment(s)</div>
		</div>
	</div>
</div>
<?php
function getDays($date,$paymentTime)
{
	list($year, $month, $day) = explode('-', $date);
	$currentdate = date("Y-m-d");
	list($c_year, $c_month, $c_day) = explode('-', $currentdate);
	$d_year = intval($year) - intval($c_year);
	$d_month = intval($month) - intval($c_month);
	$d_day = intval($day) - intval($c_day);

	$d = $d_day + $d_month * 30 + $d_year * 356 + $paymentTime;
	return $d;

}
$filter_qry = "";
$overTime = 0;
$todaysInvoice = 0;
$filterCustomer = 0;
$filterSaleRep = 0;
if(isset($_GET['f_inv'])) $filter_qry .= "and `no` LIKE '".$_GET['f_inv']."%'";
if(isset($_GET['f_ref'])) $filter_qry .= "and `id` LIKE '".$_GET['f_ref']."%'";
if(isset($_GET['f_date'])) $filter_qry .= "and `date` LIKE '".$_GET['f_date']."%'";
if(isset($_GET['f_overTime'])) $overTime = 1;
if(isset($_GET['f_todaysInvoice'])) $todaysInvoice = 1;
if(isset($_GET['f_customer'])) $filterCustomer = 1;
if(isset($_GET['f_salerep'])) $filterSaleRep = 1;

$qry = "SELECT i.*,c.name as cName,e.name eName,c.paymentMethod as payMethod FROM `invoice` i,`customers` c,`employee` e WHERE i.customer = c.id and i.salerep = e.id ".$filter_qry." order by `".$_GET['orderBy']."` ";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;

while($row = mysqli_fetch_array($run))
{
	
	if($count % 2 != 0) { $color = "rgba(0,0,0,0.05)"; }
	else { $color = "rgba(0,0,0,0.15)"; }
	$dayDif = getDays($row['date'],$row['paymentTime']);


	$qry2 = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$row['no']."'";
	$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
	$total_weight = 0;
	$total_rate = 0;
	$total_blockCharges = 0;
	$total_otherCharges = 0;
	$total_ = 0;
	while($row2 = mysqli_fetch_array($run2))
	{
		$total_weight += floatval($row2['weices']);
		$total_rate += floatval($row2['rate']);
		if($row2['exp_name'] == "Block") {
			$total_blockCharges += floatval($row2['charges']);
		}
		else {
			$total_otherCharges += floatval($row2['charges']);
		}
		$total_here = floatval($row2['weices']) * floatval($row2['rate']) + floatval($row2['charges']);
		$total_ += $total_here;
	}
	$advance = 0;
	$qry2 = "SELECT * FROM `payments_recv` WHERE `inv_no` = '".$row['no']."'";
	$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
	$total_amount = 0;
	while($row2 = mysqli_fetch_array($run2))
	{
		if(intval($row2['advance']) == 0 )$total_amount += floatval($row2['amount']);
		else $advance += floatval($row2['amount']);
	}


	if($filterCustomer == 1)
	{
		$pos = strpos($row['cName'], $_GET['f_customer']);
		if($pos === false)
			continue;
	}

	if($row['paymentTime'] > '0' && $dayDif < 0 && $total_ - $advance - $total_amount > 0 && intval($row['payMethod']) == 0)
	{
		$color = "rgba(255,0,0,0.5);font-weight:bold";
	}


	if($total_ - $advance - $total_amount == 0)
	{
		$color = "rgba(0,255,0,0.1);color:green";
	}
	if(intval($row['payMethod']) == 1)
	{
		$color = "rgba(0,0,255,0.1);color:rgba(0,0,255,0.7)";
	}
	if($overTime == 1)
		if(!($dayDif < 0 && $total_ - $advance - $total_amount > 0 && floatval($row['payMethod']) == 0))
			continue;

	if($todaysInvoice == 1)
		if($row['date'] != date("d-m-Y"))
			continue;



	if(isset($_GET['f_b2b']))
		if(intval($row['payMethod']) == 0)
			continue;


	if($filterSaleRep == 1)
	{
		$pos = strpos($row['eName'], $_GET['f_salerep']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_weight']))
	{
		$pos = strpos($total_weight, $_GET['f_weight']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_blockCharge']))
	{
		$pos = strpos($total_blockCharges, $_GET['f_blockCharge']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_otherCharge']))
	{
		$pos = strpos($total_otherCharges, $_GET['f_otherCharge']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_total']))
	{
		$pos = strpos($total_, $_GET['f_total']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_advance']))
	{
		$pos = strpos($advance, $_GET['f_advance']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_balance']))
	{
		$balance = $total_ - $advance - $total_amount;
		$pos = strpos($balance, $_GET['f_balance']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_payment']))
	{
		$pos = strpos($total_amount, $_GET['f_payment']);
		if($pos === false)
			continue;
	}


	if($row['date'] <= "2016-09-19" && $row['paymentTime'] < '1')
	{
		$color = "rgba(255,255,0,0.2);font-weight:bold";
	}

	?>
	<div class="row row_inv" id="inv_data"  style="background-color:<?php echo $color; ?>">
	<div class="col-md-6">
	<div class="row">
	<div onclick="printInvoice('<?php echo $row['id'] ?>')">
	<div class="col-xs-1 no-border" style="border:1px solid black;height:60px;font-size:10px;padding-left:2px;"><?php echo $count; ?></div>
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;padding-left:2px;font-size:10px;"><?php echo $row['date']; if($row['paymentTime'] > '0' && $dayDif < 0 && $total_ - $advance - $total_amount > 0 && intval($row['payMethod']) == 0) echo " (".($dayDif*-1).")"; ?></div>
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;padding-left:2px;"><span style='font-size:10px;'><?php echo $row['no']."<br>/".$row['id']; ?></span></div>
	<div class="col-xs-3 no-border" style="border:1px solid black;height:60px;"><?php

	if(strlen($row['cName']) > 20) echo "<span style='font-size:12px;'>".substr($row['cName'],0,20)."..."."</span>"; else echo "<span style='font-size:12px;'>".$row['cName']."</span>"; 
	?></div>
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;"><?php

	 if(strlen($row['eName']) > 30) echo "<span style='font-size:12px;'>".substr($row['eName'],0,30)."..."."</span>"; else echo "<span style='font-size:12px;'>".$row['eName']."</span>"; 
	?></div>

	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;"><?php echo $total_weight;
	if($row['rateby'] == "1") echo " (P) ";
	else echo " (Kg) ";
	?>
	</div>
	</div>
	</div>
	</div>
	<div class="col-md-6">
	<div class="row">
	<div onclick="printInvoice('<?php echo $row['id'] ?>')">
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;">Rs. <?php echo $total_blockCharges; ?></div>
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;">Rs. <?php echo $total_otherCharges; ?></div>
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;">Rs. <?php echo $total_; ?></div>
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;">Rs. <?php echo $advance; ?></div>
	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;">Rs. <?php echo $total_ - $advance - $total_amount; ?></div>

	<div class="col-xs-2 no-border" style="border:1px solid black;height:60px;">Rs. <?php
	echo $total_amount;
	?></div>
	</div>

	</div>
	</div>
	</div>
	<?php
	$count++;
}
?>
</div><br>
<script>
function init() {
    //window.print();
    //window.close();
}
</script>
</body>
