<div class="container addBox">
<div class="inBox"> 
<h1>Invoice</h1>
<form id="addInvForm">
<?php 
require "../123321.php";
$inv_no = $_GET['no'];
$qry = "SELECT * FROM `invoice` WHERE `no` = '$inv_no'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row = mysqli_fetch_array($run);
$date = $row['date'];
$rateby = $row['rateby'];
$paymentTime = $row['paymentTime'];
$inv_id = $row['id'];
$advance = 0;
$qry = "SELECT * FROM `payments_recv` WHERE advance = 1 and `inv_no` = '".$inv_no."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
if(mysqli_num_rows($run) > 0) {
$row2 = mysqli_fetch_array($run);
$advance = $row2['amount'];
}

$qry = "SELECT * FROM `customers` WHERE `id` = '".$row['customer']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row2 = mysqli_fetch_array($run);
$custName = $row2['name'];

$qry = "SELECT * FROM `employee` WHERE `id` = '".$row['salerep']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row2 = mysqli_fetch_array($run);
$sRepName = $row2['name'];
?>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Inv. #</label></div><div class="col-md-4">
<span style="font-size:18px;">INV-<?php echo $inv_no; ?></span></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Customer</label></div><div class="col-md-4">

<input class="mainField" type='text' list='listid2' id="custEle" onchange="OnCustomerChange()" value="<?php echo $custName; ?>">
<datalist id='listid2'>
	<?php
	
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
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Sale Rep.</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid' id="saleRep" value="<?php echo $sRepName; ?>">
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
</div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Ref. #</label></div><div class="col-md-4">

<input class="mainField" maxlength="12" type="hidden" name="refNo" id="oldrefNo" placeholder="Reference No." value="<?php echo $inv_id; ?>">
<input class="mainField" maxlength="12" type="hidden" name="No" id="oldNo" placeholder="Reference No." value="<?php echo $inv_no; ?>">

<input class="mainField" maxlength="12" type="text" name="refNo" id="refNo" placeholder="Reference No." value="<?php echo $inv_id; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row paymentTimeClass" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Payment <span style="font-size:14px;">Time (Days)</span></label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="paymentTime" id="paymentTime" placeholder="Payment time in days" value="<?php echo $paymentTime; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo $date; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Rate by</label></div><div class="col-md-4">
<select class="mainField" name="weices" id="weices" onchange="changeRateBy()">
	<option value="1" <?php if($rateby == "1") echo "selected"?> >Pieces</option>
	<option value="2" <?php if($rateby == "2") echo "selected"?>>Weight</option>
