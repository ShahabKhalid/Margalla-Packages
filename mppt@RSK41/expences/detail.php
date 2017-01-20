<div class="container addBox">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Expence Details</h1>
</div>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `expAccounts` WHERE id = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ACCOUNT ID:-<?php echo $id; ?><br>
<b><a style="font-size:14px;text-decoration:none;" href="javascript:void()" onclick="exportExcel(<?php echo $id; ?>)">Export to excel</a></b></span>
</div>
</div>
<br>
<div class="row" id="r1"><div class="col-md-4"></div><div class="col-md-2"><label>Name</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div><div class="col-md-2 text-left"></div></div><br>
<br>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1">Exp. #</div>
	<div class="col-sm-2">Sub Account</div>
	<div class="col-sm-2">Date</div>
	<div class="col-sm-5">Description</div>
	<div class="col-sm-2">Amount</div>
</div>
<?php
$qry = "SELECT e.*,a.name,a.parent,a.id as aid FROM `expences` e,`expAccounts`a WHERE e.acc_id = a.id and (a.parent = '$id' or a.id = '$id')";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total = 0;
while($data = mysqli_fetch_array($run))
{
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
  <div class="col-sm-1">EXP-<?php echo $id; ?></div>
  <div class="col-sm-2">EXP-<?php echo $data['aid']; ?></div>
	<div class="col-sm-2"><?php echo $data['date']; ?></div>
	<div class="col-sm-5"><?php echo $data['description']; ?></div>
	<div class="col-sm-2"><?php echo "Rs. ".number_format(intval($data['amount'])); $total += intval($data['amount']);?></div>
		</div>
	<?php
	}
?>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2"></div>
	<div class="col-sm-6"></div>
	<div class="col-sm-1">Total</div>
	<div class="col-sm-3">Rs. <?php echo number_format($total); ?></div>
</div>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function exportExcel(id)
{
	window.open("expences/detail_export.php?id="+id);
}
</script>
