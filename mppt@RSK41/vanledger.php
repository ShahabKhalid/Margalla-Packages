<br><br><br>
<div class="container-fluid" id="settings_main">

</div>
<script>
var mainPage = true;
var currentPage = null;
var lastPage = null;
function pageLoad(page)
{   
    lastPage = currentPage;
	if(page == "vanledger.php")
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
    xhttp.open("POST", "vanledger/"+page+"", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

$(document).ready(function(){
	mainPage = true;
	pageLoad("vanledger.php");


	$(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                pageLoad(lastPage);
            }
        });
});
</script>
