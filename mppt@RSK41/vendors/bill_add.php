<div class="container addBox">
<div class="inBox"> 
<h1>New Bill</h1>
<form id="addInvForm">
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Vendor</label></div><div class="col-md-4">
<input class="mainField" type='text' list='listid2' id="custEle" onchange="OnCustomerChange()">
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
</datalist>
<datalist id='billNamelist'>
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
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Ref. #</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="refNo" id="refNo" placeholder="Reference No."></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo date('Y-m-d'); ?>"></div><div class="col-md-3"></div></div><br>
<br>
<div class="inv_table" style="position:relative;left:-50px;">
	<div class="row">
		<div class="col-md-1 border head_">Sr.</div>
		<div class="col-md-2 border head_">Ref2 #</div>
		<div class="col-md-2 border head_">Billing Name</div>
		<div class="col-md-2 border head_">Particular</div>
		<div class="col-md-2 border head_">Weight/Size</div>
		<div class="col-md-1 border head_">Rate</div>
		<div class="col-md-2 border head_">Total</div>
	</div>
	<div id="inv_fields">	
	<input type="hidden" name="fields" id="fieldsCount" value="4">
		<?php 
		for($i = 1;$i < 5;$i++)
		{
		?>
		<div class="row">
			<div class="col-md-1 border"><?php echo $i; ?></div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="size" id="v_ref2_<?php echo $i; ?>">
			</div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="mat" list='billNamelist' id="v_billName_<?php echo $i; ?>">
			</div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="charges" id="v_particular_<?php echo $i; ?>" ></div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="weight" id="v_weices_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="rate" id="v_rate_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')"></div>
			<div class="col-md-2 border v_total_Class" id="v_total_<?php echo $i; ?>">0</div>
		</div>
		<?php
		}
		?>
	</div>
	<div class="row">		
		<div class="col-md-12 border2"><input style="height:100%;width:100%;" type="button" name="addRow" id="addRow" value="Add Row" onclick="addNewField()"></div>
	</div>
	<br><br>
	<div class="row" style="position:relative;left:-10px;">
		<div class="col-md-4"></div>
		<div class="col-md-2 text-left"><b style="position:relative;top:2px;font-size:18px;">Total </b></div><div class="col-sm-2"><input type="text" name="total" id="allTotal" readonly></div>
		<div class="col-md-4"></div>

	</div>
</div>
<br><br>
<div class="row" id="r1"><input class="mainField" onclick="addBill()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Bill successfully added!</p></div>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>

function updateTotal(row)
{
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

function addBill()
{
	var vendorName = $("#custEle").val();
	var refNo = $("#refNo").val();
	var date = $("#dateEle").val();

	var totalfields = $("#fieldsCount").val();
	var enteredfields = 0;
	var jsonStr = "";
	var postStr = "vendor="+vendorName+"&refNo="+refNo+"&date="+date;
	var repeat = false;
    for(var i = 1;i <= totalfields;i++) {
        var ref2 = $('#v_ref2_'+i).val();
        if(ref2.length === 0) continue;
        for(var j = 1;j <= totalfields;j++) {
            if(i == j) continue;
            if(ref2 === $('#v_ref2_'+j).val()) {
                repeat = true;
            }
        }
    }
    if(repeat) {
        alert("Ref2 must be unique for each sub-bill!");
        return;
    }
	for(var i = 1;i <= totalfields;i++)
	{
		if(parseInt($("#v_total_"+i).html()) > 0)
		{
			enteredfields++;
			jsonStr = '{"ref2":"'+$('#v_ref2_'+i).val()+'","billName":"'+$('#v_billName_'+i).val()+'","particular":"'+$('#v_particular_'+i).val()+'","weices":"'+$('#v_weices_'+i).val()+'","rate":"'+$('#v_rate_'+i).val()+'"}';
			postStr += "&data_"+enteredfields+"="+jsonStr;
		}
	}
	postStr += "&data_count="+enteredfields;
	alert(postStr);


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
            $("#not").text("Bill Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();  
            document.getElementById("addInvForm").reset();  
            $(".v_total_Class").html("0");
            $("#custEle").focus();            
        }
    }};  

    xhttp.open("POST", "do.php?action=addbill", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(postStr+"&ajax");
}

function OnCustomerChange()
{
	var customer = $("#custEle").val();
	setSaleRepForCustomer(customer);
	setRateByForCustomer(customer);
	setAdvanceForCustomer(customer);
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
}
</script>