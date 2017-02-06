<div class="container addBox" style="width:95%;">
<div class="inBox">
<h1>Advance List</h1>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;">
<div class="col-md-1"><b>Serial</b></div>
<div class="col-md-3"><b>Employee</b></div>
<div class="col-md-2"><b>Amount</b></div>
<div class="col-md-2"><b>Duration</b></div>
<div class="col-md-2"><b>Start Date</b></div>
<div class="col-md-1"><b>Edit</b></div>
<div class="col-md-1"><b>Delete</b></div>
</div>
<?php
require "../123321.php";
$qry = "SELECT a.*,e.name FROM advance a, employee e WHERE a.employee = e.id";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;

while($row = mysqli_fetch_array($run))
{
if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
else echo '<div class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
$id= $row['id'];
?>
<div class="col-md-1"><?php echo $count++; ?></div>
<div class="col-md-3"><?php echo $row['name']; ?></div>
<div class="col-md-2">Rs. <?php echo $row['amount']; ?></div>
<div class="col-md-2"><?php echo $row['duration']; ?></div>
<div class="col-md-2"><?php echo $row['date']; ?></div>
<div class="col-md-1"><a onclick='pageLoad("employees/edit_adv.php?id=<?php echo $id; ?>");' href="javascript:void()">Edit</a></div>
<div class="col-md-1"><a onclick='deleteAdvance(<?php echo $id; ?>)' href="javascript:void()">Delete</a></div>
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

function deleteAdvance(id) {
  if(confirm("Delete advance?")) {
  var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {

        }
        else if(xhttp.responseText === "1")
        {
            pageLoad("employees/adv_list.php");
        }
    }};

    xhttp.open("POST", "do.php?action=deleteAdvance", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");
  }
}
</script>
