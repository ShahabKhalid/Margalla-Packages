<br><br><br>
<div class="conatiner-fluid" >
	<div class="row center">
		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(70,23,180,.8);">
			<div class="row" onclick="pageLoad('expences/ledger.php')">
				<?php
					require "123321.php";
					$qry = "SELECT * FROM `expAccounts` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$expAccountsCount = mysqli_num_rows($run);
					$qry = "SELECT * FROM `expences` WHERE `acc_id` != '-1'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$expCount = mysqli_num_rows($run);

					$qry = "SELECT SUM(amount) as exp FROM `expences` WHERE `date` > '".date('Y-m-')."-01' and `date` < '".date('Y-m',strtotime('+1 month'))."-01'";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$row = mysqli_fetch_array($run);
				?>
				<div class="col-md-6" id="view"><h1>Details</h1>
				</div>
				<div class="col-md-6"><span class="glyphicon glyphicon-user"></span></div>
			</div>
			<h2 style="background-color:rgba(70,23,180,255);">Accounts</h2>
			<ul style="background-color:rgba(70,23,180,255);">
			<li><a href="javascript:void()" onclick="return pageLoad('expences/addacount.php')" title="Add Account">Add Account</a></li>
			<li><a href="#" onclick="return pageLoad('expences/accounts.php')" title="Edit Account">View & Edi Accounts</a></li>
			</ul></div>
		</div>
		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(170,64,255,.8);">
			<div class="row" onclick="return pageLoad('expences/list.php')">
				<div class="col-md-6" id="view"><h1><?php echo $expCount; ?></h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-send"></span></div>
			</div>
			<h2 style="background-color:rgba(170,64,255,255);">Expences</h2>
			<ul style="background-color:rgba(170,64,255,255);">
			<li><a href="javascript:void()" onclick="return pageLoad('expences/add.php')" id="addInv" title="Add Invoice">Add Expence</a></li>
			<li><a href="#" title="Edit Invoice" onclick="return pageLoad('expences/list.php')">View & Edit Expence</a></li>
			</ul></div>
		</div>

		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(31,174,255,.8);">
			<div class="row" onclick="return pageLoad('expences/listpc.php')">
                <div class="col-md-12" id="view"><h1>Petty Cash</h1></div>
			</div>
			<h2 style="background-color:rgba(31,174,255,255);">Petty Cash</h2>
			<ul style="background-color:rgba(31,174,255,255);">
			<li><a href="#" onclick="return pageLoad('expences/addpc.php')" title="Add Petty Cash" onclick="return 1;">Add Petty Cash</a></li>
			<li><a href="#" onclick="return pageLoad('expences/listpc.php')" title="List & Edit Petty Cash" onclick="return 1">List & Edit Petty Cash</a></li>
			</ul></div>
		</div>
	</div>
</div>
<br><br><br>
<br><br><br>
<div id="contentRoom">

</div>
<script>
var mainPage = true;
var currentPage = null;
var lastPage = null;
function pageLoad(page)
{	
	lastPage = currentPage;
	if(page == "expMain.php")
		mainPage = true;
	else
		mainPage = false;
    $("#contentRoom").slideUp();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {
            $("#contentRoom").html('<h1 style="text-align:center;margin-top:20%;">Loading....</h1>');
    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        setTimeout(function(){
            $("#contentRoom").html(xhttp.responseText);
            $("#contentRoom").slideDown();
            //$("#update-account").slideUp();
            onPageLoad();
         }, 500);
        currentPage = page;


    }
    };
    xhttp.open("POST", ""+page+"", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

$(document).ready(function(){
	mainPage = true;
	pageLoad("expMain.php");


	$(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                pageLoad(lastPage);
            }
        });

});
</script>
