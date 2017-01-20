<div class="container addBox">
<div class="inBox">
<h1>New Petty Cash</h1>
<form id="addPettyCashForm">
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Date</label></div><div class="col-md-5"><input class="mainField" type="date" name="date" id="dateEle" value="<?php echo date("Y-m-d"); ?>"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Description</label></div><div class="col-md-5"><input class="mainField"  type="text" placeholder="Expence Discription" ></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Amount</label></div><div class="col-md-5"><input class="mainField" maxlength="20" type="text" placeholder="Expence Amount"></div><div class="col-md-1"></div></div><br>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><input class="mainField" onclick="addPettyCash()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Petty Cash successfully added!</p></div>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function onPageLoad()
{
	$("i").slideUp();
	$("#not").slideUp();
	$("#dateEle").focus();
}
function addPettyCash()
{
	var addForm = document.getElementById("addPettyCashForm");
	var date = addForm[0].value;
	var desc = addForm[1].value;
	var amount = addForm[2].value;


	//alert(name);

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {
            $("#not").hide();
            $("#not").text("Error while adding!");
            $("#not").css({color:'red'});
            $("#not").slideDown();
        }
        else if(xhttp.responseText === "1")
        {
            $("#not").slideUp();
            $("#not").text("Petty Cash Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            addForm.reset();
            $("#dateEle").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=addPettyCash", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("date="+date+"&desc="+desc+"&amount="+amount+"&ajax");

}
</script>
