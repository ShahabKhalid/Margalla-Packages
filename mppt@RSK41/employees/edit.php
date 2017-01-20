<div class="container addBox">
<div class="inBox">
<h1>Edit/Delete Employee</h1>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `employee` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<form id="addEmployeeForm">
<input maxlength="24" id="IDEle" type="hidden" name="custID" placeholder="John Doe" value="<?php echo $data['id']; ?>">
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Name</label></div><div class="col-md-4"><input maxlength="24" id="nameEle" type="text" name="custName" placeholder="John Doe" value="<?php echo $data['name']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="nameErr">Please enter the name!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-4"><input maxlength="12" type="text" name="custNo" placeholder="0334-2548762" value="<?php echo $data['contact']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="contErr">Please enter the contact!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Address</label></div><div class="col-md-4"><input maxlength="62" type="text" name="custAddr" placeholder="Address" value="<?php echo $data['address']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="addrErr">Please enter the address!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>LD Rate</label></div><div class="col-md-4"><input class="mainField" maxlength="10" type="text" placeholder="LD Rate" value="<?php echo $data['ldRate']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>HD Rate</label></div><div class="col-md-4"><input class="mainField" maxlength="10" type="text" placeholder="HD Rate" value="<?php echo $data['hdRate']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Salary</label></div><div class="col-md-4"><input class="mainField" maxlength="10" type="text" placeholder="Salary" value="<?php echo $data['salary']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-6"><input onclick="updateEmployee()" type="button" name="submit" value="Update"></div><div class="col-md-6"><input onclick="deleteEmployee()" type="button" name="submit" value="Delete"></div></div><br>
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
function updateEmployee()
{
	var addForm = document.getElementById("addEmployeeForm");
	var id = addForm[0].value;
	var name = addForm[1].value;
	var contact = addForm[2].value;
	var addr = addForm[3].value;
	var ldRate = addForm[4].value;
	var hdRate = addForm[5].value;
	var salary = addForm[6].value;
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
            $("#not").text("Employee Updated!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            pageLoad("employees/list.php");
        }
    }};

    xhttp.open("POST", "do.php?action=updateemployee", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name="+name+"&contact="+contact+"&addr="+addr+"&id="+id+"&ldRate="+ldRate+"&hdRate="+hdRate+"&salary="+salary+"&ajax");

}
function deleteEmployee()
{
	var addForm = document.getElementById("addEmployeeForm");
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
            pageLoad("employees/list.php");
        }
    }};

    xhttp.open("POST", "do.php?action=deleteemployee", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");

}
</script>
