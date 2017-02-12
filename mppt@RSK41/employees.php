<br><br><br>
<div class="conatiner-fluid">
	<div class="row">
		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(70,23,180,.8);">
			<div class="row" onclick="pageLoad('employees/list.php')">
				<?php
					require "123321.php";
					$qry = "SELECT * FROM `employee` WHERE 1";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$customerCount = mysqli_num_rows($run);
				?>
				<div class="col-md-6" id="view"><h1><?php echo $customerCount; ?></h1>
				</div>
				<div class="col-md-6"><span class="glyphicon glyphicon-user"></span></div>
			</div>
			<h2 style="background-color:rgba(70,23,180,255);">Employee</h2>
			<ul style="background-color:rgba(70,23,180,255);">
			<li><a href="javascript:void()" id="addEmp" title="Add Customer">Add Employee</a></li>
			<li><a href="#" onclick="return pageLoad('employees/list.php')" title="Edit Customer">List Employees</a></li>
			</ul></div>
		</div>
		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(170,64,255,.8);">
			<div class="row" onclick="return pageLoad('employees/salarysheet.php')">
				<div class="col-md-6" id="view"><h1>Salary</h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-send"></span></div>
			</div>
			<h2 style="background-color:rgba(170,64,255,255);" onclick="return pageLoad('employees/salarysheet.php')">Salary Sheet</h2>
			<ul style="background-color:rgba(170,64,255,255);">
			<li><a href="javascript:void()" onclick="return pageLoad('employees/yearlysalarysheet.php')" title="Add Customer">Overall Salaries</a></li>
			<li>.</li>
			</ul></div>
		</div>

		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(31,174,255,.8);">
			<div class="row" onclick="return pageLoad('employees/adv_list.php')">
				<div class="col-md-6" id="view"><h1>Advances</h1></div>
				<div class="col-md-6"><span class="glyphicon glyphicon-usd"></span></div>
			</div>
			<h2 style="background-color:rgba(31,174,255,255);">Advance</h2>
			<ul style="background-color:rgba(31,174,255,255);">
			<li><a href="#" onclick="return pageLoad('employees/add_adv.php')" title="Add Advance">Add Advance</a></li>
			<li><a href="#" onclick="return pageLoad('employees/adv_list.php')" title="Edit Advance">List Advance</a></li>
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

$(document).ready(function(){
	mainPage = true;
	pageLoad("empMain.php");


	$(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                pageLoad(lastPage);
            }
        });

    $("#addEmp").click(function() {
        pageLoad("employees/add.php");
    });
});
</script>
