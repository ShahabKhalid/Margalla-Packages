<br><br>
<div class="container addBox" style="width:95%">
<div class="inBox">
<h1>Action Logs</h1>
<div class="row" id="r2">
<div class="col-md-11"></div>
<div class="col-md-1"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box">
<br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Time</span></div>
	<div class="col-sm-3"><input type="text" id="filter_time" placeholder="Time" onchange="updateLogList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Date</span></div>
	<div class="col-sm-3"><input type="text" id="filter_date" placeholder="Date" onchange="updateLogList(orderByWas)"></div>
	<div class="col-sm-2"></div>
</div><br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Admin</span></div>
	<div class="col-sm-3"><input type="text" id="filter_admin" placeholder="Admin" onchange="updateLogList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Date</span></div>
	<div class="col-sm-3"><input type="text" id="filter_log" placeholder="Log" onchange="updateLogList(orderByWas)"></div>
	<div class="col-sm-2"></div>
</div>
</div>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;">
<div class="col-md-1"><b>Serial</b></div>
<div class="col-md-1" onclick="updateLogList('date')"><b>Date</b></div>
<div class="col-md-2" onclick="updateLogList('time')"><b>Time</b></div>
<div class="col-md-2"><b>Admin</b></div>
<div class="col-md-6"><b>Log</b></div>
</div>
<div id="log_table">
</div>
<br><br><br>
</div>
</div>
</div>
<script type="text/javascript">


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

function updateLogList(orderBy)
{
	//alert(orderBy);
	var time = $("#filter_time").val();
	var date = $("#filter_date").val();
	var log = $("#filter_log").val();
	var admin = $("#filter_admin").val();

	var filter_qry = "";

	if(time.length > 0) filter_qry += "&f_time="+time;
	if(date.length > 0) filter_qry += "&f_date="+date;
	if(log.length > 0) filter_qry += "&f_log="+log;
	if(admin.length > 0) filter_qry += "&f_admin="+admin;

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        $("#log_table").html(xhttp.responseText);
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updateLogTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orderBy="+orderBy+filter_qry+"&ajax");
}

function onPageLoad()
{
	$(".filter-box").slideUp();
	updateLogList('id');
}

</script>
