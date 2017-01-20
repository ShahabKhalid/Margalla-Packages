<script src="ledgers/upload.js"></script>
<div class="container addBox">
<div class="container-fluid white-box">
    <h3>Upload Ledgers (xls File Only)</h3>
    <form id="uploadcsv" action="" method="post" enctype="multipart/form-data">
    <hr id="line">
    <div id="selectCSV">
    <label>Select Your Excel File</label><br/>
    <input style="position:relative;margin:0 auto;" type="file" name="file" id="file" required /><br>
    <input type="submit" value="Upload" class="submit" />
    </div>
    </form>
    <h4 id='loading' >Loading..</h4>
    <div id="message"></div><br><br>
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
