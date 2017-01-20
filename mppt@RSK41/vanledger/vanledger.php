<div class="container addBox" style="width:95%;">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Van Ledger</h1>
</div>
<?php
require "../123321.php";
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;"></span>
</div>
</div>
<br>
<input type="hidden" id="accountID" value="<?php echo $data['id']; ?>">
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-2">Date</div>
			<div class="col-sm-2">Sender Name</div>
			<div class="col-sm-2">Party Name</div>
			<div class="col-sm-2">Location</div>
			<div class="col-sm-2">Rent</div>
			<div class="col-sm-2">Toll</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="row">	
		<div class="col-sm-2">Rec</div>
		<div class="col-sm-2">Ledger</div>
		<div class="col-sm-2">Petrol</div>
		<div class="col-sm-2">InHand</div>
		<div class="col-sm-2">Profit</div>
		<div class="col-sm-2"></div>
		</div>
	</div>	
</div>
<div id="tableDIV">
<?php
$qry = "SELECT vl.*,c.name as cName FROM `vanledger` vl,`customers` c WHERE vl.PartyName = c.id";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$Profit = 0;
$InHand = 0;
$totRent = 0;
$totToll = 0;
$totRec = 0;
$totLedger = 0;
$totPetrol = 0;
$tot_1 = 0;
$rec_1 = 0;
$tot_2 = 0;
$rec_2 = 0;
$tot_3 = 0;
$rec_3 = 0;
$tot_4 = 0;
$rec_4 = 0;
while($data2 = mysqli_fetch_array($run2))
{
$InHand += floatval($data2['Rent']) - floatval($data2['Toll']) - floatval($data2['Petrol']) - floatval($data2['Ledger']);
$Profit += floatval($data2['Rate']) - floatval($data2['Petrol']);
$totRent += floatval($data2['Rate']);
$totToll += floatval($data2['Toll']);
$totRec += floatval($data2['Rent']);
$totLedger += floatval($data2['Ledger']);
$totPetrol += floatval($data2['Petrol']);
if(strcmp($data2['SenderName'],"Sh. Zubair") === 0)
{
	$tot_1 += floatval($data2['Rate']);
	$rec_1 += floatval($data2['Rent']);
}
else if(strcmp($data2['SenderName'],"Sameer") === 0)
{
	$tot_2 += floatval($data2['Rate']);
	$rec_2 += floatval($data2['Rent']);
}
else if(strcmp($data2['SenderName'],"Sheikh Father") === 0)
{
	$tot_3 += floatval($data2['Rate']);
	$rec_3 += floatval($data2['Rent']);
}
else if(strcmp($data2['SenderName'],"Factory") === 0)
{
	$tot_4 += floatval($data2['Rate']);
	$rec_4 += floatval($data2['Rent']);
}
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['Date']; ?></div>
			<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['SenderName']; ?></div>
			<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['cName']; ?></div>
			<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['Location']; ?></div>
			<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['Rate']; ?></div>
			<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['Toll']; ?></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="row">	
		<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['Rent']; ?></div>
		<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['Ledger']; ?></div>
		<div class="col-sm-2" style="border:1px solid black;height:40px;"><?php echo $data2['Petrol']; ?></div>
		<div class="col-sm-2" style="border:1px solid black;height:40px;">Rs. <?php echo $InHand; ?></div>
		<div class="col-sm-2" style="border:1px solid black;height:40px;">Rs. <?php echo $Profit; ?></div>
		<div class="col-sm-2" style="border:1px solid black;height:40px;"><a href="javascript:void();" onclick="deleteEntry(<?php echo $data2['id']; ?>)">Delete</a></div>
		</div>
	</div>	
</div>
	<?php
	}

?>
</div>
<input type="hidden" id="InHandVAL" value="<?php echo $InHand; ?>">
<input type="hidden" id="ProfitVAL" value="<?php echo $Profit; ?>">
<br>
<!-- ADD -->
<datalist id="senderNames">
	<option>Sh. Zubair</option>
	<option>Sameer</option>
	<option>Sheikh Father</option>
	<option>Factory</option>
</datalist>
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
<form id="vanLedger">
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="date" value="<?php echo date('Y-m-d'); ?>"></div>
			<div class="col-sm-2"><input list="senderNames" style="width:100%;height:30px;" type="text" id="senderName" placeholder="Sender Name"></div>
			<div class="col-sm-2"><input list="listid2" style="width:100%;height:30px;" type="text" id="partyName" placeholder="Party Name"></div>
			<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="Location" placeholder="Location"></div>
			<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="Rate" placeholder="Rate" value="0"></div>
			<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="Toll" placeholder="Toll" value="0"></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="row">	
		<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="Rent" placeholder="Rent" value="0"></div>
		<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="Ledger" placeholder="Ledger" value="0"></div>
		<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="Petrol" placeholder="Petrol" value="0"></div>
		<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="InHand" value="Auto" readonly></div>
		<div class="col-sm-2"><input style="width:100%;height:30px;" type="text" id="Profit" value="Auto" readonly></div>
		<div class="col-sm-2"><input style="width:100%;height:30px;" type="button" onclick="addVANLedger()" value="Add"></div>
		</div>
	</div>	
