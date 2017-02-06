<div class="container addBox">
<div class="inBox">
<h1>Add Advance</h1>
<form id="addAdvanceForm">
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Employee</label></div>
<div class="col-md-5">
<select id="employee" class="mainField">
	<?php
	require "../123321.php";
	$qry = "SELECT * FROM `employee` WHERE 1";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($run))
	{
	?>
	<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
	<?php
	}
	?>
</select>
</div>
<div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Advance</label></div><div class="col-md-5"><input class="mainField" maxlength="12" type="text" placeholder="Advance amount"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Duration</label></div><div class="col-md-5"><input class="mainField" maxlength="12" type="text" placeholder="Duration (Months)"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Advance Start Date</label></div><div class="col-md-5"><input type="date" class="mainField" maxlength="12" type="text" placeholder="Date" value="<?php echo date('Y-m-d'); ?>"></div><div class="col-md-1"></div></div>
<br>
<div class="row" id="r1"><input class="mainField" onclick="addAdvance()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Advance successfully added!</p></div>
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

function addAdvance()
{
	var addForm = document.getElementById("addAdvanceForm");
	var name = addForm[0].value;
	var advance = addForm[1].value;
	var duration = addForm[2].value;
	var startDate = addForm[3].value;

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
            $("#not").text("Error while adding!");
            $("#not").css({color:'red'});
            $("#not").slideDown();
        }
        else if(xhttp.responseText === "1")
        {
            $("#not").slideUp();
            $("#not").text("Advance Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            addForm.reset();
            $("#employee").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=addAdvance", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name="+name+"&advance="+advance+"&duration="+duration+"&startDate="+startDate+"&ajax");

}
</script>
