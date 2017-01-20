<?php 
require "../123321.php";
$qry = "SELECT * FROM `sizes` WHERE 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 0;
while($row = mysqli_fetch_array($run))
{
if($count % 2 == 0) { $color = "rgba(240,240,240,1)"; }
else { $color = "rgba(230,230,230,1)"; }
$id = $row['id'];
?>
<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-1 border head_" style="background-color:<?php echo $color; ?>"><?php echo $count++; ?></div>
	<div class="col-sm-3 border head_" style="background-color:<?php echo $color; ?>"><?php echo $row['size']; ?></div>
	<div class="col-sm-2 border head_" style="background-color:<?php echo $color; ?>"><a href="javascript:void()" onclick="delSize('<?php echo $id; ?>')">Delete</a></div>
	<div class="col-sm-3"></div>
</div>
<?php
}
?>