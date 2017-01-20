<?php
require "../123321.php";
$qry = "SELECT * FROM `vendor` WHERE `name` = '".$_POST['vendor']."'";				
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);	
$custId = $data['id'];
$qry = "SELECT * FROM `bill` WHERE `vendor` = '$custId' order by `no` DESC";		
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data = mysqli_fetch_array($run))
{						
?>
<option value="<?php echo $data['no']; ?>"><?php echo $data['no']; ?></option>
<?php
}
?>