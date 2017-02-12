<br>
<div class="container-fluid">
<div class="row">
	<div class="col-md-12 head2">
		<ul>
			<li><a href="javascript:void()" onclick='pageLoad("home.php");'>Home</a></li>
			<li><a href="javascript:void()" onclick='pageLoad("inv.php");'>Bag Size</a></li>
			<li><a href="javascript:void()" onclick='pageLoad("logs.php");'>Logs</a></li>
            <li><a href="javascript:void()" onclick='pageLoad("loginlogs.php");'>Login Logs</a></li>
            <li><a href="javascript:void()" onclick='pageLoad("accounts.php");'>Accounts</a></li>
			<li><a href="javascript:void()" onclick='pageLoad("files.php");'>Uploads</a></li>
		</ul>
	</div>
</div>
</div>
<div class="container-fluid" id="settings_main">

</div>
<script>
var mainPage = true;
var currentPage = null;
var lastPage = null;
function pageLoad(page)
{   
    lastPage = currentPage;
	if(page == "home.php")
		mainPage = true;
	else
		mainPage = false;
    $("#settings_main").slideUp();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {
            $("#settings_main").html('<h1 style="text-align:center;margin-top:20%;">Loading....</h1>');
    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        setTimeout(function(){
            $("#settings_main").html(xhttp.responseText);
            $("#settings_main").slideDown();
            //$("#update-account").slideUp();
            onPageLoad();
         }, 500);
        currentPage = page;


    }
    };
    xhttp.open("POST", "settings/"+page+"", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

$(document).ready(function(){
	mainPage = true;
	pageLoad("home.php");


	$(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                pageLoad(lastPage);
            }
        });
});
</script>