</select>
</div><div class="col-md-3"></div></div>
<br>
<div class="inv_table">
	<div class="row">
		<div class="col-md-1 border head_">Sr.</div>
		<div class="col-md-2 border head_">Size</div>
		<div class="col-md-1 border head_">Material</div>
		<div class="col-md-2 border head_">Expence Name</div>
		<div class="col-md-1 border head_">Charges</div>
		<div class="col-md-1 border head_" id="rateByHead">Pieces</div>
		<div class="col-md-1 border head_">Rate</div>
		<div class="col-md-1 border head_">Bag</div>
		<div class="col-md-1 border head_">Total</div>
	</div>
	<div id="inv_fields">	
		<datalist id="matlist">
	<option value="LD">LD</option>
	<option value="HD">HD</option>
	</datalist>
	<datalist id="typelist">
	<option value="Block">Block</option>
	<option value="Cargo">Cargo</option>
	</datalist>
	<datalist id="sizelist">
	<?php 
	$qry = "SELECT * FROM `sizes` WHERE 1";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$count = 0;
	while($row = mysqli_fetch_array($run))
	{
	?>
		<option value="<?php echo $row['size']; ?>"><?php echo $row['size']; ?></option>
	<?php
	}
	?>
	</datalist>
		<?php
		$qry = "SELECT * FROM `invoice_detail` WHERE `ref` = '$inv_no'";
		$run = mysqli_query($con,$qry) or die(mysqli_error($con));
		$i = 0;
		$allTotal = 0;
		while($row = mysqli_fetch_array($run))
		{
		?>
		<div class="row">
			<div class="col-md-1 border"><?php echo ++$i; ?></div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="size" list='sizelist' id="v_size_<?php echo $i; ?>" value="<?php echo $row['size']; ?>" onchange="noneCharge('<?php echo $i; ?>')"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="size" list='sizelist' id="v_mat_<?php echo $i; ?>" value="<?php echo $row['material']; ?>">
			</div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="charges" id="v_type_<?php echo $i; ?>"  value="<?php echo $row['exp_name']; ?>"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="charges" id="v_charges_<?php echo $i; ?>" onchange="updateCharge('<?php echo $i; ?>')" value="<?php echo $row['charges']; ?>" onchange="noneSize('<?php echo $i; ?>')"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="weight" id="v_weices_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')" value="<?php echo $row['weices']; ?>"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="rate" id="v_rate_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')" value="<?php echo $row['rate']; ?>"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="bag" id="v_bag_<?php echo $i; ?>" value="<?php echo $row['bag']; ?>"></div>
			<div class="col-md-1 border" id="v_total_<?php echo $i; ?>"><?php if($row['exp_name'] == "--") { echo floatval($row['rate']) * floatval($row['weices']);  $allTotal += floatval($row['rate']) * floatval($row['weices']);
			}
			else
			{
			echo floatval($row['charges']);  $allTotal += floatval($row['charges']);	
			} ?></div>
			<input class="inv_input" type="hidden" name="bag" id="v_id_<?php echo $i; ?>" value="<?php echo $row['id']; ?>">
		</div>
		<?php
		}
		?>
	<input type="hidden" name="fields" id="fieldsCount" value="<?php echo $i; ?>">		
	</div>
	<div class="row">		
		<div class="col-md-11 border2"><input style="height:100%;width:100%;" type="button" name="addRow" id="addRow" value="Add Row" onclick="addNewField()"></div>
	</div>s
	<br><br>
	<div class="row" style="position:relative;left:-50px;">
		<div class="col-md-4"><b style="position:relative;top:2px;font-size:18px;">Total </b><input type="text" name="total" id="allTotal" value="<?php echo $allTotal; ?>" readonly></div>
		<div class="col-md-4"><b style="position:relative;top:2px;font-size:18px;">Advance </b><input type="text" name="total" id="_advance" value="<?php echo $advance; ?>"></div>
		<div class="col-md-4"><b style="position:relative;top:2px;font-size:18px;">Balance </b><input type="text" name="total" id="_balance" value="<?php echo (floatval($advance) - floatval($allTotal)); ?>" readonly></div>
	</div>
</div>
<br><br>
<div class="row" id="r1"><input class="mainField" onclick="updateInvoice()" type="button" name="submit" value="Update"></div>
<br>
<div class="row" id="r1"><input style="color:red;" class="mainField" onclick="deleteInvoice(<?php echo $inv_no; ?>)" type="button" name="submit" value="Delete"></div><br>
<div class="row" id="r1"><p id="not">Invoice successfully updated!</p></div>
<br><br>
<h1>Invoice's Payments</h1>
<div class="row" style="background-color:rgba(220,220,220,1);width:95%;position:relative;margin:0 auto;">
    <div class="col-sm-1 border head_">Sr.</div>
    <div class="col-sm-1 border head_">Pay #</div>
    <div class="col-sm-1 border head_">Ref #</div>
    <div class="col-sm-1 border head_">Inv #</div>
    <div class="col-sm-2 border head_">Customer</div>
    <div class="col-sm-2 border head_">Receiver</div>
    <div class="col-sm-1 border head_">Rec. Date</div>
    <div class="col-sm-1 border head_">Entry Date</div>
    <div class="col-sm-2 border head_"> Amount</div>
