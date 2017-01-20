<div class="container addBox">
<div class="inBox">
<?php
require "../123321.php";
if(isset($_GET['id']))
{
$id = $_GET['id'];
$qry = "SELECT * FROM `expAccounts` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$p = $data['id'];
?>
<h1>Expence Accounts List [<?php echo $data['name']; ?>]</h1>
<?php
}
else
{
$p = -99;
?>
<h1>Expence Accounts List</h1>
<?php
}
?>
<div class="row" id="r2">
<div class="col-md-11"></div>
<div class="col-md-1"><b><a href="javascript:void()" onclick="toggleFilter()">Filter</a></b></div>
</div>
<div class="filter-box" style="height:80px;">
<br>
<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"><span style="font-size:20px;">ID</span></div>
	<div class="col-sm-3"><input type="text" name="id" id="filter_id" placeholder="ID" onchange="updateAccountList(orderByWas)"></div>
	<div class="col-sm-1"><span style="font-size:20px;">Name</span></div>
	<div class="col-sm-3"><input type="text" name="name" id="filter_name" placeholder="Name" onchange="updateAccountList(orderByWas)"></div>
	<div class="col-sm-2"></div>
	<input type="hidden" name="name" id="parentID" placeholder="Name" value="<?php echo $p; ?>">
</div>
</div>
<div class="row" id="r2" style="background-color:rgba(0,0,0,0.7);color:white;">
<div class="col-md-2"><b>Serial</b></div>
<div class="col-md-1" onclick="updateAccountList('id')"><b>ID</b></div>
<div class="col-md-2" onclick="updateAccountList('name')"><b>Name</b></div>
<div class="col-md-2" ><b>Sub Accounts</b></div>
<div class="col-md-2" onclick="updateAccountList('exp')"><b>Total Expence</b></div>
<div class="col-md-2"><b>Sub Accounts</b></div>
<div class="col-md-1"><b>Edit</b></div>
</div>
<div id="account_table">
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

function updateAccountList(orderBy)
{
	var id = $("#filter_id").val();
	var name = $("#filter_name").val();
	var pid = $("#parentID").val();

	var filter_qry = "";

	if(id.length > 0) filter_qry += "&f_id="+id;
	if(name.length > 0) filter_qry += "&f_name="+name;
	if(pid != '-99') filter_qry += "&pid="+pid;

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        $("#account_table").html(xhttp.responseText);
        orderByWas = orderBy;
    }};

    xhttp.open("POST", "do.php?action=updateAccountTable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("orderBy="+orderBy+filter_qry+"&ajax");
}


function onPageLoad()
{
	$(".filter-box").slideUp();
	updateAccountList('id');
}




</script>
