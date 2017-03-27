<div class="container-fluid addBox" style="width:98%;">
<div class="inBox">
    <?php
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
<h1>Invoices</h1>
    <br>
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
            <button onclick="updateInvoiceList(orderByWas,dueWas)">Go</button>
            <button onclick="updateInvoiceList(orderByWas,dueWas,1)">All</button>
        </div>
    </div>
    <br><br>
<div class="container-fluid due-box">
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-2 pointer"><div onclick="updateInvoiceList(orderByWas,1)" style="background-color:black;padding:20px;color:lime;font-size:18px;font-weight:bold;box-shadow:1px 5px 5px gray;">1 Month Due</div></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2 pointer"><div onclick="updateInvoiceList(orderByWas,2)" style="background-color:black;padding:20px;color:orange;font-size:18px;font-weight:bold;box-shadow:1px 5px 5px gray;">2 Months Due</div></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2 pointer"><div onclick="updateInvoiceList(orderByWas,3)" style="background-color:black;padding:20px;color:red;font-size:18px;font-weight:bold;box-shadow:1px 5px 5px gray;">3 Months Due</div></div>
	<div class="col-sm-2"></div>
</div>
</div>
<br>
<div class="row" id="r2">
<div class="col-md-8"></div>
<div class="col-md-2 text-right"><b><a href="javascript:void()" onclick="exportExcel()">Export to excel</a></b></div>
<div class="col-md-1 text-right"><b><a href="javascript:void()" onclick="PrintList()">Print</a></b></div>
<div class="col-md-1 text-right"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box2">
<br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Inv #</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_inv" placeholder="Inv #" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Ref #</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_ref" placeholder="Ref #" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Date</span></div>
	<div class="col-sm-1 text-left"><input type="text" id="filter_date" placeholder="Date" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Customer</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_customer" placeholder="Customer Name" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Sale Rep</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_salerep" placeholder="Sale Rep" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Weight</span></div>
	<div class="col-sm-1 text-left"><input type="text" id="filter_weight" placeholder="Weight" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Block Charges</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_blockCharge" placeholder="Block Charges" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Other Charges</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_otherCharge" placeholder="Other Charges" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Total</span></div>
	<div class="col-sm-1 text-left"><input type="text" id="filter_total" placeholder="Total" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Advance</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_advance" placeholder="Advance" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Balance</span></div>
	<div class="col-sm-1 text-left"><input type="text"  id="filter_balance" placeholder="Balance" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Payment(s)</span></div>
	<div class="col-sm-1 text-left"><input type="text" id="filter_payment" placeholder="Payment(s)" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Todays Invoice</span></div>
	<div class="col-sm-1 text-left"><input type="checkbox" id="f_todaysInvoice" value="1" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Over Time</span></div>
	<div class="col-sm-1 text-left"><input type="checkbox" id="f_overTime" value="1" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-2 text-right"><span style="font-size:20px;">Bill To Bill</span></div>
	<div class="col-sm-1 text-left"><input type="checkbox" id="f_b2b" value="1" onchange="updateInvoiceList(orderByWas,0)"></div>
	<div class="col-sm-1"></div>
</div><br>
</div>
<div class="row row_inv" style="background-color:rgba(0,0,0,.7);color:white;">
	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-1 border3 head_">Edit</div>
			<div class="col-sm-1 border3 head_">Sr.</div>
			<div class="col-sm-2 border3 head_" onclick="updateInvoiceList('date',0)">Date</div>
			<div class="col-sm-1 border3 head_" onclick="updateInvoiceList('no',0)">Inv. #</div>
			<div class="col-sm-1 border3 head_" onclick="updateInvoiceList('id',0)">Ref. #</div>
			<div class="col-sm-2 border3 head_" onclick="updateInvoiceList('cName',0)">Party Name</div>
			<div class="col-sm-2 border3 head_" onclick="updateInvoiceList('eName',0)">Sales Rep.</div>
			<div class="col-sm-2 border3 head_">Weight / Pieces</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-sm-2 border3 head_">Block Charges</div>
			<div class="col-sm-2 border3 head_">0. Charge</div>
			<div class="col-sm-2 border3 head_">Total</div>
			<div class="col-sm-2 border3 head_">Advance</div>
			<div class="col-sm-2 border3 head_">Payment(s)</div>
			<div class="col-sm-2 border3 head_">Balance</div>

		</div>
	</div>
</div>
<div id="invoice_table">

</div>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
    var dueWas = 0;
function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$(".filter-box2").slideUp();
	updateInvoiceList('id',0);
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

function PrintList(id)
{
	alert("Error: Too much fields, cant't be on A4 page size.")
	/*
	var inv = $("#filter_inv").val();
	var ref = $("#filter_ref").val();
	var date = $("#filter_date").val();
	var customer = $("#filter_customer").val();
	var salerep = $("#filter_salerep").val();
	var weight = $("#filter_weight").val();
	var blockCharge = $("#filter_blockCharge").val();
	var otherCharge = $("#filter_otherCharge").val();
	var total = $("#filter_total").val();
	var advance = $("#filter_advance").val();
	var balance = $("#filter_balance").val();
	var payment = $("#filter_payment").val();
	var filter_qry = "";

	if(inv.length > 0) filter_qry += "&f_inv="+inv;
	if(ref.length > 0) filter_qry += "&f_ref="+ref;
	if(date.length > 0) filter_qry += "&f_date="+date;
	if(customer.length > 0) filter_qry += "&f_customer="+customer;
	if(salerep.length > 0) filter_qry += "&f_salerep="+salerep;
	if(weight.length > 0) filter_qry += "&f_weight="+weight;
	if(blockCharge.length > 0) filter_qry += "&f_blockCharge="+blockCharge;
	if(otherCharge.length > 0) filter_qry += "&f_otherCharge="+otherCharge;
	if(total.length > 0) filter_qry += "&f_total="+total;
	if(advance.length > 0) filter_qry += "&f_advance="+advance;
	if(balance.length > 0) filter_qry += "&f_balance="+balance;
	if(payment.length > 0) filter_qry += "&f_payment="+payment;

	if($("#f_overTime").is(':checked')) filter_qry += "&f_overTime="+inv;
	if($("#f_todaysInvoice").is(':checked')) filter_qry += "&f_todaysInvoice="+inv;
	if($("#f_b2b").is(':checked')) filter_qry += "&f_b2b="+inv;
	window.open("customers/invoices_print.php?orderBy=id"+filter_qry);*/
}


