<div class="container addBox">
<div class="inBox">
<h1>New Account</h1>
<form id="addAccountForm">
<div class="row" id="r1"><div class="col-md-1"></div><div class="col-md-5"><label>Name</label></div><div class="col-md-5"><input class="mainField" maxlength="24" id="nameEle" type="text" name="custName" placeholder="Account Name"></div><div class="col-md-1"></div></div>
<div class="row" id="r1"><div class="col-md-6"></div><div class="col-md-4"><i id="nameErr">Please enter the name!</i></div><div class="col-md-2"></div></div><br>
<div class="row" id="r1"><input class="mainField" onclick="addAccount()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Account successfully added!</p></div>
</form>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function onPageLoad()
{
    $("i").slideUp();
    $("#not").slideUp();
    $("#nameEle").focus();
}
function addAccount()
{
    var addForm = document.getElementById("addAccountForm");
    var name = addForm[0].value;

    if(name.length < 1)
    {
        $("#nameErr").slideDown();
        return;
    }
    else
    {
        $("#nameErr").slideUp();
    }
    //alert(name);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
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
            $("#not").text("Ledger Account Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
            addForm.reset();
            $("#nameEle").focus();
        }
    }};

    xhttp.open("POST", "do.php?action=addledgeraccount", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name="+name+"&ajax");

}
</script>
