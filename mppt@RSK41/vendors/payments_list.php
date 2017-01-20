<div class="container-fluid addBox" style="width:95%;">
<div class="inBox"> 
<h1>Paid Payments</h1>
<div class="row" id="r2">
<div class="col-md-11"></div>
<div class="col-md-1 text-right"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box2">
<br>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Bill #</span></div>
    <div class="col-sm-1 text-left"><input type="text"  id="filter_bill" placeholder="Inv #" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Ref #</span></div>
    <div class="col-sm-1 text-left"><input type="text"  id="filter_ref" placeholder="Ref #" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Entry Date</span></div>
    <div class="col-sm-1 text-left"><input type="text" id="filter_edate" placeholder="entry Date" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-1"></div>
</div><br>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Vendor</span></div>
    <div class="col-sm-1 text-left"><input type="text"  id="filter_vendor" placeholder="Vendor Name" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Paid By</span></div>
    <div class="col-sm-1 text-left"><input type="text"  id="filter_payer" placeholder="Payer Name" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Paid Date</span></div>
    <div class="col-sm-1 text-left"><input type="text" id="filter_pdate" placeholder="paying Date" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-1"></div>
</div><br>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2 text-right"><span style="font-size:20px;">Amount</span></div>
    <div class="col-sm-1 text-left"><input type="text" id="filter_amount" placeholder="Total" onchange="updatePaymentList(orderByWas)"></div>
    <div class="col-sm-1"></div>
</div><br>
</div>  
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

function viewPayment(id)
{   
    pageLoad("vendors/payment_update.php?id="+id);  
}


function updatePaymentList(orderBy)
{
    var bill = $("#filter_bill").val();
    var ref = $("#filter_ref").val();
    var edate = $("#filter_edate").val();
    var vendor = $("#filter_vendor").val();
    var payer = $("#filter_payer").val();
    var pdate = $("#filter_pdate").val();
    var amount = $("#filter_amount").val();
    var filter_qry = "";

    if(bill.length > 0) filter_qry += "&f_bill="+bill;
    if(ref.length > 0) filter_qry += "&f_ref="+ref;
    if(edate.length > 0) filter_qry += "&f_edate="+edate;
    if(vendor.length > 0) filter_qry += "&f_vendor="+vendor;
    if(payer.length > 0) filter_qry += "&f_payer="+payer;
    if(pdate.length > 0) filter_qry += "&f_pdate="+pdate;
    if(amount.length > 0) filter_qry += "&f_amount="+amount;


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        //alert(xhttp.responseText);
        if(xhttp.responseText != "0") {
        $("#payment_table").html(xhttp.responseText); }
        orderByWas = orderBy;
    }};  

    xhttp.open("POST", "do.php?action=updatePaidPaymentTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orderBy="+orderBy+filter_qry+"&ajax");  
}
</script>