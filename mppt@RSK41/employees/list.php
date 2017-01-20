<div class="container addBox">
<div class="inBox">
<h1>Employee List</h1>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;">
<div class="col-md-1"><b>Serial</b></div>
<div class="col-md-1"><b>ID</b></div>
<div class="col-md-3"><b>Name</b></div>
<div class="col-md-2"><b>Contact</b></div>
<div class="col-md-2"><b>Address</b></div>
<div class="col-md-2"><b>Salary</b></div>
<div class="col-md-1"><b>Edit</b></div>
</div>
<?php
require "../123321.php";
$qry = "SELECT * FROM `employee` WHERE 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;

while($row = mysqli_fetch_array($run))
{
if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
else echo '<div class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
$id= $row['id'];
?>
<div onclick='pageLoad("employees/profitSheet.php?id=<?php echo $id; ?>");'>
<div class="col-md-1"><?php echo $count++; ?></div>
<div class="col-md-1"><?php echo "MPE-".$row['id']; ?></div>
<div class="col-md-3"><?php echo $row['name']; ?></div>
<div class="col-md-2"><?php echo $row['contact']; ?></div>
<div class="col-md-2"><?php echo $row['address']; ?></div>
<div class="col-md-2">Rs. <?php echo number_format(intval($row['salary'])); ?></div>
</div>
<div class="col-md-1"><a onclick='pageLoad("employees/edit.php?id=<?php echo $id; ?>");' href="javascript:void()">Edit</a></div>
</div>
<?php
}
?>
<br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("").click(function() {

    });

});
</script>
