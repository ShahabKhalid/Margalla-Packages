<br><br><br>
<div class="conatiner-fluid">
	<div class="row">
		<div class="col-md-3 infoBox">
			<div class="box" style="background-color: rgba(70,23,180,.8);">
			<div class="row" onclick="pageLoad('customers/list.php')">
				<?php
					require "123321.php";
					$qry = "SELECT * FROM `customers` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$customerCount = mysqli_num_rows($run);
					$qry = "SELECT * FROM `invoice` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$invCount = mysqli_num_rows($run);

					$qry = "SELECT * FROM `payments_recv` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$paymentCount = mysqli_num_rows($run);
				?>			
				<div class="col-md-6" id="view"><h1><?php echo $customerCount; ?></h1>
				</div>
				<div class="col-md-6"><span class="glyphicon glyphicon-user"></span></div>
			</div>
			<h2 style="background-color:rgba(70,23,180,255);">Customers</h2>
			<ul style="background-color:rgba(70,23,180,255);">
			<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/add.php') !== false) { ?>
			<li><a href="javascript:void()" id="addCust" title="Add Customer">Add Customer</a></li>
			<?php } if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/list.php') !== false) { ?>			
			<li><a href="#" onclick="return pageLoad('customers/list.php')" title="Edit Customer">List Customer</a></li>
			<?php }?>
			</ul></div>
		</div>
		<div class="col-md-3 infoBox">
			<div class="box" style="background-color: rgba(170,64,255,.8);">
			<div class="row" onclick="return pageLoad('customers/invoices.php')">
				<div class="col-md-6" id="view"><h1><?php echo $invCount; ?></h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-send"></span></div>
			</div>
			<h2 style="background-color:rgba(170,64,255,255);">Invoices</h2>
			<ul style="background-color:rgba(170,64,255,255);">
			<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/invoice_add.php') !== false) { ?>
			<li><a href="javascript:void()"onclick="return pageLoad('customers/invoice_add.php')" id="addInv" title="Add Invoice">Add Invoice</a></li>
			<?php } if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/invoices.php') !== false) { ?>
			<li><a href="#" title="Edit Invoice" onclick="return pageLoad('customers/invoices.php')">View & Edit Invoice</a></li>
			<?php }?>
			</ul></div>
		</div>

		<div class="col-md-3 infoBox">
			<div class="box" style="background-color: rgba(31,174,255,.8);">
			<div class="row" onclick="return pageLoad('customers/payments_list.php')">
				<div class="col-md-6" id="view"><h1><?php echo $paymentCount; ?></h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-usd"></span></div>
			</div>
			<h2 style="background-color:rgba(31,174,255,255);">Recv. Payment</h2>
			<ul style="background-color:rgba(31,174,255,255);">
			<?php if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/recv_payment.php') !== false) { ?>
			<li><a href="#" title="Add Customer" onclick="return pageLoad('customers/recv_payment.php');">Add Payment</a></li>
			<?php } if(strcmp($_SESSION['access'],"all") === 0 || strpos($_SESSION['access'],'customers/payments_list.php') !== false) { ?>
			<li><a href="#" title="Edit Customer" onclick="return pageLoad('customers/payments_list.php')">View & Edit Payment</a></li>
			<?php }?>
			</ul></div>
		</div>
		<div class="col-md-3 infoBox">
			<div class="box" style="background-color: rgba(25,153,0,.8);">
			<div class="row">
			<?php 
			$qry = "SELECT * FROM `invoice` order by `no` desc limit 1";
			$run = mysqli_query($con,$qry) or die(mysqli_error($con));
			$row = mysqli_fetch_array($run);
			$inv_no = $row['no'];
			$qry = "SELECT * FROM `customers` WHERE `id` = '".$row['customer']."'";
			$run = mysqli_query($con,$qry) or die(mysqli_error($con));
			$row = mysqli_fetch_array($run);
			$custName = $row['name'];
			
			?>
				<div class="col-md-6" id="view" onclick="viewInvoice('<?php echo $inv_no ?>')"><h1><?php echo $custName; ?></h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-shopping-cart"></span></div>
			</div>
			<h2 style="background-color:rgba(25,153,0,255);" onclick="viewInvoice('<?php echo $inv_no ?>')">Last Invoice</h2>
			<ul style="background-color:rgba(25,153,0,255);">
			<li>.</li>
			<li>.</li>
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
	if(page == "custMain.php") 
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

function viewInvoice(no)
{
	pageLoad("customers/invoice_print.php?no="+no);
}

$(document).ready(function(){
	mainPage = true;
	pageLoad("custMain.php");


	$(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                pageLoad(lastPage);
            }
        });

    $("#addCust").click(function() {
        pageLoad("customers/add.php");        
    });
});
</script>