</div>
</form>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-8"><b>Total</b></div>
			<div class="col-sm-2"><b>Rs. <?php echo $totRent; ?></b></div>
			<div class="col-sm-2"><b>Rs. <?php echo $totToll; ?></b></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="row">	
		<div class="col-sm-2"><b>Rs. <?php echo $totRec; ?></b></div>
		<div class="col-sm-2"><b>Rs. <?php echo $totLedger; ?></b></div>
		<div class="col-sm-2"><b><?php echo $totPetrol; ?></b></div>
		<div class="col-sm-2"><b>Rs. <?php echo $InHand; ?></b></div>
		<div class="col-sm-2"><b>Rs. <?php echo $Profit; ?></b></div>
		<div class="col-sm-2"></div>
		</div>
	</div>	
</div>
<br><br><br><br>
<div class="container" style="width:50%;">
	<div class="row">
		<div class="col-sm-4" style="border:1px solid black;font-weight:bold;">Name</div>
		<div class="col-sm-4" style="border:1px solid black;font-weight:bold;">Total</div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Received</div>
		<div class="col-sm-2" style="border:1px solid black;font-weight:bold;">Balance</div>
	</div>
</div>
<div class="container" style="width:50%;">
	<div class="row">
		<div class="col-sm-4" style="border:1px solid black;">Sh. Zubair</div>
		<div class="col-sm-4" style="border:1px solid black;"><?php echo $tot_1; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo $rec_1; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo ($tot_1 - $rec_1); ?></div>
	</div>
</div>
<div class="container" style="width:50%;">
	<div class="row">
		<div class="col-sm-4" style="border:1px solid black;">Sameer</div>
		<div class="col-sm-4" style="border:1px solid black;"><?php echo $tot_2; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo $rec_2; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo ($tot_2 - $rec_2); ?></div>
	</div>
</div>
<div class="container" style="width:50%;">
	<div class="row">
		<div class="col-sm-4" style="border:1px solid black;">Zubair Father</div>
		<div class="col-sm-4" style="border:1px solid black;"><?php echo $tot_3; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo $rec_3; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo ($tot_3 - $rec_3); ?></div>
	</div>
</div>
<div class="container" style="width:50%;">
	<div class="row">
		<div class="col-sm-4" style="border:1px solid black;">Factory</div>
		<div class="col-sm-4" style="border:1px solid black;"><?php echo $tot_4; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo $rec_4; ?></div>
		<div class="col-sm-2" style="border:1px solid black;"><?php echo ($tot_4 - $rec_4); ?></div>
	</div>
</div>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function deleteEntry(id)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {

        }
        else if(xhttp.responseText === "1")
        {
        	pageLoad("vanledger.php");
        }
    }};

    xhttp.open("POST", "do.php?action=deleteVanLedgerEntry", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");
}
function addVANLedger() {
	var vanForm = document.getElementById("vanLedger");
	var date = vanForm[0].value;
	var senderName = vanForm[1].value;
	var partyName = encodeURIComponent(vanForm[2].value);
	var Location = vanForm[3].value;
	var Rate = vanForm[4].value;
	var Toll = vanForm[5].value;
	var Rent = vanForm[6].value;
	var Ledger = vanForm[7].value;
	var Petrol = vanForm[8].value;
	var InHand = parseFloat($("#InHandVAL").val()) + parseFloat(Rent) - parseFloat(Toll) - parseFloat(Petrol) - parseFloat(Ledger);
	var Profit = parseFloat($("#ProfitVAL").val()) + parseFloat(Rate) - parseFloat(Petrol);
	$("#InHandVAL").val(InHand);
	$("#ProfitVAL").val(Profit);

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {

        }
        else if(xhttp.responseText === "1")
        {
        	$("#tableDIV").html($("#tableDIV").html() + '<div class="row" style="width:95%;position:relative;margin:0 auto;">\
			<div class="col-sm-6">\
				<div class="row">\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+date+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+senderName+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+vanForm[2].value+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+Location+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+Rate+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+Toll+'</div>\
					</div>\
				</div>\
				<div class="col-sm-6">\
					<div class="row">\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+Rent+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+Ledger+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+Petrol+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">Rs. '+InHand+'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">Rs. '+ Profit +'</div>\
					<div class="col-sm-2" style="border:1px solid black;height:40px;">'+'Refresh To Get'+'</div>\
					</div>\
				</div>	\
			</div>');




            addForm.reset();
            $("#date").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=addVanLedger", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("date="+date+"&senderName="+senderName+"&partyName="+partyName+"&Location="+Location+"&Rate="+Rate+"&Toll="+Toll+"&Rent="+Rent+"&Ledger="+Ledger+"&Petrol="+Petrol+"&InHand="+InHand+"&ajax");
}


function printView(id)
{
	window.open("customers/customer_ledger_print.php?id="+id);
}
function viewPayment(id)
{
    pageLoad("customers/payment_update.php?id="+id);
}

function viewInvoice(id)
{
	pageLoad("customers/invoice_print.php?id="+id);
}
</script>
