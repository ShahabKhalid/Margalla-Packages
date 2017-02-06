<div class="container-fluid addBox" style="width:95%;">
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
<br>
<h1>Payments</h1>
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
  <button onclick="updatePaymentList()">Go</button>
	<button onclick="updatePaymentList(null,1)">All</button>
</div>
</div>
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
    <div class="col-sm-1 text-left"><input type="text"  id="filter_inv" placeholder="Inv #" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Ref #</span></div>
    <div class="col-sm-1 text-left"><input type="text"  id="filter_ref" placeholder="Ref #" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Entry Date</span></div>
    <div class="col-sm-1 text-left"><input type="text" id="filter_edate" placeholder="entry Date" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-1"></div>
</div><br>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Customer</span></div>
    <div class="col-sm-1 text-left"><input type="text"  id="filter_customer" placeholder="Customer Name" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Receiver</span></div>
    <div class="col-sm-1 text-left"><input type="text"  id="filter_receiver" placeholder="Sale Rep" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Receive Date</span></div>
    <div class="col-sm-1 text-left"><input type="text" id="filter_rdate" placeholder="receiving Date" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-1"></div>
</div><br>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Amount</span></div>
    <div class="col-sm-1 text-left"><input type="text" id="filter_amount" placeholder="Total" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Is Payment</span></div>
    <div class="col-sm-1 text-left"><input type="checkbox" id="filter_paymentOnly" value="1" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Is Advance</span></div>
    <div class="col-sm-1 text-left"><input type="checkbox" id="filter_advanceOnly" value="1" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-1"></div>
</div><br>
</div>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;width:95%;position:relative;margin:0 auto;">
    <div class="col-sm-1 head_">Sr.</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('id')">Pay #</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('ref_no')">Ref #</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('inv_no')">Inv #</div>
    <div class="col-sm-2 head_" onclick="updatePaymentList('cname')">Customer</div>
    <div class="col-sm-2 head_" onclick="updatePaymentList('ename')">Receiver</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('rec_date')">Rec. Date</div>
    <div class="col-sm-1 head_" onclick="updatePaymentList('entry_date')">Entry Date</div>
    <div class="col-sm-2 head_" onclick="updatePaymentList('amount')"> Amount</div>
</div>
<div id="payment_table">

</div>
<br><br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
var orderByWas;
function onPageLoad()
{
    updatePaymentList('id');
    orderByWas = 'id';
    $(".filter-box2").slideUp();
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

function PrintList()
{
    var inv = $("#filter_inv").val();
    var ref = $("#filter_ref").val();
    var edate = $("#filter_edate").val();
    var customer = $("#filter_customer").val();
    var receiver = $("#filter_receiver").val();
    var rdate = $("#filter_rdate").val();
    var amount = $("#filter_amount").val();
    var paymentOnly = $("#filter_paymentOnly").val();
    var advanceOnly = $("#filter_advanceOnly").val();
    var filter_qry = "";

    if(inv.length > 0) filter_qry += "&f_inv="+inv;
    if(ref.length > 0) filter_qry += "&f_ref="+ref;
    if(edate.length > 0) filter_qry += "&f_edate="+edate;
    if(customer.length > 0) filter_qry += "&f_customer="+customer;
    if(receiver.length > 0) filter_qry += "&f_receiver="+receiver;
    if(rdate.length > 0) filter_qry += "&f_rdate="+rdate;
    if(amount.length > 0) filter_qry += "&f_amount="+amount;
    if($("#filter_paymentOnly").is(':checked')) filter_qry += "&f_paymentOnly="+paymentOnly;
    if($("#filter_advanceOnly").is(':checked')) filter_qry += "&f_advanceOnly="+advanceOnly;
    window.open("customers/payments_list_print.php?orderBy=id"+filter_qry);
}

function exportExcel()
{
    var inv = $("#filter_inv").val();
    var ref = $("#filter_ref").val();
    var edate = $("#filter_edate").val();
    var customer = $("#filter_customer").val();
    var receiver = $("#filter_receiver").val();
    var rdate = $("#filter_rdate").val();
    var amount = $("#filter_amount").val();
    var paymentOnly = $("#filter_paymentOnly").val();
    var advanceOnly = $("#filter_advanceOnly").val();
    var filter_qry = "";

    if(inv.length > 0) filter_qry += "&f_inv="+inv;
    if(ref.length > 0) filter_qry += "&f_ref="+ref;
    if(edate.length > 0) filter_qry += "&f_edate="+edate;
    if(customer.length > 0) filter_qry += "&f_customer="+customer;
    if(receiver.length > 0) filter_qry += "&f_receiver="+receiver;
    if(rdate.length > 0) filter_qry += "&f_rdate="+rdate;
    if(amount.length > 0) filter_qry += "&f_amount="+amount;
    if($("#filter_paymentOnly").is(':checked')) filter_qry += "&f_paymentOnly="+paymentOnly;
    if($("#filter_advanceOnly").is(':checked')) filter_qry += "&f_advanceOnly="+advanceOnly;
    window.open("customers/payments_list_export.php?orderBy=id"+filter_qry);
}

function viewPayment(id)
{
    pageLoad("customers/payment_update.php?id="+id);
}


function updatePaymentList(orderBy = null,all = null)
{
    if(orderBy == null) {
      orderBy = orderByWas;
    }
    var month = $("#monthOpt").val();
    var year = $("#yearOpt").val();
    var inv = $("#filter_inv").val();
    var ref = $("#filter_ref").val();
    var edate = $("#filter_edate").val();
    var customer = $("#filter_customer").val();
    var receiver = $("#filter_receiver").val();
    var rdate = $("#filter_rdate").val();
    var amount = $("#filter_amount").val();
    var paymentOnly = $("#filter_paymentOnly").val();
    var advanceOnly = $("#filter_advanceOnly").val();
    var filter_qry = "";

    if(inv.length > 0) filter_qry += "&f_inv="+inv;
    if(ref.length > 0) filter_qry += "&f_ref="+ref;
    if(edate.length > 0) filter_qry += "&f_edate="+edate;
    if(customer.length > 0) filter_qry += "&f_customer="+customer;
    if(receiver.length > 0) filter_qry += "&f_receiver="+receiver;
    if(rdate.length > 0) filter_qry += "&f_rdate="+rdate;
    if(amount.length > 0) filter_qry += "&f_amount="+amount;
    if($("#filter_paymentOnly").is(':checked')) filter_qry += "&f_paymentOnly="+paymentOnly;
    if($("#filter_advanceOnly").is(':checked')) filter_qry += "&f_advanceOnly="+advanceOnly;


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        if(xhttp.responseText != "0") {
        $("#payment_table").html(xhttp.responseText); }
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updatePaymentTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if(all == null) xhttp.send("orderBy="+orderBy+filter_qry+"&year="+year+"&month="+month+"&ajax");
    else xhttp.send("orderBy="+orderBy+filter_qry+"&year=0&month=0&ajax");
}
</script>
