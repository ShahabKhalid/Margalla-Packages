<br><br>
<br><br><br><br>
<script src="settings/upload.js"></script>
<div class="container addBox">
<div class="container-fluid white-box">
    <h3>Upload File</h3>
    <form id="upload" action="" method="post" enctype="multipart/form-data">
    <hr id="line">
    <div id="select">
    <label>Select Your File</label><br/>
    <input style="position:relative;margin:0 auto;" type="file" name="file" id="file" required /><br>
    <input type="submit" value="Upload" class="submit" />
    </div>
    </form>
    <h4 id='loading' >Loading..</h4>
    <div id="message"></div><br><br>
</div><br>
<br><br>
<div class="container-fluid white-box">
    <h3>Current Files</h3><br>
    <div class='row'>
        <div class="col-sm-2 bold" style="border:1px solid black;">Sr.</div>
        <div class="col-sm-4 bold" style="border:1px solid black;">Name</div>
        <div class="col-sm-2 bold" style="border:1px solid black;">Size</div>
        <div class="col-sm-2 bold" style="border:1px solid black;">Download</div>
        <div class="col-sm-2 bold" style="border:1px solid black;">Delete</div>
    </div>
    <?php
    $count = 0;
    foreach (glob("../uploads/*") as $filename) {
        ?>
        <div class='row'>
            <div class="col-sm-2" style="border:1px solid black;"><?php echo $count++; ?></div>
            <div class="col-sm-4" style="border:1px solid black;"><?php echo basename($filename); ?></div>
            <div class="col-sm-2" style="border:1px solid black;"><?php echo filesize($filename); ?></div>
            <div class="col-sm-2" style="border:1px solid black;"><a href="mppt@RSK41/<?php echo $filename ?>" target="_blank">Download</a></div>
            <div class="col-sm-2" style="border:1px solid black;"><a href="javascript:void()" onclick="deleteFile('<?php echo basename($filename); ?>')">Delete</a></div>
        </div>
        <?php

    }
    ?>
<br><br>
</div><br>


</div>
<br><br><br><br>
<br><br><br><br>
<script>
function deleteFile(file)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        alert(xhttp.responseText);
        if(xhttp.responseText === "1")
        {                      
            pageLoad("files.php");            
        }
    }};  

    xhttp.open("POST", "settings/deleteFile.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("file="+file+"&ajax");      
    
}
</script>