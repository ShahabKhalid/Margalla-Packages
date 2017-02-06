<div class="container addBox" style="width:95%">
<div class="inBox">
<div class="row">
<div class="col-sm-12 text-center">
	<?php
	require "../123321.php";
	if(!isset($_GET['year']) && !isset($_GET['month']))
	{
	$year = date("Y");
	$month = date("m");
	}
	else
	{
	$year = $_GET['year'];
	$month = $_GET['month'];
	}
			switch ($month) {
				case 1:
					$monthT = "Jan";
					break;
				case 2:
					$monthT = "Feb";
					break;
				case 3:
					$monthT = "March";
					break;
				case 4:
					$monthT = "April";
					break;
				case 5:
					$monthT = "May";
					break;
				case 6:
					$monthT = "June";
					break;
				case 7:
					$monthT = "July";
					break;
				case 8:
					$monthT = "Aug";
					break;
				case 9:
					$monthT = "Sep";
					break;
				case 10:
					$monthT = "Oct";
					break;
				case 11:
					$monthT = "Nov";
					break;
				case 12:
					$monthT = "Dec";
					break;

				default:
					$monthT = "Unknown";
					break;
			}
	?>
<h1>Account Ledger</h1>
<?php
$qry = "SELECT * FROM `Ledgers` WHERE id = '".$_GET['id']."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$total = 0;
$id = $_GET['id'];
?>
<h3><?php echo "Account : ".$data['name'];?></h3>
<br>
</div>
</div>
<div class="row" style="font-size:16px;">
<div class="col-sm-12 text-center">
	<select id="yearOpt">
		<option value="2016" <?php if(intval($year) == 2016) echo "selected"; ?>>2016</option>
		<option value="2017" <?php if(intval($year) == 2017) echo "selected"; ?>>2017</option>
	</select>
<select id="monthOpt">
		<option value="1" <?php if(intval($month) == 1) echo "selected"; ?>>Jan</option>
		<option value="2" <?php if(intval($month) == 2) echo "selected"; ?>>Feb</option>
		<option value="3" <?php if(intval($month) == 3) echo "selected"; ?>>March</option>
		<option value="4" <?php if(intval($month) == 4) echo "selected"; ?>>April</option>
		<option value="5" <?php if(intval($month) == 5) echo "selected"; ?>>May</option>
		<option value="6" <?php if(intval($month) == 6) echo "selected"; ?>>June</option>
		<option value="7" <?php if(intval($month) == 7) echo "selected"; ?>>July</option>
		<option value="8" <?php if(intval($month) == 8) echo "selected"; ?>>Aug</option>
		<option value="9" <?php if(intval($month) == 9) echo "selected"; ?>>Sep</option>
		<option value="10" <?php if(intval($month) == 10) echo "selected"; ?>>Oct</option>
		<option value="11" <?php if(intval($month) == 11) echo "selected"; ?>>Nov</option>
		<option value="12" <?php if(intval($month) == 12) echo "selected"; ?>>Dec</option>
	</select>
	<button onclick="refreshPage(<?php echo $id; ?>)">Go</button>
	<button onclick="refreshPage(<?php echo $id; ?>,1)">All</button>
</div>
</div>
<br>

<input type="hidden" id="accountID" value="<?php echo $data['id']; ?>">
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Particular</div>
	<div class="col-sm-1">Bill #</div>
	<div class="col-sm-1">Pay #</div>
	<div class="col-sm-2">Date</div>
	<div class="col-sm-2">Debit</div>
	<div class="col-sm-1">Credit</div>
	<div class="col-sm-1">Balance</div>
	<div class="col-sm-1">Edit</div>
	<div class="col-sm-1">Delete</div>
</div>
<div id="tableDIV">
<?php
if(intval($year) == 0) $qry = "SELECT * FROM `Ledgers_bill` WHERE ref = '".$_GET['id']."'";
else $qry = "SELECT * FROM `Ledgers_bill` WHERE date >= '$year-$month-01' and date <= '$year-$month-31' and ref = '".$_GET['id']."'";
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
	<div class="col-sm-2"><?php if($data2['bill'] == '1') { echo $data2['amount']; $total += floatval($data2['amount']); } else  echo "---"; ?></div>
		<div class="col-sm-1"><?php if($data2['bill'] == '0') { echo $data2['amount']; $total -= floatval($data2['amount']); } else  echo "---"; ?></div>
	<div class="col-sm-1"><?php echo "Rs. ".number_format(floatval($total)); ?></div>
	<div class="col-sm-1"><a href='javascript:void()' onclick="editEntry('<?php echo $lid; ?>','<?php echo $id; ?>')">Edit</a></div>
	<div class="col-sm-1"><a href='javascript:void()' onclick="deleteEntry('<?php echo $lid; ?>','<?php echo $id; ?>')">Delete</a></div>
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
<a href="javascript:void()" onclick="return exportLedger('<?php echo $id; ?>')">Export to excel</a>
<!-- <a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a> -->
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function refreshPage(id,all = null) {
	if(all != null) {
			pageLoad("ledgers	/ledger.php?id="+id+"&year=0&month=0");
	}
	else {
		var year = $("#yearOpt").val();
		var month = $("#monthOpt").val();
		pageLoad("ledgers/ledger.php?id="+id+"&year="+year+"&month="+month);

	}
}

function editEntry(id,lid)
{
		pageLoad("ledgers/editbill.php?id="+id+"&lid="+lid)
}

function deleteEntry(id,lid)
{
		if(confirm("Delete entry?")) {
	    var xhttp = new XMLHttpRequest();
	    xhttp.onreadystatechange = function() {
	    if (xhttp.readyState != 4)
	    {

	    }
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
						pageLoad("ledgers/ledger.php?id="+lid)
	    }};

	    xhttp.open("POST", "do.php?action=deleteLedgerEntry", true);
	    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    xhttp.send("id="+id+"&ajax");
		}
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

function exportLedger(id)
{
	window.open("ledgers/ledger_export.php?id="+id);
}
</script>
