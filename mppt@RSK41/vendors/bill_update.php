<div class="container addBox">
<div class="inBox"> 
<h1>Update Bill</h1>
<form id="addInvForm">
<?php
require "../123321.php";
$bill_id = $_GET['id'];
$qry = "SELECT b.*,v.name as vName FROM `bill` b,`vendor` v WHERE b.vendor = v.id and b.id = '$bill_id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
?>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Vendor</label></div><div class="col-md-4">
<input type="hidden" id="idEle" value="<?php echo $data['id']; ?>">
<input class="mainField" type='text' list='listid2' id="vendorEle" onchange="OnCustomerChange()" value="<?php echo $data['vName']; ?>">
<datalist id='listid2'>
	<?php
	
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
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Ref. #</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="refNo" id="refNo" placeholder="Reference No." value="<?php echo $data['ref']; ?>"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Date</label></div><div class="col-md-4"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo $data['date']; ?>"></div><div class="col-md-3"></div></div><br>
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
	
		<?php 
		$qry = "SELECT bd.*,c.name as cName FROM `bill_detail` bd,`customers` c WHERE bd.biller_id = c.id and bd.ref = '".$data['ref']."'";
		$run = mysqli_query($con,$qry) or die(mysqli_error($con));
		$i = 1;
		$allTotal = 0;
		while($row = mysqli_fetch_array($run))
		{
		?>
		<div class="row">
			<div class="col-md-1 border"><?php echo $i; ?></div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="size" id="v_ref2_<?php echo $i; ?>" value="<?php echo $row['ref2']; ?>">
			</div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="mat" list='billNamelist' id="v_billName_<?php echo $i; ?>" value="<?php echo $row['cName']; ?>">
			</div>
			<div class="col-md-2 border"><input class="inv_input" type="text" name="charges" id="v_particular_<?php echo $i; ?>" value="<?php echo $row['particular']; ?>"></div>
			<div class="col-md-2 border"><input class="inv_input" type="tempnam(dir, prefix)xt" name="weight" id="v_weices_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')" value="<?php echo $row['weices']; ?>"></div>
			<div class="col-md-1 border"><input class="inv_input" type="text" name="rate" id="v_rate_<?php echo $i; ?>" onchange="updateTotal('<?php echo $i; ?>')" value="<?php echo $row['rate']; ?>"></div>
			<div class="col-md-2 border v_total_Class" id="v_total_<?php echo $i; ?>"><?php $allTotal += intval($row['weices']) * intval($row['rate']); echo intval($row['weices']) * intval($row['rate']); ?></div>
		</div>
		<input class="inv_input" type="hidden" id="v_id_<?php echo $i; ?>" value="<?php echo $row['id']; ?>">
		<?php
		$i++;
		}
		?>
		<input type="hidden" name="fields" id="fieldsCount" value="<?php echo (intval($i) - 1); ?>">
	</div>
	<div class="row">		
		<div class="col-md-12 border2"><input style="height:100%;width:100%;" type="button" name="addRow" id="addRow" value="Add Row" onclick="addNewField()"></div>
	</div>
	<br><br>
	<div class="row" style="position:relative;left:-10px;">
		<div class="col-md-4"></div>
		<div class="col-md-2 text-left"><b style="position:relative;top:2px;font-size:18px;">Total </b></div><div class="col-sm-2"><input type="text" name="total" id="allTotal" value="<?php echo $allTotal; ?>" readonly></div>
		<div class="col-md-4"></div>

	</div>
</div>
<br><br>
<div class="row" id="r1"><input class="mainField" onclick="updateBill()" type="button" name="submit" value="Update"></div><br>
<div class="row" id="r1"><p id="not">Bill successfully added!</p></div>
</form>
<br><br>
<div id="payment_table">
<h1>Payment againts bill</h1>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;width:95%;position:relative;margin:0 auto;">
    <div class="col-sm-1 head_">Sr.</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('id')">Pay #</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('ref_no')">Ref #</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('bill_no')">Bill #</div>
    <div class="col-sm-2 head_" onclick="updatePaymentList('vname')">Vendor</div>
    <div class="col-sm-2 head_" onclick="updatePaymentList('ename')">Paid By</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('paid_date')">Paid Date</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('entry_date')">Entry Date</div>
    <div class="col-sm-2 head_" onclick="updatePaymentList('amount')"> Amount</div>
