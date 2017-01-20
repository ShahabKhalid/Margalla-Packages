<div class="container addBox">
<div class="inBox">
<h1>Edit/Delete Customer</h1>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `expAccounts` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<form id="updateAccountForm">
<input maxlength="24" id="IDEle" type="hidden" name="expAccountID" placeholder="Account Name" value="<?php echo $data['id']; ?>">
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Name</label></div><div class="col-md-4"><input maxlength="24" id="nameEle" type="text" name="custName" placeholder="John Doe" value="<?php echo $data['name']; ?>"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="nameErr">Please enter the name!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-4"><input onclick="addSubAccount(<?php echo $id; ?>)" type="button" name="submit" value="Add Sub-Account"></div><div class="col-md-4"><input onclick="updateAccount()" type="button" name="submit" value="Update Account"></div><div class="col-md-4"><input onclick="deleteAccount()" type="button" name="submit" value="Delete"></div></div><br>
<div class="row" id="r1"><p id="not">Expence Account successfully added!</p></div>
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

function addSubAccount(id)
{
    pageLoad("expences/addacount.php?p="+id);
}


function updateAccount()
{
	var addForm = document.getElementById("updateAccountForm");
	var id = addForm[0].value;
	var name = addForm[1].value;
	if(name.length < 1)
	{
		$("#nameErr").slideDown();
		return;
	}
	else
	{
		$("#nameErr").slideUp();
	}

	alert(name);

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
            $("#not").text("Account Updated!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            pageLoad("expences/accounts.php");
        }
    }};

    xhttp.open("POST", "do.php?action=updateexpaccount", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name="+name+"&id="+id+"&ajax");

}
function deleteAccount()
{
	var addForm = document.getElementById("updateAccountForm");
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
            pageLoad("expences/accounts.php");
        }
    }};

    xhttp.open("POST", "do.php?action=deleteexpaccount", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");

}
</script>
