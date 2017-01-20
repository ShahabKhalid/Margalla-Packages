<div class="container addBox">
<div class="inBox">
<h1>Expences List</h1>
<div class="row" id="r2">
<div class="col-md-11"></div>
<div class="col-md-1"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box">
<br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">ID</span></div>
	<div class="col-sm-3"><input type="text" name="id" id="filter_id" placeholder="ID" onchange="updateExpenceList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Account</span></div>
	<div class="col-sm-3"><input type="text" name="name" id="filter_name" placeholder="Account Name" onchange="updateExpenceList(orderByWas)"></div>
	<div class="col-sm-2"></div>
</div><br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Description</span></div>
	<div class="col-sm-3"><input type="text" name="contact" id="filter_desc" placeholder="Description" onchange="updateExpenceList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Amount</span></div>
	<div class="col-sm-3"><input type="text" name="addr" id="filter_amount" placeholder="Amount" onchange="updateExpenceList(orderByWas)"></div>
	<div class="col-sm-2"></div>
</div>
</div>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;">
<div class="col-md-1"><b>Serial</b></div>
<div class="col-md-1" onclick="updateExpenceList('id')"><b>ID</b></div>
<div class="col-md-3" onclick="updateExpenceList('name')"><b>Account</b></div>
<div class="col-md-2" onclick="updateExpenceList('description')"><b>Amount</b></div>
<div class="col-md-4" onclick="updateExpenceList('amount')"><b>Description</b></div>
<div class="col-md-1"><b>Edit</b></div>
</div>
<div id="expences_table">
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

function updateExpenceList(orderBy)
{
	var id = $("#filter_id").val();
	var name = $("#filter_name").val();
	var desc = $("#filter_desc").val();
	var amount = $("#filter_amount").val();

	var filter_qry = "";

	if(id.length > 0) filter_qry += "&f_id="+id;
	if(name.length > 0) filter_qry += "&f_name="+name;
	if(desc.length > 0) filter_qry += "&f_description="+desc;
	if(amount.length > 0) filter_qry += "&f_amount="+amount;

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        $("#expences_table").html(xhttp.responseText);
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updateExpencesTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orderBy="+orderBy+filter_qry+"&ajax");
}


function onPageLoad()
{
	$(".filter-box").slideUp();
	updateExpenceList('id');
}




</script>
