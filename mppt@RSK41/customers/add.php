<?php
require "../123321.php";
?>
<div class="container addBox">
<div class="inBox">
<h1>Add New Customer</h1>
<form id="addCustomerForm">
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Name</label></div><div class="col-md-5"><input class="mainField" maxlength="24" id="nameEle" type="text" name="custName" placeholder="John Doe"></div><div class="col-md-1"></div></div>
<div class="row" id="r1"><div class="col-md-6"></div><div class="col-md-4"><i id="nameErr">Please enter the name!</i></div><div class="col-md-2"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Contact #</label></div><div class="col-md-5"><input class="mainField" maxlength="12" type="text" name="custNo" placeholder="0334-2548762"></div><div class="col-md-1"></div></div>
<div class="row" id="r1"><div class="col-md-6"></div><div class="col-md-4"><i id="contErr">Please enter the contact!</i></div><div class="col-md-2"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Address</label></div><div class="col-md-5"><input class="mainField" maxlength="62" type="text" name="custAddr" placeholder="Address"></div><div class="col-md-1"></div></div>
<div class="row" id="r1"><div class="col-md-6"></div><div class="col-md-4"><i id="addrErr">Please enter the address!</i></div><div class="col-md-2"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Opening Balance</label></div><div class="col-md-5"><input class="mainField" value="0" maxlength="10" type="text" name="custAddr" placeholder="Address"></div><div class="col-md-1"></div></div>
<div class="row" id="r1"><div class="col-md-6"></div><div class="col-md-4"><i id="addrErr">Please enter the address!</i></div><div class="col-md-2"></div></div><br>

<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Sale Rep.</label></div>
<div class="col-md-5">
<select id="salerep" class="mainField">
	<?php
	
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
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Rate by</label></div><div class="col-md-5">
<select class="mainField" name="weices" id="weices" onchange="changeRateBy()">
	<option value="1">Pieces</option>
	<option value="2" selected>Weight</option>
</select>
</div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Payment Method</label></div><div class="col-md-5">
<select class="mainField" name="paymentMethod" id="pamentMethod">
	<option value="0" selected>Time Interval</option>
	<option value="1">Bill To Bill</option>
</select>
</div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>LD Rate</label></div><div class="col-md-5"><input class="mainField" value="4" maxlength="10" type="text" name="custAddr" placeholder="Address"></div><div class="col-md-1"></div></div>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>HD Rate</label></div><div class="col-md-5"><input class="mainField" value="4" maxlength="10" type="text" name="custAddr" placeholder="Address"></div><div class="col-md-1"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><input class="mainField" onclick="addCustomer()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Customer successfully added!</p></div>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$("#nameEle").focus();
}
function addCustomer()
{
	var addForm = document.getElementById("addCustomerForm");
	var name = addForm[0].value;
	var contact = addForm[1].value;
	var addr = addForm[2].value;
	var balance = addForm[3].value;
	var salerep = addForm[4].value;
	var weices = addForm[5].value;
	var paymentMethod = addForm[6].value;
	var ldRate = addForm[7].value;
	var hdRate = addForm[8].value;

	if(name.length < 1)
	{
		$("#nameErr").slideDown();
		return;
	}
	else
	{
		$("#nameErr").slideUp();
	}


	if(contact.length < 1)
	{
		$("#contErr").slideDown();
		return;
	}
	else
	{
		$("#contErr").slideUp();
	}

	if(addr.length < 1)
	{
		$("#addrErr").slideDown();
		return;
	}
	else
	{
		$("#addrErr").slideUp();
	}

	if(balance.length < 1)
	{
		$("#openBErr").slideDown();
		return;
	}
	else
	{
		$("#openBErr").slideUp();
	}

	//return alert("name="+name+"&contact="+contact+"&addr="+addr+"&openbalance="+balance+"&salerep="+salerep+"&weices="+weices+"&paymentMethod="+paymentMethod+"&ldRate="+ldRate+"&hdRate="+hdRate+"&ajax");

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
            $("#not").text("Customer Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            addForm.reset();
            $("#nameEle").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=addcustomer", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name="+name+"&contact="+contact+"&addr="+addr+"&openbalance="+balance+"&salerep="+salerep+"&weices="+weices+"&paymentMethod="+paymentMethod+"&ldRate="+ldRate+"&hdRate="+hdRate+"&ajax");

}
</script>
