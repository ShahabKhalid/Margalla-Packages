<div class="container addBox">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Expence Ledger</h1>
</div>
<?php
require "../123321.php";
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;"></span>
</div>
</div>
<div class="row">
	<div class="col-sm-9"></div>
	<div class="col-sm-2" style="text-align:right;"><b><a href="javascript:void()" onclick="exportExcel()">Export to excel</a></b></div>
	<div class="col-sm-1" style="text-align:left;"><b><a href="javascript:void()" onclick="printLedger()">Print</a></b></div>
</div>
<div class="row" style="border:1px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2" style="border:1px solid black;">Particular</div>
	<div class="col-sm-1" style="border:1px solid black;">Exp. #</div>
	<div class="col-sm-2" style="border:1px solid black;">Account</div>
	<div class="col-sm-1" style="border:1px solid black;">Date</div>
	<div class="col-sm-2" style="border:1px solid black;">Description</div>
	<div class="col-sm-1" style="border:1px solid black;">Debit</div>
	<div class="col-sm-1" style="border:1px solid black;">Credit</div>
	<div class="col-sm-2" style="border:1px solid black;">Balance</div>
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
	<div class="col-sm-2" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') echo "Petty Cash"; else echo "Expence"; ?></div>
  <div class="col-sm-1" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') echo "PC-"; else echo "EXP-"; echo $data['id']; ?></div>
	<div class="col-sm-2" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') echo "---"; else { if(strlen($data2['name']) > 13) echo substr($data2['name'],0,13)."..."; else echo $data2['name']; } ?></div>
	<div class="col-sm-1" style="border:1px solid black;"><?php echo $data['date']; ?></div>
	<div class="col-sm-2" style="border:1px solid black;"><?php if(strlen($data['description']) > 13) echo substr($data['description'],0,13)."..."; else echo $data['description']; ?></div>
	<div class="col-sm-1" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') { echo $data['amount']; $total += intval($data['amount']); } else  echo "---"; ?></div>
		<div class="col-sm-1" style="border:1px solid black;"><?php if($data['acc_id'] != '-1') { echo $data['amount']; $total -= intval($data['amount']); } else  echo "---"; ?></div>
	<div class="col-sm-2" style="border:1px solid black;"><?php echo "Rs. ".number_format(intval($total)); ?></div>
		</div>
	<?php
	}
?>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-3"></div>
	<div class="col-sm-6"></div>
	<div class="col-sm-1">Total</div>
	<div class="col-sm-2">Rs. <?php echo number_format($total); ?></div>
</div>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function printLedger()
{
	alert("Error: Too much fields to print! Please export to Excel and print!");
	//window.open("expences/ledger_print.php?id="+id);
}


function exportExcel()
{
	window.open("expences/ledger_export.php");
}
</script>
