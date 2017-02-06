<div class="container addBox">
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
<h1>Expences List</h1>
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
	<button onclick="updateExpenceList(null,null)">Go</button>
	<button onclick="updateExpenceList(null,1)">All</button>
</div>
</div>
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

function updateExpenceList(orderBy = null,all = null)
{
	if(orderBy == null) orderBy = orderByWas;
	var id = $("#filter_id").val();
	var name = $("#filter_name").val();
	var desc = $("#filter_desc").val();
	var amount = $("#filter_amount").val();
	var year = $("#yearOpt").val();
	var month = $("#monthOpt").val();

	var filter_qry = "";

	if(id.length > 0) filter_qry += "&f_id="+id;
	if(name.length > 0) filter_qry += "&f_name="+name;
	if(desc.length > 0) filter_qry += "&f_description="+desc;
	if(amount.length > 0) filter_qry += "&f_amount="+amount;
	if(all != null) filter_qry += "&year=0&month=0";
	else filter_qry += "&year="+year+"&month="+month;

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
