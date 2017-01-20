<div class="container addBox">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Account Ledger</h1>
</div>
<?php
require "../123321.php";
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;"></span>
</div>
</div>
<br>
<?php
$qry = "SELECT * FROM `Ledgers` WHERE id = '".$_GET['id']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$total = 0;
?>
<h3><?php echo "Account : ".$data['name'];?></h3>
<br>
<input type="hidden" id="accountID" value="<?php echo $data['id']; ?>">
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Particular</div>
	<div class="col-sm-1">Bill #</div>
	<div class="col-sm-1">Pay #</div>
	<div class="col-sm-2">Date</div>
	<div class="col-sm-2">Debit</div>
	<div class="col-sm-2">Credit</div>
	<div class="col-sm-1">Balance</div>
	<div class="col-sm-1">Delete</div>
</div>
<div id="tableDIV">
<?php
$qry = "SELECT * FROM `Ledgers_bill` WHERE ref = '".$_GET['id']."'";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data2 = mysqli_fetch_array($run2))
{
$lid = $data2['id'];
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2"><?php echo $data2['particular']; ?></div>
  <div class="col-sm-1"><?php if($data2['bill'] == '1')  echo "BILL-".$data2['id']; else echo "--"; ?></div>
	<div class="col-sm-1"><?php if($data2['bill'] == '0') echo "PY-".$data2['id']; else echo "--"; ?></div>
	<div class="col-sm-2"><?php echo $data2['date']; ?></div>
	<div class="col-sm-2"><?php if($data2['bill'] == '1') { echo $data2['amount']; $total += intval($data2['amount']); } else  echo "---"; ?></div>
		<div class="col-sm-2"><?php if($data2['bill'] == '0') { echo $data2['amount']; $total -= intval($data2['amount']); } else  echo "---"; ?></div>
	<div class="col-sm-1"><?php echo "Rs. ".number_format(intval($total)); ?></div>
	<div class="col-sm-1"><a href='javascript:void()' onclick="deleteEntry('<?php echo $lid; ?>')">Delete</a></div>
	</div>	
	<?php
	}

?>
</div>
<br>
<!-- ADD -->
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">
		<input type="text" id="particular" length="255" style="width:100%;height:30px;">
	</div>
  <div class="col-sm-1">
  	<input style="width:100%;height:30px;" type="text" id="billno" value="Auto" readonly>
  </div>
	<div class="col-sm-1">
  		<input style="width:100%;height:30px;" type="text" id="payno" value="Auto" readonly>		
	</div>
	<div class="col-sm-2">
  		<input style="width:100%;height:30px;" type="text" id="date" value="<?php echo date('Y-m-d'); ?>">		
	</div>
	<div class="col-sm-2">
		<input style="width:100%;height:30px;" type="text" id="bill" placeholder="Bill">
	</div>
		<div class="col-sm-2">
			<input style="width:100%;height:30px;" type="text" id="pay" placeholder="Pay">
		</div>
	<div class="col-sm-2">
		<input style="width:100%;height:30px;" type="button" id="addL" value="Add" onclick="AddLedger()">
	</div>
</div>	
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-3"></div>
	<div class="col-sm-6"></div>
	<div class="col-sm-1">Total</div>
	<div class="col-sm-2" id="totalBalDIV">Rs. <?php echo number_format($total); ?></div>
	<input id="totalBal" type="hidden" value="<?php echo $total; ?>">
</div>



<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>


function deleteEntry(id)
{
	alert(id);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
    }};

    xhttp.open("POST", "do.php?action=deleteLedgerEntry", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");
}


function AddLedger()
{
	var part = $("#particular").val();
	var opt ='1';
	var date = $("#date").val();
	var amount = 0;
	var accountID = $("#accountID").val();
	var bal = 0;
	var xhttp = new XMLHttpRequest();

	if($("#bill").val().length > 0 && $("#pay").val().length > 0)
	{
		return alert("Please enter only bill or pay!");
	}
	else if($("#bill").val().length == 0 && $("#pay").val().length == 0)
	{
		return alert("Please enter either bill or pay!");
	}
	else if($("#bill").val().length > 0 && $("#pay").val().length == 0)
	{
		opt = '1';
	}
	else if($("#bill").val().length == 0 && $("#pay").val().length > 0)
	{
		opt = '2';
	}

	if(opt === '1')
	{		
		if($("#bill").val().length === 0) return alert("Please enter bill.");
		amount = $("#bill").val();								
		xhttp.open("POST", "do.php?action=addLbill", true);
  	  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  		xhttp.send("account="+accountID+"&particular="+part+"&date="+date+"&amount="+amount+"&ajax");
  		bal = parseFloat($("#totalBal").val()) + parseFloat(amount);
  		xhttp.onreadystatechange = function() {
	    if (xhttp.readyState != 4)
	    {

	    }
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	        //alert(xhttp.responseText);
	        if(xhttp.responseText === "0")
	        {

	        }
	        else if(xhttp.responseText === "1")
	        {
	        	$("#tableDIV").html($("#tableDIV").html() + "<div class='row' style='width:95%;position:relative;margin:0 auto;'>\
										<div class='col-sm-2'>" + part + "</div>\
	  									<div class='col-sm-1'>" + "ToBeUpdated" + "</div>\
										<div class='col-sm-1'>" + "--" + "</div>\
										<div class='col-sm-2'>" + date + "</div>\
										<div class='col-sm-2'>" + amount + "</div>\
										<div class='col-sm-2'>" + "--" + "</div>\
										<div class='col-sm-2'>Rs." + bal + "</div>\
										</div>	");
	        }
	    }};
	}
	else
	{
		if($("#pay").val().length === 0) return alert("Please enter pay.");                  	
		amount = $("#pay").val();		
		xhttp.open("POST", "do.php?action=addLPayment", true);
    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	xhttp.send("account="+accountID+"&particular="+part+"&date="+date+"&amount="+amount+"&ajax");
  		bal = parseFloat($("#totalBal").val()) - parseFloat(amount);    	
  		xhttp.onreadystatechange = function() {
	    if (xhttp.readyState != 4)
	    {

	    }
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	        //alert(xhttp.responseText);
	        if(xhttp.responseText === "0")
	        {

	        }
	        else if(xhttp.responseText === "1")
	        {
	        	$("#tableDIV").html($("#tableDIV").html() + "<div class='row' style='width:95%;position:relative;margin:0 auto;'>\
										<div class='col-sm-2'>" + part + "</div>\
	  									<div class='col-sm-1'>" + "--" + "</div>\
										<div class='col-sm-1'>" + "ToBeUpdated" + "</div>\
										<div class='col-sm-2'>" + date + "</div>\
										<div class='col-sm-2'>" + "--" + "</div>\
										<div class='col-sm-2'>" + amount + "</div>\
										<div class='col-sm-2'>--</div>\
										</div>");
	        }
	    }};    	
	}

	$("#totalBalDIV").html("Rs." + bal);
	$("#totalBal").val(bal);


}

function changeOptions()
{
	var opt = $("#particular").val();
	if(opt === '1')
	{
		$("#payno").prop("readonly", true);		
		$("#billno").prop("readonly", false);	
		$("#pay").prop("readonly", true);		
		$("#bill").prop("readonly", false);	
	}
	else
	{
		$("#payno").prop("readonly", false);		
		$("#billno").prop("readonly", true);	
		$("#pay").prop("readonly", false);		
		$("#bill").prop("readonly", true);
	}
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
