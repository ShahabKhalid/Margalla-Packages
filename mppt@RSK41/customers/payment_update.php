<div class="container addBox">
<div class="inBox">
<h1>Payment</h1>
<form id="addPaymentForm">
<?php
require "../123321.php";
$qry = "SELECT * FROM `payments_recv` WHERE `id` = '".$_GET['id']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);

$qry = "SELECT * FROM `customers` WHERE `id` = '".$data['customer']."'";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$data2 = mysqli_fetch_array($run2);
$custid = $data2['id'];
$custName = $data2['name'];

$qry = "SELECT * FROM `employee` WHERE `id` = '".$data['receiver']."'";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$data2 = mysqli_fetch_array($run2);
$recName = $data2['name'];
?>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><span style="font-size:18px;"><?php echo $data['entry_date']; ?></span>
<input type="hidden" name="todaysDate" id="todaysDate" value="<?php echo $data['entry_date']; ?>">
</div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Customer</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid2' id="custEle" onchange="OnCustomerChange()" value="<?php echo $custName; ?>">
<datalist id='listid2'>
	<?php
	require "../123321.php";
	$qry = "SELECT * FROM `customers` WHERE 1 order by `name`";
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
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Payment</label></div><div class="col-md-4">
<select id="paymentMethod" style="width:200px;" onchange="onPaymentChange()">
	<<option value="0" <?php if(intval($data['payMethod']) == 0) echo "Selected"; ?>>Cash</option>
	<<option value="1" <?php if(intval($data['payMethod']) == 1) echo "Selected"; ?>>Check</option>
</select>
</div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Check No.</label></div><div class="col-md-4">
	<input class="mainField" maxlength="64" type="text" name="checKNo" id="checkNo" placeholder="Check No." value="<?php echo $data['checkNo']; ?>"
	<?php if(intval($data['payMethod']) == 0) echo 'disabled="true"'; ?>></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Inv. #</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="invNo" id="invNo" placeholder="Invoice No." list="inv_list" value="<?php echo $data['inv_no']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Receiver</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid' id="amountReceiver" value="<?php echo $recName; ?>">
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
<datalist id='inv_list'>
</datalist>
</div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Ref.
#</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="refNo" id="refNo" placeholder="Reference No." value="<?php echo $data['ref_no']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><input class="mainField"
type="date" name="date" id="dateEle" value="<?php echo $data['rec_date']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Amount</label></div><div class="col-md-4">
<input class="mainField" maxlength="12" type="text" name="amount" id="amountEle" placeholder="Amount" value="<?php echo $data['amount']; ?>">
</div><div class="col-md-3"></div></div>
<br><br>
<input type="hidden" name="id" id="idEle" value="<?php echo $data['id']; ?>">
<div class="row" id="r1"><input class="mainField" onclick="updatePayment()" type="button" name="submit" value="Update"></div><br>
<div class="row" id="r1"><input style="color:red;" class="mainField" onclick="deletePayment(<?php echo $_GET['id']; ?>)" type="button" name="submit" value="Delete"></div><br>
<div class="row" id="r1"><p id="not">Payment successfully updated!</p></div>
<a href="javascript:void()" onclick="return pageLoad('customers/customer_ledger.php?id=<?php echo $custid; ?>')">Back to Ledger</a>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>

function onPaymentChange() {
	var payment = $("#paymentMethod").val();
	if(parseInt(payment) == 1) {
		$("#checkNo").prop('disabled', false);
	}
	else {
		$("#checkNo").prop('disabled', true);
	}
}


function deletePayment(id)
{

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        pageLoad('customers/payments_list.php');
    }};

    xhttp.open("POST", "do.php?action=deletepayment", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");
}

function updatePayment()
{
	var form = document.getElementById("addPaymentForm");
	var todaysDate = form[0].value;
	var Customer = form[1].value;
	var paymentMethod = form[2].value;
	var checkNo = form[3].value;
	var invNo = form[4].value;
	var Receiver = form[5].value;
	var refNo = form[6].value;
	var date = form[7].value;
	var Amount = form[8].value;
	var id = form[9].value;


	postStr = "id="+id+"&todaysDate="+todaysDate+"&Customer="+Customer+"&invNo="+invNo+"&Receiver="
	+Receiver+"&refNo="+refNo+"&Date="+date+"&Amount="+Amount+"&payMethod="+paymentMethod+"&checkNo="+checkNo;;



	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
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
            $("#not").text("Payment Updated!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
        }
    }};

    xhttp.open("POST", "do.php?action=updatepayment", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(postStr+"&ajax");
}

function OnCustomerChange()
{
	var customer = $("#custEle").val();
	setLastInvoiceForCustomer(customer);
	updateInvoiceListForCustomer(customer);
}

function setLastInvoiceForCustomer(customer)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
    	//alert(xhttp.responseText);
        $("#invNo").val(xhttp.responseText);
    }};

    xhttp.open("POST", "do.php?action=getlastinv", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer="+customer+"&ajax");
}


function updateInvoiceListForCustomer(customer)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
    	//alert(xhttp.responseText);
        $("#inv_list").html(xhttp.responseText);
    }};

    xhttp.open("POST", "customers/inv_list_customer.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer="+customer+"&ajax");
}


function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$("#custEle").focus();
}
</script>
