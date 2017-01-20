<div class="container addBox">
<div class="inBox">
<h1>New Expence</h1>
<form id="addExpenceForm">
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Account</label></div>
<div class="col-md-5">
<select id="expAccount" class="mainField">
	<?php
	require "../123321.php";
	$qry = "SELECT * FROM `expAccounts`";
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
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Date</label></div><div class="col-md-5"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo date("Y-m-d"); ?>"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Description</label></div><div class="col-md-5"><input class="mainField"  type="text" placeholder="Expence Discription" ></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Amount</label></div><div class="col-md-5"><input class="mainField" maxlength="20" type="text" placeholder="Expence Amount"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><input class="mainField" onclick="addExpence()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Expence successfully added!</p></div>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$("#expAccount").focus();
}
function addExpence()
{
	var addForm = document.getElementById("addExpenceForm");
	var accountID = addForm[0].value;
	var date = addForm[1].value;
	var desc = addForm[2].value;
	var amount = addForm[3].value;


	//alert(name);

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
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
            $("#not").text("Expence Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            addForm.reset();
            $("#expAccount").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=addexpence", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("account="+accountID+"&date="+date+"&desc="+desc+"&amount="+amount+"&ajax");

}
</script>
