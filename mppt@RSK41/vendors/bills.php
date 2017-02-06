<div class="container addBox" style="width:90%;">
<div class="inBox">
	<?php
	require "../123321.php";
	if(!isset($_GET['year']) && !isset($_GET['month']))
	{
		$year = '0';
		$month = '0';
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
	$id = $_GET['id'];
	$qry = "SELECT * FROM `vendor` WHERE `id` = '$id'";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data = mysqli_fetch_array($run);
	?>
<h1>Bills</h1>
<div class="row">
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
<input type="hidden" value="<?php echo $id; ?>" id="_id">
<button onclick="updateBillList()">Go</button>
<button onclick="updateBillList(null,1)">Show All</button>
</div>
</div><br>
<div class="row" id="r2">
<div class="col-md-11"></div>
<div class="col-md-1 text-right"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box2">
<br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Bill #</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_bill" placeholder="Bill #" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Ref #</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_ref" placeholder="Ref #" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Date</span></div>
	<div class="col-sm-1 text-left"><input type="text" id="filter_date" placeholder="Date" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Vendor</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_vendor" placeholder="Vendor Name" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Amount</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_amount" placeholder="Amount" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Balance</span></div>
	<div class="col-sm-1 text-left"><input type="text" id="filter_balance" placeholder="Balance" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Payments</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_payment" placeholder="Payment" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Paid</span></div>
	<div class="col-sm-1 text-left"><input type="checkbox" id="f_paid" value="1" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Not Paid</span></div>
	<div class="col-sm-1 text-left"><input type="checkbox" id="f_npaid" value="1" onchange="updateBillList(orderByWas)"></div>
	<div class="col-sm-1"></div>
</div><br>
</div>
<div class="row row_inv" style="background-color:rgba(0,0,0,.7);color:white;">
	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-2 border3 head_">Edit</div>
			<div class="col-sm-1 border3 head_">Sr.</div>
			<div class="col-sm-1 border3 head_" onclick="updateBillList('b.id')">Bill #</div>
			<div class="col-sm-2 border3 head_" onclick="updateBillList('b.ref')">Ref. #</div>
			<div class="col-sm-2 border3 head_" onclick="updateBillList('b.date')">Date</div>
			<div class="col-sm-4 border3 head_" onclick="updateBillList('v.name')">Vendor</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-4 border3 head_">Bill amount</div>
			<div class="col-sm-4 border3 head_">Balance</div>
			<div class="col-sm-4 border3 head_">Payments</div>
		</div>
	</div>
</div>
<div id="bill_table">
</div>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
var orderByWas;
function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$(".filter-box2").slideUp();
	updateBillList('id');
	orderByWas = 'id';
}


function updateBillList(orderBy = null,all = null)
{
	if(orderBy == null) orderBy = orderByWas
	var year = $("#yearOpt").val();
	var month = $("#monthOpt").val();
	var bill = $("#filter_bill").val();
	var ref = $("#filter_ref").val();
	var date = $("#filter_date").val();
	var vendor = $("#filter_vendor").val();
	var amount = $("#filter_amount").val();
	var balance = $("#filter_balance").val();
	var payment = $("#filter_payment").val();
	var filter_qry = "";

	if(bill.length > 0) filter_qry += "&f_bill="+bill;
	if(ref.length > 0) filter_qry += "&f_ref="+ref;
	if(date.length > 0) filter_qry += "&f_date="+date;
	if(vendor.length > 0) filter_qry += "&f_vendor="+vendor;
	if(amount.length > 0) filter_qry += "&f_amount="+amount;
	if(balance.length > 0) filter_qry += "&f_balance="+balance;
	if(payment.length > 0) filter_qry += "&f_payment="+payment;
	if($("#f_paid").is(':checked')) filter_qry += "&f_paid="+bill;
	if($("#f_npaid").is(':checked')) filter_qry += "&f_npaid="+inv;



	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        if(xhttp.responseText != "0") {
        $("#bill_table").html(xhttp.responseText); }
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updateBillTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		if(all != null) xhttp.send("orderBy="+orderBy+filter_qry+"&year=0&month=0&ajax");
		else xhttp.send("orderBy="+orderBy+filter_qry+"&year="+year+"&month="+month+"&ajax");
}

function viewBill(id)
{
	pageLoad("vendors/bill_update.php?id="+id);
}

function printInvoice(id)
{
	pageLoad("customers/invoice_print.php?id="+id);
}


function toggleFilter()
{
	if ($('.filter-box2').is(':visible'))
	{
		$(".filter-box2").slideUp();
	}
	else
	{
		$(".filter-box2").slideDown();
	}
}


</script>