</div>
<?php
$qry = "SELECT p.id,p.ref_no,p.bill_no,v.name as vname,e.name as ename,p.amount,p.paid_date,p.entry_date FROM `payments_paid` p,vendor v,employee e WHERE p.vendor = v.id and p.payer = e.id  and p.bill_no = '".$bill_id."' order by `id` ";
//echo $qry;
$count = 0;             
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data = mysqli_fetch_array($run))
{

if($count++ % 2 == 0) $color = "rgba(0,0,0,0.05);";
else $color = "rgba(0,0,0,0.15);";            
?>
<div class="row" id="inv_data" onclick="viewPayment('<?php echo $data['id'] ?>')" style="background-color:<?php echo $color; ?>;width:95%;position:relative;margin:0 auto;">
    <div class="col-sm-1 no-border"><?php echo $count; ?></div>
    <div class="col-sm-1 no-border"><?php echo "PD-"; echo $data['id']; ?></div>
    <div class="col-sm-1 no-border"><?php echo $data['ref_no']; ?></div>
    <div class="col-sm-1 no-border">Bill-<?php echo $data['bill_no']; ?></div>
    <div class="col-sm-2 no-border"><?php echo $data['vname']; ?></div>
    <div class="col-sm-2 no-border"><?php echo $data['ename']; ?></div>
    <div class="col-sm-1 no-border"><?php echo $data['paid_date']; ?></div>
    <div class="col-sm-1 no-border"><?php echo $data['entry_date']; ?></div>
    <div class="col-sm-2 no-border">Rs. <?php echo $data['amount']; ?></div>
</div>
<?php
}
if($count === 0)
{
?>
<div class="row" onclick="viewPayment('<?php echo $data['id'] ?>')" style="background-color:<?php echo $color; ?>;width:95%;position:relative;margin:0 auto;">
<div class="col-sm-12 no-border">No payments record for this bill!</div>
</div>	
<?php
}
?>
</div><br><br>
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

function updateBill()
{
	var bid = $("#idEle").val();
	var vendorName = $("#vendorEle").val();
	var refNo = $("#refNo").val();
	var date = $("#dateEle").val();

	var totalfields = $("#fieldsCount").val();
	var enteredfields = 0;
	var jsonStr = "";
	var postStr = "id="+bid+"&vendor="+vendorName+"&refNo="+refNo+"&date="+date;
	for(var i = 1;i <= totalfields;i++)
	{
		if(parseInt($("#v_total_"+i).html()) > 0)
		{
			enteredfields++;
			jsonStr = '{"id":"'+$('#v_id_'+i).val()+'","ref2":"'+$('#v_ref2_'+i).val()+'","billName":"'+$('#v_billName_'+i).val()+'","particular":"'+$('#v_particular_'+i).val()+'","weices":"'+$('#v_weices_'+i).val()+'","rate":"'+$('#v_rate_'+i).val()+'"}';
			postStr += "&data_"+enteredfields+"="+jsonStr;
		}
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

    xhttp.open("POST", "do.php?action=updatebill", true);
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
	$("#inv_fields").append('		<div class="row">\
			<div class="col-md-1 border">'+sr+'</div>\
			<div class="col-md-2 border"><input class="inv_input" type="text" name="size" id="v_ref2_'+sr+'">\
			</div>\
			<div class="col-md-2 border"><input class="inv_input" type="text" name="mat" list="billNamelist" id="v_billName_'+sr+'" >\
			</div>\
			<div class="col-md-2 border"><input class="inv_input" type="text" name="charges" id="v_particular_'+sr+'"></div>\
			<div class="col-md-2 border"><input class="inv_input" type="tempnam(dir, prefix)xt" name="weight" id="v_weices_'+sr+'" onchange="updateTotal('+sr+')"></div>\
			<div class="col-md-1 border"><input class="inv_input" type="text" name="rate" id="v_rate_'+sr+'" onchange="updateTotal('+sr+')"></div>\
			<div class="col-md-2 border v_total_Class" id="v_total_'+sr+'">0</div>\
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