</div>
<?php
require "../123321.php";
$qry = "SELECT * FROM `payments_recv` WHERE `inv_no` = '".$inv_no."'";
$count = 0;             
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data = mysqli_fetch_array($run))
{
if($count++ % 2 == 0) $color = "rgba(240,240,240,1)";
else $color = "rgba(230,230,230,1)";

$qry = "SELECT * FROM `customers` WHERE `id` = '".$data['customer']."'";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$data2 = mysqli_fetch_array($run2);    
$custName = $data2['name'];

$qry = "SELECT * FROM `employee` WHERE `id` = '".$data['receiver']."'";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$data2 = mysqli_fetch_array($run2);    
$recName = $data2['name'];                
?>
<div class="row" id="inv_data" onclick="viewPayment('<?php echo $data['id'] ?>')" style="background-color:<?php echo $color; ?>;width:95%;position:relative;margin:0 auto;">
    <div class="col-sm-1 border"><?php echo $count; ?></div>
    <div class="col-sm-1 border">PY-<?php echo $data['id']; ?></div>
    <div class="col-sm-1 border"><?php echo $data['ref_no']; ?></div>
    <div class="col-sm-1 border">INV-<?php echo $data['inv_no']; ?></div>
    <div class="col-sm-2 border"><?php echo $custName; ?></div>
    <div class="col-sm-2 border"><?php echo $recName; ?></div>
    <div class="col-sm-1 border"><?php echo $data['rec_date']; ?></div>
    <div class="col-sm-1 border"><?php echo $data['entry_date']; ?></div>
    <div class="col-sm-2 border">Rs. <?php echo $data['amount']; ?></div>
</div>
<?php
}
if($count == 0)
{
?>
<div class="row" style="background-color:<?php echo $color; ?>;width:95%;position:relative;margin:0 auto;">
<div class="col-sm-12 border head_">No payments!</div>
</div>
<?php
}
?>
<br><br>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>


function noneCharge(row)
{
	
		$("#v_type_"+row).val("--");
		$("#v_charges_"+row).val("0");
	
}


function noneSize(row)
{
	
		$("#v_size_"+row).val("--");
		$("#v_mat_"+row).val("--");
		$("#v_weices_"+row).val("0");
		$("#v_rate_"+row).val("0");
		$("#v_bag_"+row).val("0");
	
}


function updateCharge(row)
{
	noneSize(row);
	var charges = $("#v_charges_"+row).val();
	$("#v_total_"+row).html(charges);
	var totalfields = $("#fieldsCount").val();
	var allTotal = 0;
	for(var i = 1;i <= totalfields;i++)
	{
		allTotal += parseInt($("#v_total_"+i).html());
	}
	$("#allTotal").val(allTotal);
	$("#_balance").val(parseInt($("#_advance").val()) - parseInt($("#allTotal").val()));
}


function updateTotal(row)
{
	noneCharge(row);
	var weices = $("#v_weices_"+row).val();
	var weices = $("#v_weices_"+row).val();
	var rate = $("#v_rate_"+row).val();
	if(weices.length > 0 && rate.length > 0) {
		var total = parseInt(rate) * parseInt(weices);
		$("#v_total_"+row).html(total);
		var totalfields = $("#fieldsCount").val();
		var allTotal = 0;
		for(var i = 1;i <= totalfields;i++)
		{
			allTotal += parseInt($("#v_total_"+i).html());
		}
		$("#allTotal").val(allTotal);
		$("#_balance").val(parseInt($("#_advance").val()) - parseInt($("#allTotal").val()));

	}
}


function deleteInvoice(id)
{

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        alert(xhttp.responseText);
        pageLoad('customers/invoices.php');
    }};  

    xhttp.open("POST", "do.php?action=deleteinvoice", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");
}


function updateInvoice()
{
	var customerName = $("#custEle").val();
	var saleRep = $("#saleRep").val();
	var refNo = $("#refNo").val();
	var oldNo = $("#oldNo").val();
	var date = $("#dateEle").val();
	var weices = $("#weices").val();
	var paymentTime = $("#paymentTime").val();


	var totalfields = $("#fieldsCount").val();
	var enteredfields = 0;
	var jsonStr = "";
	var postStr = "cName="+customerName+"&saleRep="+saleRep+"&refNo="+refNo+"&date="+date+"&weices="+weices+"&advance="+$("#_advance").val()+"&oldNo="+oldNo+"&paymentTime="+paymentTime;
	for(var i = 1;i <= totalfields;i++)
	{

		enteredfields++;
		jsonStr = '{"id":"'+$('#v_id_'+i).val()+'","mat":"'+$('#v_mat_'+i).val()+'","type":"'+$('#v_type_'+i).val()+'","size":"'+$('#v_size_'+i).val()+'","charges":"'+$('#v_charges_'+i).val()+'","weices":"'+$('#v_weices_'+i).val()+'","rate":"'+$('#v_rate_'+i).val()+'","bag":"'+$('#v_bag_'+i).val()+'"}';
		postStr += "&data_"+enteredfields+"="+jsonStr;
	}
	postStr += "&data_count="+enteredfields;
	//alert(postStr);

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
            $("#not").text("Invoice Updated");
            $("#not").css({color:'green'});
            $("#not").slideDown();  
            $("#custEle").focus();            
        }
    }};  

    xhttp.open("POST", "do.php?action=updateinvoice", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(postStr+"&ajax");
}

