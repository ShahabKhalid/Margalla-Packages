<div class="container addBox" style="width:90%;">
<div class="inBox"> 
<h1>Bills</h1>
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


function updateBillList(orderBy)
{
	
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
    xhttp.send("orderBy="+orderBy+filter_qry+"&ajax");	
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