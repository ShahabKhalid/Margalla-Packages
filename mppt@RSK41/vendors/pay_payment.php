<div class="container addBox">
<div class="inBox"> 
<h1>Pay Payment</h1>
<form id="addPaymentForm">
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><span style="font-size:18px;"><?php echo date("Y-m-d"); ?></span>
<input type="hidden" name="todaysDate" id="todaysDate" value='<?php echo date("Y-m-d"); ?>'>
</div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Vendor</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid2' id="vendorEle" onchange="OnVendorChange()">
<datalist id='listid2'>
	<?php
	require "../123321.php";
	$qry = "SELECT * FROM `vendor` WHERE 1 order by `name`";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($run))
	{
	?>
	<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
	<?php
	}
	?>
</select>
</div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Bill. #</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="invNo" id="billNo" placeholder="Invoice No." list="bill_list"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Paid By</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid' id="amountPayer">
<datalist id='listid'>
	<?php
	require "../123321.php";
	$qry = "SELECT * FROM `employee` WHERE 1 order by `name`";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($row = mysqli_fetch_array($run))
	{
	?>
	<option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
	<?php
	}
	?>
</datalist>
<datalist id='bill_list'>
</datalist>
</div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Ref. #</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="refNo" id="refNo" placeholder="Reference No."></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo date("Y-m-d"); ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Amount</label></div><div class="col-md-4">
<input class="mainField" maxlength="12" type="text" name="amount" id="amountEle" placeholder="Amount">
</div><div class="col-md-3"></div></div>
<br><br>
<div class="row" id="r1"><input class="mainField" onclick="addPayment()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Payment successfully added!</p></div>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>


function addPayment()
{
	var form = document.getElementById("addPaymentForm");
	var todaysDate = form[0].value;
	var Vendor = form[1].value;
	var billNo = form[2].value;
	var Payer = form[3].value;
	var refNo = form[4].value;
	var date = form[5].value;
	var Amount = form[6].value;
	

	postStr = "todaysDate="+todaysDate+"&Vendor="+Vendor+"&billNo="+billNo+"&Payer="+Payer+"&refNo="+refNo+"&Date="+date+"&Amount="+Amount;

	

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
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
            $("#not").text("Payment Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();  
            form.reset();  
            $("#custEle").focus();            
        }
    }};  
	
    xhttp.open("POST", "do.php?action=paypayment", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(postStr+"&ajax");
}

function OnVendorChange()
{
	var vendor = $("#vendorEle").val();	
	setLastBillForVendor(vendor);
	updateBillListForVendor(vendor);
}

function setLastBillForVendor(vendor)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
    	//alert(xhttp.responseText);
        $("#billNo").val(xhttp.responseText);
    }};  

    xhttp.open("POST", "do.php?action=getlastbill", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("vendor="+vendor+"&ajax");
}


function updateBillListForVendor(vendor)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
    	//alert(xhttp.responseText);
        $("#bill_list").html(xhttp.responseText);
    }};  

    xhttp.open("POST", "vendors/bill_list_vendor.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("vendor="+vendor+"&ajax");
}


function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$("#vendorEle").focus();
}
</script>