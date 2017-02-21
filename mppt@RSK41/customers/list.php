<?php
require "../123321.php";
?>
<div class="container addBox" style="width:98%;">
<div class="inBox">
<h1>Customers List</h1>
<div class="row" id="r2">
<div class="col-md-8"></div>
<div class="col-md-2"><b><a href="javascript:void()" onclick="exportList()">Export to excel</a></b></div>
<div class="col-md-1"><b><a href="javascript:void()" onclick="printList()">Print</a></b></div>
<div class="col-md-1"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box">
<br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">ID</span></div>
	<div class="col-sm-3"><input type="text" name="id" id="filter_id" placeholder="ID" onchange="updateCustomerList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Name</span></div>
	<div class="col-sm-3"><input type="text" name="name" id="filter_name" placeholder="Name" onchange="updateCustomerList(orderByWas)"></div>
	<div class="col-sm-2"></div>
</div><br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Contact</span></div>
	<div class="col-sm-3"><input type="text" name="contact" id="filter_contact" placeholder="Contact" onchange="updateCustomerList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Address</span></div>
	<div class="col-sm-3"><input type="text" name="addr" id="filter_addr" placeholder="Address" onchange="updateCustomerList(orderByWas)"></div>
	<div class="col-sm-2"></div>
</div>
</div>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;">
<div class="col-md-1"><b>Serial</b></div>
<div class="col-md-1" onclick="updateCustomerList('id')"><b>ID</b></div>
<div class="col-md-2" onclick="updateCustomerList('name')"><b>Name</b></div>
<div class="col-md-2" onclick="updateCustomerList('contact')"><b>Sale Rep.</b></div>
<div class="col-md-2" ><b>Last Invoice (Date)</b></div>
<div class="col-md-2" ><b>Last Payment (Date)</b></div>
<div class="col-md-1"><b>Balance</b></div>
<div class="col-md-1"><b>Edit</b></div>
</div>
<div id="customer_table">
</div>
<br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script type="text/javascript">
var orderByWas;
$(document).ready(function(){
    $("").click(function() {

    });

});



function toggleFilter()
{
	if ($('.filter-box').is(':visible'))
	{
		$(".filter-box").slideUp();
	}
	else
	{
		$(".filter-box").slideDown();
	}
}

function updateCustomerList(orderBy)
{
	var id = $("#filter_id").val();
	var name = $("#filter_name").val();
	var contact = $("#filter_contact").val();
	var addr = $("#filter_addr").val();

	var filter_qry = "";

	if(id.length > 0) filter_qry += "&f_id="+id;
	if(name.length > 0) filter_qry += "&f_name="+name;
	if(contact.length > 0) filter_qry += "&f_contact="+contact;
	if(addr.length > 0) filter_qry += "&f_addr="+addr;

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
	if (xhttp.readyState != 4)
	{
		$("#customer_table").html("<h1 style='text-decoration:none;'>Loading......</h1>");
	}
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        $("#customer_table").html(xhttp.responseText);
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updateCustomerTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orderBy="+orderBy+filter_qry+"&ajax");
}

function exportList()
{
	window.open("customers/export_custList.php");
}


function printList()
{
	window.open("customers/print_custList.php");
}


function onPageLoad()
{
	$(".filter-box").slideUp();
	updateCustomerList('id');
}




</script>
