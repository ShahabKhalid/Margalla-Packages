<div class="container addBox">
<div class="inBox">
<h1>Invoice</h1>
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
$inv_id = $refNo;
$qry = "SELECT * FROM `customers` WHERE `id` = '".$row['customer']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row2 = mysqli_fetch_array($run);
$custid = $row2['id'];
$custName = $row2['name'];

$qry = "SELECT * FROM `employee` WHERE `id` = '".$row['salerep']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row2 = mysqli_fetch_array($run);
$sRepId = $row['salerep'];
$sRepName = $row2['name'];
?>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><span style="font-size:20px;"><b>Invoice Number: </b>INV-<?php echo $inv_no; ?></span></div>
</div>
<br>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><span style="font-size:20px;"><b>Ref Number: </b><?php echo $refNo; ?></span></div>
</div>
<div class="row">
	<div class="col-sm-4"><span style="font-size:20px;"><b>Customer</b><br>( <?php echo $custName; ?> )</span></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
</div><br>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><span style="font-size:20px;"><b>Sale Rep</b><br>( <?php echo $sRepName; ?> )</span></div>
</div>
<br>
<div class="row" id="r3" style="background-color:rgba(0,0,0,0.7);color:white;">
	<div class="col-md-3">Particulars</div>
	<div class="col-md-1">Material</div>
	<div class="col-md-2">Bags</div>
	<div class="col-md-2">Weight</div>
	<div class="col-md-2">Rate</div>
	<div class="col-md-2">Amount</div>
</div>
<?php
$qry2 = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$inv_no."' order by `exp_name`";
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
<div class="row" id="r3" style="border-top:1px solid black;">
	<div class="col-md-3" style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;">
	-	
	</div>
	<div class="col-md-1" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">Rs.
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
	<div class="col-md-3" style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;">
	<?php
		if($row2['exp_name'] == "--") echo "BAG SIZE ".$row2['size'];
		else echo $row2['exp_name']." Charges";
	?>
	</div>
	<div class="col-md-1" style="border-right:1px solid black;border-bottom:1px solid gray;">
	<?php
		if($row2['exp_name'] == "--") echo $row2['material'];
		else echo "--";
	?>
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	<?php
		if($row2['exp_name'] == "--") { echo $row2['bag']; $total_bag += floatval($row2['bag']); }
		else echo "--";
	?>
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	<?php
	if($row2['exp_name'] == "--") { echo $row2['weices']; $total_weight += floatval($row2['weices']); }
	else echo "--";
	?>
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	<?php
	if($row2['exp_name'] == "--") echo $row2['rate'];
	else echo "--";
	?>
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
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
<div class="row" id="r3" style="border-top:1px solid black;">
	<div class="col-md-3" style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-1" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">
	-
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">Rs.
	<?php echo floatval($total); $all_total += $total; ?>
	</div>
</div>
<br><br>
<?php
$qry = "SELECT * FROM payments_recv WHERE inv_no = '".$inv_no."' and advance = '1'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($row = mysqli_fetch_array($run))
{
?>
<div class="row" id="r3" style="border-top:1px solid black;">
	<div class="col-md-3" style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;">Advance
	</div>
	<div class="col-md-1" style="border-right:1px solid black;border-bottom:1px solid gray;">--
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">--
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">--
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">--
	</div>
	<div class="col-md-2" style="border-right:1px solid black;border-bottom:1px solid gray;">Rs. <?php echo $advance = $row['amount']; ?>
	</div>
</div>
<?php
}
 ?>
<br>
<div class="row" id="r3" style="border-top:2px solid black;">
	<div class="col-md-3">
		TOTAL
	</div>
	<div class="col-md-1">

	</div>
	<div class="col-md-2">
		<?php echo $total_bag; ?>
	</div>
	<div class="col-md-2">
		<?php echo $total_weight; ?>
	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">Rs.
	<?php echo floatval($all_total) - floatval($advance); ?>
	</div>
</div>
<br><br>
<a href="javascript:void()" onclick="return printViewNo('<?php echo $inv_no; ?>')">Print</a> | 
<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/invoice_update.php') !== false) { ?>
<a href="javascript:void()" onclick="return pageLoad('customers/invoice_update.php?no=<?php echo $inv_no; ?>')">Update</a> <?php } ?> | 
<a href="javascript:void()" onclick="return pageLoad('customers/customer_ledger.php?id=<?php echo $custid; ?>')">Back to Ledger</a>  | 
<a href="javascript:void()" onclick="return pageLoad('employees/profitSheet.php?id=<?php echo $sRepId; ?>')">Sale Rep. ProfitSheet</a>
<br>
<br>
</div>
</div>
<script>
function printView(id)
{
	window.open("customers/invoice_print_window.php?id="+id);
}


function printViewNo(no)
{
	window.open("customers/invoice_print_window.php?no="+no);
}

</script>