function exportExcel(id,due = null,all = null)
{
	var inv = $("#filter_inv").val();
	var ref = $("#filter_ref").val();
	var date = $("#filter_date").val();
	var customer = $("#filter_customer").val();
	var salerep = $("#filter_salerep").val();
	var weight = $("#filter_weight").val();
	var blockCharge = $("#filter_blockCharge").val();
	var otherCharge = $("#filter_otherCharge").val();
	var total = $("#filter_total").val();
	var advance = $("#filter_advance").val();
	var balance = $("#filter_balance").val();
	var payment = $("#filter_payment").val();
	var filter_qry = "";

	if(inv.length > 0) filter_qry += "&f_inv="+inv;
	if(ref.length > 0) filter_qry += "&f_ref="+ref;
	if(date.length > 0) filter_qry += "&f_date="+date;
	if(customer.length > 0) filter_qry += "&f_customer="+customer;
	if(salerep.length > 0) filter_qry += "&f_salerep="+salerep;
	if(weight.length > 0) filter_qry += "&f_weight="+weight;
	if(blockCharge.length > 0) filter_qry += "&f_blockCharge="+blockCharge;
	if(otherCharge.length > 0) filter_qry += "&f_otherCharge="+otherCharge;
	if(total.length > 0) filter_qry += "&f_total="+total;
	if(advance.length > 0) filter_qry += "&f_advance="+advance;
	if(balance.length > 0) filter_qry += "&f_balance="+balance;
	if(payment.length > 0) filter_qry += "&f_payment="+payment;
    if(due > 0) {filter_qry += "&f_due="+due; dueWas = due; }
	if($("#f_overTime").is(':checked')) filter_qry += "&f_overTime="+inv;
	if($("#f_todaysInvoice").is(':checked')) filter_qry += "&f_todaysInvoice="+inv;
	if($("#f_b2b").is(':checked')) filter_qry += "&f_b2b="+inv;


    var month = $("#monthOpt").val();
    var year = $("#yearOpt").val();


    if(all == null) window.open("customers/export_invoiceList.php?orderBy=id"+filter_qry+"&year="+year+"&month="+month);
    else window.open("customers/export_invoiceList.php?orderBy=id"+filter_qry+"&year=0&month=0");
}

function viewInvoice(id)
{
	pageLoad("customers/invoice_update.php?no="+id);
}

function printInvoice(id)
{	
	pageLoad("customers/invoice_print.php?no="+id);
}

function updateInvoiceList(orderBy = null,due = null,all = null)
{

	var inv = $("#filter_inv").val();
	var ref = $("#filter_ref").val();
	var date = $("#filter_date").val();
	var customer = $("#filter_customer").val();
	var salerep = $("#filter_salerep").val();
	var weight = $("#filter_weight").val();
	var blockCharge = $("#filter_blockCharge").val();
	var otherCharge = $("#filter_otherCharge").val();
	var total = $("#filter_total").val();
	var advance = $("#filter_advance").val();
	var balance = $("#filter_balance").val();
	var payment = $("#filter_payment").val();
	var filter_qry = "";

	if(inv.length > 0) filter_qry += "&f_inv="+inv;
	if(ref.length > 0) filter_qry += "&f_ref="+ref;
	if(date.length > 0) filter_qry += "&f_date="+date;
	if(customer.length > 0) filter_qry += "&f_customer="+customer;
	if(salerep.length > 0) filter_qry += "&f_salerep="+salerep;
	if(weight.length > 0) filter_qry += "&f_weight="+weight;
	if(blockCharge.length > 0) filter_qry += "&f_blockCharge="+blockCharge;
	if(otherCharge.length > 0) filter_qry += "&f_otherCharge="+otherCharge;
	if(total.length > 0) filter_qry += "&f_total="+total;
	if(advance.length > 0) filter_qry += "&f_advance="+advance;
	if(balance.length > 0) filter_qry += "&f_balance="+balance;
	if(payment.length > 0) filter_qry += "&f_payment="+payment;
	if(due > 0) {filter_qry += "&f_due="+due; dueWas = due; }
	if($("#f_overTime").is(':checked')) filter_qry += "&f_overTime="+inv;
	if($("#f_todaysInvoice").is(':checked')) filter_qry += "&f_todaysInvoice="+inv;
	if($("#f_b2b").is(':checked')) filter_qry += "&f_b2b="+inv;


    var month = $("#monthOpt").val();
    var year = $("#yearOpt").val();

	$("#invoice_table").html("Loading...");
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        if(xhttp.responseText != "0") {
        $("#invoice_table").html(xhttp.responseText); }
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updateInvoiceTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if(all == null)  xhttp.send("orderBy="+orderBy+filter_qry+"&year="+year+"&month="+month+"&ajax");
    else  xhttp.send("orderBy="+orderBy+filter_qry+"&year=0&month=0&ajax");
}


</script>
