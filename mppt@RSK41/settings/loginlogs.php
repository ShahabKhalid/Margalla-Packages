<br><br>
<div class="container addBox" style="width:95%">
<div class="inBox">
<h1>Login Logs</h1>
<div class="row" id="r2">
<div class="col-md-11"></div>
<div class="col-md-1"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box" style="height:80px;">
<br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">IP</span></div>
	<div class="col-sm-3"><input type="text" id="filter_ip" placeholder="Ip Address" onchange="updateLoginLogList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Date</span></div>
	<div class="col-sm-3"><input type="text" id="filter_date" placeholder="Date" onchange="updateLoginLogList(orderByWas)"></div>
	<div class="col-sm-2"></div>
</div>
</div>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;">
<div class="col-md-1"><b>Serial</b></div>
<div class="col-md-1" onclick="updateLoginLogList('ip')"><b>IP</b></div>
<div class="col-md-1" onclick="updateLoginLogList('date')"><b>Date</b></div>
<div class="col-md-2" onclick="updateLoginLogList('time')"><b>Time</b></div>
<div class="col-md-2" onclick="updateLoginLogList('userName')"><b>UserName</b></div>
<div class="col-md-2" onclick="updateLoginLogList('pass')"><b>Password</b></div>
<div class="col-md-2" onclick="updateLoginLogList('pin')"><b>Pin</b></div>
<div class="col-md-1" onclick="updateLoginLogList('fail')"><b>Fail</b></div>
</div>
<div id="loginlog_table">
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

function updateLoginLogList(orderBy)
{
	//alert(orderBy);
	var ip = $("#filter_ip").val();
	var date = $("#filter_date").val();

	var filter_qry = "";

	if(ip.length > 0) filter_qry += "&f_ip="+ip;
	if(date.length > 0) filter_qry += "&f_date="+date;

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        $("#loginlog_table").html(xhttp.responseText);
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updateLoginLogTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orderBy="+orderBy+filter_qry+"&ajax");
}

function onPageLoad()
{
	$(".filter-box").slideUp();
	updateLoginLogList('id');
}

</script>
