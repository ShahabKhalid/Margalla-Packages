<!DOCTYPE HTML>
<html>
<head>
<title>Margalla Packages Islamabad</title>
<link rel="shortcut icon" type="image/png" href="../../favicon.png">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<style>
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm;  }
}
</style>
</head>
<body onload="init()" style="background-color:white;">
<br>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `customers` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$open_balance = $data['opening_balance'];
?>
<div class="container" style="position:relative;left:-40px;">
<div>
<div class="row">
<div class="col-sm-4">
<img style="width:300px;" src="logo.jpg">
</div>
<div class="col-sm-4">
<h1 class="text-center" style="font-size:18px;font-weight:bold;"><u>Customer Ledger</u></h1>
</div>
<div class="col-sm-4 text-right">
<span style="font-size:20px;"><b>ID: </b> MPC-<?php echo $id; ?></span></div>
</div>
</div>
<br>
<div class="row" style="position:relative;left:80px;">
<label style="font-size:18px;">Name: </label><span style="font-size:18px;"><?php echo " ".$data['name']; ?></span>
<label style="font-size:18px;">Contact # </label><span style="font-size:18px;"><?php echo " ".$data['contact']; ?></span>
<label style="font-size:18px;">Address: </label><span style="font-size:18px;"><?php echo " ".$data['address']; ?></span>
</div>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2 bold">Particular</div>
	<div class="col-sm-1 bold">Inv</div>
	<div class="col-sm-1 bold">Pay</div>
	<div class="col-sm-2 bold">Date</div>
	<div class="col-sm-2 bold">Debit</div>
	<div class="col-sm-2 bold">Credit</div>
	<div class="col-sm-2 bolds">Balance</div>
</div>
<div class="row" style="font-size:12px;border-bottom:1px dotted gray;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-10 bold" style="padding-left:5px;">Opening Balance</div>
	<div class="col-sm-2 bold" style="padding-left:5px;">Rs. <?php echo floatval($open_balance); ?></div>
</div>
<?php
$qry = "DELETE FROM `tmp` WHERE 1 ";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
						SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.no,i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.no = idd.ref and i.date <= '2017-01-01' GROUP BY idd.ref ) sub, invoice i,customers c WHERE i.no = sub.no and c.id = i.customer and c.id = '".$id."'";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv WHERE `rec_date` <= '2017-01-01' and `customer` = '".$id."'";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "SELECT * FROM tmp order by date;";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$balanace = 0;
$total_balance = $open_balance;
$prev_inv_no = 0;
$total_of_inv = 0;
$total_of_pay = 0;
while($data = mysqli_fetch_array($run))
{
if($prev_inv_no !== $data['id'])
{
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;font-size:12px;">
<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "invoice") echo "Bill"; else echo "Cash"; ?></div>
<div class="col-sm-1 pointer" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "invoice") echo $data['id']; else echo "---";?></div>
<div class="col-sm-1" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "pay") echo $data['ref']; else echo "---"; ?></div>
<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php  echo substr($data['date'],2); ?></div>
<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "invoice") { echo "Rs. ".floatval($data['amount']); $total_of_inv += floatval($data['amount']); $total_balance += floatval($data['amount']); } else echo "---"; ?></div>
<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "pay") { echo "Rs. ".floatval($data['amount']); $total_of_pay += floatval($data['amount']); $total_balance -= floatval($data['amount']); } else echo "---"; ?></div>
<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;">Rs. <?php echo $total_balance; ?></div>
</div>
<?php
if($data['type'] == "invoice") $prev_inv_no = $data['id'];
else $prev_inv_no = 0;
}
}
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
</div>
<?php
$qry = "DELETE FROM `tmp` WHERE 1 ";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "SELECT * FROM `invoice` WHERE `customer` = '$id' and `date` > '2017-01-01'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));

while($data = mysqli_fetch_array($run))
{
$advance = floatval($data['advance']);
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;">Bill</div>
	<div class="col-sm-1 pointer" style="border-right:1px solid black;border-bottom:1px solid gray;" onclick="viewInvoice('<?php echo $data['id'] ?>')"><?php echo $data['no'] ?></div>
	<div class="col-sm-1" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php echo substr($data['date'],2) ?></div>
	<div class="col-sm-1" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;">--</div>
	<div class="col-sm-1" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;">--</div>
	<?php
	$qry = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$data['no']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
		if($data2['exp_name'] != "--") {
			$total += floatval($data2['charges']);
			$total_of_inv += floatval($data2['charges']);
		}
		else
		{
			$total += floatval($data2['weices']) * floatval($data2['rate']);
			$total_of_inv += floatval($data2['weices']) * floatval($data2['rate']);

		}
	}
	?>
	<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php echo $total; ?></div>
	<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;">--</div>
	<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php $balance = $total; $total_balance += $balance; echo abs($balance); ?></div>
</div>
<?php
	$qry = "SELECT * FROM `payments_recv` WHERE `inv_no` = '".$data['no']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
	?>
		<div class="row" style="width:95%;position:relative;margin:0 auto;">
			<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;">Cash</div>
			<div class="col-sm-1 pointer" style="border-right:1px solid black;border-bottom:1px solid gray;" onclick="viewInvoice('<?php echo $data['id'] ?>')"><?php echo $data2['inv_no']; ?></div>
			<div class="col-sm-1" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;">--</div>
			<div class="col-sm-1 pointer" style="border-right:1px solid black;border-bottom:1px solid gray;" onclick="viewPayment('<?php echo $data2['id'] ?>')"><?php if(floatval($data2['advance']) == 0) echo "PY-"; else echo "AD-"; echo $data2['id']; ?></div>
			<div class="col-sm-1" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php echo $data2['rec_date']; ?></div>
			<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;">--</div>
			<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php echo $data2['amount']; ?></div>
			<div class="col-sm-2" style="padding-left:5px;border-right:1px solid black;border-bottom:1px solid gray;"><?php $balance += floatval($data2['amount']); echo abs($balance);
			$total_of_pay += floatval($data['amount']);
			$total_balance -= floatval($data2['amount']); ?></div>
		</div>
	<?php
	}
	echo "<br>";
}
?>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2" style="padding-left:5px;">Total</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2" style="padding-left:5px;">Rs <?php echo $total_of_inv; ?></div>
	<div class="col-sm-2" style="padding-left:5px;">Rs <?php echo $total_of_pay; ?></div>
	<div class="col-sm-2" style="padding-left:5px;">Rs. <?php echo $total_balance; ?></div>
</div>
</div><br>
<script>
function init() {
    window.print();
    window.close();
}
</script>
</body>
