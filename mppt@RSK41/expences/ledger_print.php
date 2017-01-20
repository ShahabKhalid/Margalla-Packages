<!DOCTYPE HTML>
<html>
<head>
<title>Expence Ledger</title>
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
?>
<div class="container" style="position:relative;left:-40px;">
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
<div class="col-xs-10">
<h1 class="text-center" >Expence Ledger</h1>
</div>

</div>
<div class="row" style="border:1px solid black;height:50px;width:95%;position:relative;margin:0 auto;">
	<div class="col-xs-2" style="border:1px solid black;height:50px;">Particular</div>
	<div class="col-xs-1" style="border:1px solid black;height:50px;">Exp. #</div>
	<div class="col-xs-2" style="border:1px solid black;height:50px;">Account</div>
	<div class="col-xs-1" style="border:1px solid black;height:50px;">Date</div>
	<div class="col-xs-2" style="border:1px solid black;height:50px;">Description</div>
	<div class="col-xs-1" style="border:1px solid black;height:50px;">Debit</div>
	<div class="col-xs-1" style="border:1px solid black;height:50px;">Credit</div>
	<div class="col-xs-2" style="border:1px solid black;height:50px;">Balance</div>
</div>
<?php
$qry = "SELECT e.* FROM `expences` e WHERE 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total = 0;
while($data = mysqli_fetch_array($run))
{
if($data['acc_id'] != '-1')
{
	$qry = "SELECT name FROM `expAccounts` a WHERE a.id = '".$data['acc_id']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data2 = mysqli_fetch_array($run2);
}
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-xs-2" style="border:1px solid black;height:50px;"><?php if($data['acc_id'] == '-1') echo "Petty Cash"; else echo "Expence"; ?></div>
  <div class="col-xs-1" style="border:1px solid black;height:50px;"><?php if($data['acc_id'] == '-1') echo "PC-"; else echo "EXP-"; echo $data['id']; ?></div>
	<div class="col-xs-2" style="border:1px solid black;height:50px;"><?php if($data['acc_id'] == '-1') echo "---"; else { if(strlen($data2['name']) > 13) echo substr($data2['name'],0,13)."..."; else echo $data2['name']; } ?></div>
	<div class="col-xs-1" style="border:1px solid black;height:50px;"><?php echo $data['date']; ?></div>
	<div class="col-xs-2" style="border:1px solid black;height:50px;"><?php if(strlen($data['description']) > 13) echo substr($data['description'],0,13)."..."; else echo $data['description']; ?></div>
	<div class="col-xs-1" style="border:1px solid black;height:50px;"><?php if($data['acc_id'] == '-1') { echo $data['amount']; $total += intval($data['amount']); } else  echo "---"; ?></div>
		<div class="col-xs-1" style="border:1px solid black;height:50px;"><?php if($data['acc_id'] != '-1') { echo $data['amount']; $total -= intval($data['amount']); } else  echo "---"; ?></div>
	<div class="col-xs-2" style="border:1px solid black;height:50px;"><?php echo "Rs. ".number_format(intval($total)); ?></div>
		</div>
	<?php
	}
?>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-xs-3"></div>
	<div class="col-xs-6"></div>
	<div class="col-xs-1">Total</div>
	<div class="col-xs-2">Rs. <?php echo number_format($total); ?></div>
</div>
<br><br>
</div><br>
<script>
function init() {
    //window.print();
    //window.close();
}
</script>
</body>
