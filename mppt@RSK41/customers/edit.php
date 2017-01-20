<div class="container addBox">
<div class="inBox"> 
<h1>Edit/Delete Customer</h1>
<?php 
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `customers` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<form id="addCustomerForm">
<input maxlength="24" id="IDEle" type="hidden" name="custID" placeholder="John Doe" value="<?php echo $data['id']; ?>">
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Name</label></div><div class="col-md-4"><input maxlength="24" id="nameEle" type="text" name="custName" placeholder="John Doe" value="<?php echo $data['name']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="nameErr">Please enter the name!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-4"><input maxlength="12" type="text" name="custNo" placeholder="0334-2548762" value="<?php echo $data['contact']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="contErr">Please enter the contact!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Address</label></div><div class="col-md-4"><input maxlength="62" type="text" name="custAddr" placeholder="Address" value="<?php echo $data['address']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="addrErr">Please enter the address!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Opening Bal.</label></div><div class="col-md-4"><input maxlength="62" type="text" name="custAddr" placeholder="Address" value="<?php echo $data['opening_balance']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="oBErr">Please enter the opening balance!</i></div><div class="col-md-3"></div></div><br>
<datalist id='sRepid'>
	<?php
	$qry = "SELECT * FROM `employee` WHERE 1 order by `name`";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($run))
	{
	?>
	<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
	<?php
	}
	$qry = "SELECT * FROM `employee` WHERE `id` = '".$data['saleRep']."'";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$row = mysqli_fetch_array($run);
	$saleRepName = $row['name'];
	?>
</datalist>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Sale Rep.</label></div><div class="col-md-4"><input list='sRepid' maxlength="62" type="text" name="custAddr" value="<?php echo $saleRepName; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-7">
<input type="checkbox" id="updateInv" value="updateOldInv" checked> Update on all old Invoices!
</div><div class="col-md-3"></div></div><br>
<br><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>LD Rate</label></div><div class="col-md-4"><input list='LDRate' maxlength="24" type="text" value="<?php echo $data['ldRate']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>HD Rate</label></div><div class="col-md-4"><input list='HDRate' maxlength="24" type="text" value="<?php echo $data['hdRate']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-7">
<input type="checkbox" id="updateRateInv" value="updateRateOldInv" checked> Update  Rates on all old Invoices!
</div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-6"><input onclick="updateCustomer()" type="button" name="submit" value="Update"></div><div class="col-md-6"><input onclick="deleteCustomer()" type="button" name="submit" value="Delete"></div></div><br>
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
function updateCustomer()
{
	var addForm = document.getElementById("addCustomerForm");
	var id = addForm[0].value;
	var name = addForm[1].value;
	var contact = addForm[2].value;
	var addr = addForm[3].value;
	var openBal = addForm[4].value;
	var saleRep = addForm[5].value;
	var updateOldInv = "false";
	if(addForm[6].checked === true)
	updateOldInv = "true";
	var ldRate = addForm[7].value;
	var hdRate = addForm[8].value;
	var updateRateOldInv = "false";
	if(addForm[9].checked === true)
	updateRateOldInv = "true";
	alert(updateRateOldInv);

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

	if(openBal.length < 1)
	{
		$("#oBErr").slideDown();
		return;
	}
	else
	{
		$("#oBErr").slideUp();
	}

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
            $("#not").text("Error while updating!");
            $("#not").css({color:'red'});
            $("#not").slideDown();
        }
        else if(xhttp.responseText === "1")
        {                      
            $("#not").slideUp();            
            $("#not").text("Customer Updated!");
            $("#not").css({color:'green'});
            $("#not").slideDown();   
            //pageLoad("customers/list.php");            
        }
    }};  

    xhttp.open("POST", "do.php?action=updatecustomer", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name="+name+"&contact="+contact+"&addr="+addr+"&id="+id+"&opening_balance="+openBal+"&saleRep="+saleRep+"&updateOldInv="+updateOldInv+"&hdRate="+hdRate+"&ldRate="+ldRate+"&updateRateOldInv="+updateRateOldInv+"&ajax");     
	
}
function deleteCustomer()
{
	var addForm = document.getElementById("addCustomerForm");
	var id = addForm[0].value;

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        //alert(xhttp.responseText);
        if(xhttp.responseText === "1")
        {                      
            pageLoad("customers/list.php");            
        }
    }};  

    xhttp.open("POST", "do.php?action=deletecustomer", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");     
	
}
</script>