<br><br><br>
<div class="conatiner-fluid">
	<div class="row">
		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(70,23,180,.8);">
			<div class="row" onclick="pageLoad('sheets/profitsheet.php')">
				<?php
					require "123321.php";
				?>
				<div class="col-md-6" id="view"><h1>Profit Sheet</h1>
				</div>
				<div class="col-md-6"><span class="glyphicon glyphicon-user"></span></div>
			</div>
			<h2 style="background-color:rgba(70,23,180,255);">Profit Sheet</h2>
			<ul style="background-color:rgba(70,23,180,255);">
			<li>.</li>
			<li>.</li>
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
			<li>.</li>
			<li>.</li>
			</ul></div>
		</div>

		<div class="col-md-4 infoBox">
			<div class="box" style="background-color: rgba(31,174,255,.8);">
			<div class="row">
				<div class="col-md-12" id="view"><h1>Employee Advance</h1></div>
			</div>
			<h2 style="background-color:rgba(31,174,255,255);">Advance</h2>
			<ul style="background-color:rgba(31,174,255,255);">
			<li>.</li>
			<li><a href="#" title="Edit Advance">..</a></li>
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
function pageLoad(page)
{
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


    }
    };
    xhttp.open("POST", ""+page+"", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

$(document).ready(function(){
	mainPage = true;
	pageLoad("sheets/sheets.php");


	$(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                if(!mainPage) location.reload();
            }
        });

    $("#addEmp").click(function() {
        pageLoad("employees/add.php");
    });
});
</script>
