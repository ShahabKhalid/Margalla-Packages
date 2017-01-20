<div class="container addBox">
<div class="inBox">
<h1>New Invoice</h1>
<form id="addInvForm">
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Customer</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid2' id="custEle" onchange="OnCustomerChange()">
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
</datalist>
</div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Sale Rep.</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid' id="saleRep">
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
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Ref. #</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="refNo" id="refNo" placeholder="Reference No."></div><div class="col-md-3"></div></div><br>
<div class="row paymentTimeClass" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Payment <span style="font-size:14px;">Time (Days)</span></label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="paymentTime" id="paymentTime" placeholder="Payment time in days" value="-1"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo date("Y-m-d"); ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Rate by</label></div><div class="col-md-4">
<select class="mainField" name="weices" id="weices" onchange="changeRateBy()">
	<option value="1">Pieces</option>
	<option value="2">Weight</option>
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
	<input type="hidden" name="fields" id="fieldsCount" value="4">
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
		for($i = 1;$i < 5;$i++)
		{
		?>
		<div class="row">
			<div class="col-md-1 border"><?php echo $i; ?></div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="size" list='sizelist' id="v_size_<?php echo $i; ?>" onchange="noneCharge('<?php echo $i; ?>')">
			</div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="mat" list='matlist' id="v_mat_<?php echo $i; ?>">
			</div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="type" list="typelist" id="v_type_<?php echo $i; ?>"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="charges" id="v_charges_<?php echo $i; ?>" onchange="updateCharge('<?php echo $i; ?>')" onchange="noneSize('<?php echo $i; ?>')"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="weight" id="v_weices_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="rate" id="v_rate_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="bag" id="v_bag_<?php echo $i; ?>"></div>
			<div class="col-md-1 border v_total_Class" id="v_total_<?php echo $i; ?>">0</div>
		</div>
		<?php
		}
		?>
	</div>
	<div class="row">
		<div class="col-md-11 border2"><input style="height:100%;width:100%;" type="button" name="addRow" id="addRow" value="Add Row" onclick="addNewField()"></div>
	</div>
	<br><br>
	<div class="row" style="position:relative;left:-50px;">
		<div class="col-md-4"><b style="position:relative;top:2px;font-size:18px;">Total </b><input type="text" name="total" id="allTotal" readonly></div>
		<div class="col-md-4"><b style="position:relative;top:2px;font-size:18px;">Advance </b><input onchange="updateCharge(0)" type="text" name="total" id="_advance" value='0'></div>
		<div class="col-md-4"><b style="position:relative;top:2px;font-size:18px;">Balance </b><input type="text" name="total" id="_balance" readonly></div>
	</div>
</div>
<br><br>
<div class="row paidWarning" id="r1"><span style="color:red;font-size:24px;font-weight:bold;">Payment for the last invoice(s) is not yet paid.</span></div><br>
<div class="row addButtonRow" id="r1"><input class="mainField" onclick="addInvoice()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Invoice successfully added!</p></div>
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
		allTotal += parseFloat($("#v_total_"+i).html());
	}
	$("#allTotal").val(allTotal);
	$("#_balance").val(parseFloat($("#allTotal").val()) - parseFloat($("#_advance").val()));
}


function updateTotal(row)
{
	noneCharge(row);
	var weices = $("#v_weices_"+row).val();
	var weices = $("#v_weices_"+row).val();
	var rate = $("#v_rate_"+row).val();
	if(weices.length > 0 && rate.length > 0) {
		var total = parseFloat(rate) * parseFloat(weices);
		$("#v_total_"+row).html(total);
		var totalfields = $("#fieldsCount").val();
		var allTotal = 0;
		for(var i = 1;i <= totalfields;i++)
		{
			allTotal += parseFloat($("#v_total_"+i).html());
		}
		$("#allTotal").val(allTotal);
		$("#_balance").val(parseFloat($("#allTotal").val()) - parseFloat($("#_advance").val()));

	}
}

function addInvoice()
{
	var customerName = $("#custEle").val();
	var saleRep = $("#saleRep").val();
	var refNo = $("#refNo").val();
	var date = $("#dateEle").val();
	var weices = $("#weices").val();
	var paymentTime = $("#paymentTime").val();
	var totalfields = $("#fieldsCount").val();
	var enteredfields = 0;
	var jsonStr = "";
	var postStr = "cName="+customerName+"&saleRep="+saleRep+"&refNo="+refNo+"&date="+date+"&weices="+weices+"&advance="+$("#_advance").val()+"&paymentTime="+paymentTime;
	for(var i = 1;i <= totalfields;i++)
	{
		if(parseFloat($("#v_total_"+i).html()) > 0)
		{
			enteredfields++;
			jsonStr = '{"mat":"'+$('#v_mat_'+i).val()+'","type":"'+$('#v_type_'+i).val()+'","size":"'+$('#v_size_'+i).val()+'","charges":"'+$('#v_charges_'+i).val()+'","weices":"'+$('#v_weices_'+i).val()+'","rate":"'+$('#v_rate_'+i).val()+'","bag":"'+$('#v_bag_'+i).val()+'"}';
			postStr += "&data_"+enteredfields+"="+jsonStr;
		}
	}
	postStr += "&data_count="+enteredfields;
	//alert(postStr);

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {
            $("#not").hide();
            $("#not").text("Error while adding!");
            $("#not").css({color:'red'});
            $("#not").slideDown();
        }
        else
        {
            $("#not").slideUp();
            $("#not").text("Invoice Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            document.getElementById("addInvForm").reset();
            $(".v_total_Class").html("0");
            $("#custEle").focus();
						window.open("customers/invoice_print_window.php?no="+xhttp.responseText);
        }
    }};

    xhttp.open("POST", "do.php?action=addinvoice", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(postStr+"&ajax");
}

function OnCustomerChange()
{
	var customer = $("#custEle").val();
	setSaleRepForCustomer(customer);
	setRateByForCustomer(customer);
	//setAdvanceForCustomer(customer);
	setCustomerPaymentMethod(customer);
	setCustomerBill2BillStatus(customer);
}



function setCustomerBill2BillStatus(customer)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        if(xhttp.responseText == "1")
        {
        	alert("WARNING: Customer's last invoice bill is not yet paid.");
        	$(".paidWarning").slideDown();
        }
        else
        {
        	$(".paidWarning").slideUp();
        }
    }};

    xhttp.open("POST", "do.php?action=getlastinvoicestatus", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("customer="+customer+"&ajax");
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
        	$("#paymentTime").val("-1");
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
	var sr = parseFloat($("#fieldsCount").val()) + 1;
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
    $(".paidWarning").slideUp();

}
</script>
