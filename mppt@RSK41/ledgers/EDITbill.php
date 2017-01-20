<div class="container addBox">
<div class="inBox">
<h1>Edit/Delete Customer</h1>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `expences` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<form id="addExpenceForm">
<input maxlength="24" id="IDEle" type="hidden" name="custID" placeholder="John Doe" value="<?php echo $data['id']; ?>">
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Account</label></div>
<div class="col-md-5">
<select id="expAccount" class="mainField">
	<?php
	require "../123321.php";
	$qry = "SELECT * FROM `expAccounts` WHERE 1";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($run))
	{
	?>
	<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $data['acc_id']) echo "selected"; ?>><?php echo $row['name'];?></option>
	<?php
	}
	?>
</select>
</div>
<div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Date</label></div><div class="col-md-5"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo $data['date']; ?>"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Description</label></div><div class="col-md-5"><input class="mainField"  type="text" placeholder="Expence Discription" value="<?php echo $data['description']; ?>"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Amount</label></div><div class="col-md-5"><input class="mainField" maxlength="20" type="text" placeholder="Expence Amount" value="<?php echo $data['amount']; ?>"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-6"><input onclick="updateExpence()" type="button" name="submit" value="Update"></div><div class="col-md-6"><input onclick="deleteExpence()" type="button" name="submit" value="Delete"></div></div><br>
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
function updateExpence()
{
	var addForm = document.getElementById("addExpenceForm");
	var id = addForm[0].value;
	var accountID = addForm[1].value;
	var date = addForm[2].value;
	var desc = addForm[3].value;
	var amount = addForm[4].value;


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
            $("#not").text("Expence Updated!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            pageLoad("expences/list.php");
        }
    }};

    xhttp.open("POST", "do.php?action=updateExpence", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("account="+accountID+"&id="+id+"&date="+date+"&desc="+desc+"&amount="+amount+"&ajax");

}
function deleteExpence()
{
	var addForm = document.getElementById("addExpenceForm");
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
            pageLoad("expences/list.php");
        }
    }};

    xhttp.open("POST", "do.php?action=deleteExpence", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");

}
</script>
