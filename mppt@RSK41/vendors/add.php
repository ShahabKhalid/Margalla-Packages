<div class="container addBox">
<div class="inBox"> 
<h1>New Vendor</h1>
<form id="addVendorForm">
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Name</label></div><div class="col-md-4"><input class="mainField" maxlength="24" id="nameEle" type="text" name="custName" placeholder="John Doe"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="nameErr">Please enter the name!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-4"><input class="mainField" maxlength="12" type="text" name="custNo" placeholder="0334-2548762"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="contErr">Please enter the contact!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"></div><div class="col-md-3"><label>Address</label></div><div class="col-md-4"><input class="mainField" maxlength="62" type="text" name="custAddr" placeholder="Address"></div><div class="col-md-3"></div></div>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"><i id="addrErr">Please enter the address!</i></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-5"></div><div class="col-md-4"></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><input class="mainField" onclick="addVendor()" type="button" name="submit" value="Add"></div><br>
<div class="row" id="r1"><p id="not">Vendor successfully added!</p></div>
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
function addVendor()
{
	var addForm = document.getElementById("addVendorForm");
	var name = addForm[0].value;
	var contact = addForm[1].value;
	var addr = addForm[2].value;

	if(name.length < 1)
	{
		$("#nameErr").slideDown();
		return;
	}
	else
	{
		$("#nameErr").slideUp();
	}


	if(contact.length < 1)
	{
		$("#contErr").slideDown();
		return;
	}
	else
	{
		$("#contErr").slideUp();
	}

	if(addr.length < 1)
	{
		$("#addrErr").slideDown();
		return;
	}
	else
	{
		$("#addrErr").slideUp();
	}

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
            $("#not").text("Vendor Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();  
            addForm.reset();  
            $("#nameEle").focus();            
        }
    }};  

    xhttp.open("POST", "do.php?action=addvendor", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("name="+name+"&contact="+contact+"&addr="+addr+"&ajax");     
	
}
</script>