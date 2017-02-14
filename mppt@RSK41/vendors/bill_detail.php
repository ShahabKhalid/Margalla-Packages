<div class="container addBox">
<div class="inBox"> 
<h1>Bill</h1>
<?php 
require "../123321.php";
$bill_id = $_GET['id'];
$qry = "SELECT b.*,v.name as vName FROM `bill` b,`vendor` v WHERE b.vendor = v.id and b.id = '".$bill_id."' LIMIT 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row = mysqli_fetch_array($run);
?>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><span style="font-size:20px;"><b>Bill Number: </b>Bill-<?php echo $row['id']; ?></span></div>
</div>
<br>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><span style="font-size:20px;"><b>Ref Number: </b><?php echo $row['ref']; ?></span></div>
</div>
<div class="row">
	<div class="col-sm-4"><span style="font-size:20px;"><b>Date</b><br>( <?php echo $row['date']; ?> )</span></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
</div><br>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4"></div>
	<div class="col-sm-4"><span style="font-size:20px;"><b>Vendor</b><br>( <?php echo $row['vName']; ?> )</span></div>
</div>
<br>
<div class="row" id="r3" style="background-color:rgba(0,0,0,0.7);color:white;">
	<div class="col-md-2">Sub Ref #</div>
	<div class="col-md-2">Billing Name</div>
	<div class="col-md-2">Particular</div>
	<div class="col-md-2">Weight/Size</div>
	<div class="col-md-2">Rate</div>
	<div class="col-md-2">Bill Amount</div>
</div>
<?php
$qry2 = "SELECT bd.*,c.name as cName FROM `bill_detail` bd,`customers` c WHERE bd.biller_id = c.id and bd.ref = '".$row['id']."' order by bd.ref2";
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
		echo "Rs. ".floatval($row2['weices']) * floatval($row2['rate']); 
		$total += floatval($row2['weices']) * floatval($row2['rate']);
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
	<div class="col-md-3">

	</div>
	<div class="col-md-1">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">

	</div>
	<div class="col-md-2">
	Total
	</div>
	<div class="col-md-2">Rs. 
	<?php echo $all_total; ?>
	</div>
</div>
<br><br>
<a href="javascript:void()" onclick="return printView('<?php echo $bill_id; ?>')">Print</a>
<a href="javascript:void()" onclick="return pageLoad('vendors/bill_update.php?id=<?php echo $bill_id; ?>')">Update</a>
<br>
<br>
</div>
</div>
<script>
function printView(id)
{
	window.open("vendors/bill_print.php?id="+id);
}

</script>