function OnCustomerChange()
{
	var customer = $("#custEle").val();
	setSaleRepForCustomer(customer);
	setRateByForCustomer(customer);
	setAdvanceForCustomer(customer);
	setCustomerPaymentMethod(customer);
}

function setCustomerPaymentMethod(customer)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        //$("#saleRep").val(xhttp.responseText);
        if(xhttp.responseText == "0")
        {
        	$(".paymentTimeClass").show();
        }
        else
        {
        	$(".paymentTimeClass").val("-1");
        	$(".paymentTimeClass").hide();
        }
    }};  

    xhttp.open("POST", "do.php?action=getpaymentmethod", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer="+customer+"&ajax");	
}

function setSaleRepForCustomer(customer)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        $("#saleRep").val(xhttp.responseText);
    }};  

    xhttp.open("POST", "do.php?action=getsalerep", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer="+customer+"&ajax");
}


function setAdvanceForCustomer(customer)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        $("#_advance").val(xhttp.responseText);
    }};  

    xhttp.open("POST", "do.php?action=getadvance", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer="+customer+"&ajax");
}

function setRateByForCustomer(customer)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
    	//alert(xhttp.responseText);
        if(xhttp.responseText == "1")
		{
			$("#weices").html('<option value="1" selected>Pieces</option>\
							   <option value="2">Weight</option>')
		}
		else
		{
			$("#weices").html('<option value="1">Pieces</option>\
							   <option value="2" selected>Weight</option>')
		}
		changeRateBy();
    }};  

    xhttp.open("POST", "do.php?action=getrateby", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer="+customer+"&ajax");
}

function changeRateBy()
{
	if($("#weices").val() == "1")
		$("#rateByHead").html("Pieces");
	else
		$("#rateByHead").html("Weight");

}
function addNewField()
{
	var sr = parseInt($("#fieldsCount").val()) + 1;
	$("#inv_fields").append('<div class="row">\
			<div class="col-md-1 border">'+sr+'</div>\
			<div class="col-md-2 border"><input class="inv_input" type="text" name="size" list=\'sizelist\' id="v_size_'+sr+'" onchange="noneCharge(\''+sr+'\')">\
			</div>\
			<div class="col-md-1 border"><input class="inv_input" type="text" name="mat" list=\'matlist\' id="v_mat_'+sr+'">\
			</div>\
			<div class="col-md-2 border"><input class="inv_input" type="text" name="type" list="typelist" id="v_type_'+sr+'"></div>\
			<div class="col-md-1 border"><input class="inv_input" type="text" name="charges" id="v_charges_'+sr+'" onchange="updateCharge(\''+sr+'\')" onchange="noneSize(\''+sr+'\')"></div>\
			<div class="col-md-1 border"><input class="inv_input" type="text" name="weight" id="v_weices_'+sr+'" onchange="updateTotal(\''+sr+'\')"></div>\
			<div class="col-md-1 border"><input class="inv_input" type="text" name="rate" id="v_rate_'+sr+'" onchange="updateTotal(\''+sr+'\')"></div>\
			<div class="col-md-1 border"><input class="inv_input" type="text" name="bag" id="v_bag_'+sr+'"></div>\
			<div class="col-md-1 border v_total_Class" id="v_total_'+sr+'">0</div>\
		</div>');

	$("#fieldsCount").val(sr);
	$("#v_size_"+sr).focus();
}
function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$("#custEle").focus();
	$(".paymentTimeClass").hide();


	var customer = $("#custEle").val();
	setCustomerPaymentMethod(customer);
}
</script>