<br><br><br>
<div class="conatiner-fluid">
	<div class="row">
		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(255,46,23,.8);">
			<div class="row" onclick="pageLoad('vendors/list.php')">
				<?php
					require "123321.php";
					$qry = "SELECT * FROM `vendor` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$customerCount = mysqli_num_rows($run);
					$qry = "SELECT * FROM `bill` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$invCount = mysqli_num_rows($run);

					$qry = "SELECT * FROM `payments_paid` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$paymentCount = mysqli_num_rows($run);
				?>			
				<div class="col-md-6" id="view"><h1><?php echo $customerCount; ?></h1>
				</div>
				<div class="col-md-6"><span class="glyphicon glyphicon-user"></span></div>
			</div>
			<h2 style="background-color:rgba(255,46,23,255);">Vendors</h2>
			<ul style="background-color:rgba(255,46,23,255);">
			<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/add.php') !== false) { ?>			
			<li><a href="javascript:void()" id="addCust" title="Add Customer">Add Vendor</a></li>
			<?php } if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/list.php') !== false) { ?>			

			<li><a href="#" onclick="return pageLoad('vendors/list.php')" title="Edit Customer">List & Edit Vendor</a></li>
			<?php } ?>
			</ul></div>
		</div>
		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(46,23,0,.8);">
			<div class="row" onclick="return pageLoad('vendors/bills.php')">
				<div class="col-md-6" id="view"><h1><?php echo $invCount; ?></h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-send"></span></div>
			</div>
			<h2 style="background-color:rgba(46,23,0,255);">Bills</h2>
			<ul style="background-color:rgba(46,23,0,255);">
			<?php if(strcmp($_SESSION['access'],"all") === 0 || trpos($_SESSION['access'],'vendors/bill_add.php') !== false) { ?>			

			<li><a href="javascript:void()"onclick="return pageLoad('vendors/bill_add.php')" id="addInv" title="Add Invoice">Add Bill</a></li>
			<?php } if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/bills.php') !== false) { ?>			

			<li><a href="#" title="Edit Invoice" onclick="return pageLoad('vendors/bills.php')">View & Edit Bill</a></li>
			<?php } ?>
			</ul></div>
		</div>

		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(0,174,0,.8);">
			<div class="row" onclick="return pageLoad('vendors/payments_list.php')">
				<div class="col-md-6" id="view"><h1><?php echo $paymentCount; ?></h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-usd"></span></div>
			</div>
			<h2 style="background-color:rgba(0,174,0,255);">Paid Payments</h2>
			<ul style="background-color:rgba(0,174,0,255);">
			<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/pay_payment.php') !== false) { ?>			

			<li><a href="#" title="Add Customer" onclick="return pageLoad('vendors/pay_payment.php');">Add Paid Payment</a></li>
			<?php } if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'vendors/payments_list.php') !== false) { ?>			

			<li><a href="#" title="Edit Customer" onclick="return pageLoad('vendors/payments_list.php')">View & Edit Paid Payment</a></li>
			<?php } ?>
			</ul></div>
		</div>
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
	if(page == "vendMain.php") 
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
	pageLoad("vendMain.php");


	$(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                pageLoad(lastPage);
            }
        });

    $("#addCust").click(function() {
        pageLoad("vendors/add.php");        
    });
});
</script>
