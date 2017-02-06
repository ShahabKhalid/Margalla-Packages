<div class="container addBox">
<div class="inBox">
<h1>Edit Advance</h1>
<form id="addAdvanceForm">
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Employee</label></div>
<div class="col-md-5">
<select id="employee" class="mainField">
	<?php
	require "../123321.php";
	$id = $_GET['id'];
	$qry = "SELECT * FROM `advance` WHERE id = '$id'";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$row = mysqli_fetch_array($run);
	$employeeId = $row['employee'];
	$amount = $row['amount'];
	$duration = $row['duration'];
	$startDate = $row['date'];

	$qry = "SELECT * FROM `employee` WHERE 1";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($run))
	{
	?>
	<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $employeeId) echo "selected"; ?>><?php echo $row['name']; ?></option>
	<?php
	}
	?>
</select>
</div>
<div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Advance</label></div><div class="col-md-5"><input value="<?php echo $amount; ?>" class="mainField" maxlength="12" type="text" placeholder="Advance amount"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Duration</label></div><div class="col-md-5"><input value="<?php echo $duration ?>" class="mainField" maxlength="12" type="text" placeholder="Duration (Months)"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Duration</label></div><div class="col-md-5"><input type="date" value="<?php echo $startDate ?>" class="mainField" maxlength="12" type="text" placeholder="Duration (Months)"></div><div class="col-md-1"></div></div>
<input type="hidden" value="<?php echo $id; ?>" /><br>
<div class="row" id="r1"><input class="mainField" onclick="updateAdvance()" type="button" name="submit" value="Update"></div><br>
<div class="row" id="r1"><p id="not">Advance successfully updated!</p></div>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$("#employee").focus();
}

function updateAdvance()
{
	var addForm = document.getElementById("addAdvanceForm");
	var name = addForm[0].value;
	var advance = addForm[1].value;
	var duration = addForm[2].value;
	var startDate = addForm[3].value;
	var id = addForm[4].value;

	//alert(name);

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {
            $("#not").hide();
            $("#not").text("Error while updating!");
            $("#not").css({color:'red'});
            $("#not").slideDown();
        }
        else if(xhttp.responseText === "1")
        {
            $("#not").slideUp();
            $("#not").text("Advance Updated!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            addForm.reset();
            $("#employee").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=updateAdvance", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&name="+name+"&advance="+advance+"&duration="+duration+"&startDate="+startDate+"&ajax");

}
</script>
