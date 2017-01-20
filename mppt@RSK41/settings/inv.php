<br><br><br><br>
<div class="container addBox">
<div class="inBox">
<h1>Bag Size Settings</h1>
<h3>Add Size</h3>
<label>Size:</label> <input type="text" name="size" id="size">
<input type="button" name="addsize" value="Add" onclick="addSize()"><br><br>
<span id="not">Size Added</span>
<br><br>
<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-1 border head_" style="background-color:rgba(220,220,220,1)">Sr.</div>
	<div class="col-sm-3 border head_" style="background-color:rgba(220,220,220,1)">Size</div>
	<div class="col-sm-2 border head_" style="background-color:rgba(220,220,220,1)">Delete</div>
	<div class="col-sm-3"></div>
</div>
<div id="sizetable">

</div>
<br><br>
</div>
</div>
<script>
function onPageLoad()
{
	$("#not").slideUp();
	$("#size").focus();
	updateSizeTable();
}


function updateSizeTable()
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
    	//alert(xhttp.responseText);
        $("#sizetable").html(xhttp.responseText);
    }};  

    xhttp.open("POST", "settings/size_table.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}


function delSize(id)
{

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {

    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        //alert(xhttp.responseText);
        if(xhttp.responseText === "1")
        {                      
         	updateSizeTable();
        }
    }};  

    xhttp.open("POST", "do.php?action=deletesize", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&ajax");     
	
}


function addSize()
{
	var size = $("#size").val();
	if(size.length < 1)
	{
		alert("Please enter size!");
		return;
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
            $("#not").text("Size Added!");
            $("#not").css({color:'green'});
            $("#not").slideDown();  
            $("#size").val("");
            $("#size").focus();
            updateSizeTable();            
        }
    }};  

    xhttp.open("POST", "do.php?action=addsize", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("size="+size+"&ajax");     
	
}

</script>