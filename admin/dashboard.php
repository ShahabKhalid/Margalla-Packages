<?php 
require "../connection.php";
?>
<br><br>
<br><br>
<div class="container-fluid white-box">
	<h3>Welcome Message</h3>
	<?php
        $qry = "SELECT `text` FROM misc WHERE `name` = 'wc_msg'";             
        $run = mysqli_query($con,$qry) or die(mysqli_error($con));
        $row = mysqli_fetch_array($run);
    ?>
	<textarea name="wc_msg" id="_wc-msg"><?php echo $row["text"]; ?></textarea><br><br>
	<button name="update" id="update-btn" onclick="UpdateWCMsg()">Update</button><br>
	<span id="not1"></span><br><br>
</div>
<br><br><br>
<div class="container-fluid white-box">
	<h3>CEO Message</h3>
	<?php
        $qry = "SELECT `text` FROM misc WHERE `name` = 'ceo_msg'";             
        $run = mysqli_query($con,$qry) or die(mysqli_error($con));
        $row = mysqli_fetch_array($run);
    ?>
	<textarea name="ceo_msg" id="_ceo-msg"><?php echo $row["text"]; ?></textarea><br><br>
	<button name="update" id="ceo-update-btn" onclick="UpdateCEOMsg()">Update</button><br>
	<span id="not2"></span><br><br>
</div>
<br><br><br>
<div class="container-fluid white-box">
	<h3>Contact Details</h3>
	<?php
        $qry = "SELECT `text` FROM misc WHERE `name` = 'phone1'";             
        $run = mysqli_query($con,$qry) or die(mysqli_error($con));
        $row = mysqli_fetch_array($run);
    ?>
	<div>Phone 1: <input id="phone1" type="text" value='<?php echo $row["text"]; ?>'></div><br>
	<?php
        $qry = "SELECT `text` FROM misc WHERE `name` = 'phone2'";             
        $run = mysqli_query($con,$qry) or die(mysqli_error($con));
        $row = mysqli_fetch_array($run);
    ?>
	<div>Phone 2: <input id="phone2" type="text" value='<?php echo $row["text"]; ?>'></div><br>
	<?php
        $qry = "SELECT `text` FROM misc WHERE `name` = 'email'";             
        $run = mysqli_query($con,$qry) or die(mysqli_error($con));
        $row = mysqli_fetch_array($run);
    ?>
	<div>Email @: <input id="email" type="text" value='<?php echo $row["text"]; ?>'></div><br>
	<?php
        $qry = "SELECT `text` FROM misc WHERE `name` = 'address'";             
        $run = mysqli_query($con,$qry) or die(mysqli_error($con));
        $row = mysqli_fetch_array($run);
    ?>
	<div>Address: <input id="addr" type="text" value='<?php echo $row["text"]; ?>'>
	</div><br><br>
	<button name="update" id="ceo-update-btn" onclick="UpdateContactDetails()">Update</button><br>
	<span id="not3"></span><br><br>
</div>
<br><br><br>
<script src="uploadhimg.js"></script>
<div class="container-fluid white-box">
	<h3>Header Image</h3>
	<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
	<div id="image_preview"><img id="previewing" src="noimage.png" /></div>
	<hr id="line">
	<div id="selectImage">
	<label>Select Your Image</label><br/>
	<input style="position:relative;margin:0 auto;" type="file" name="file" id="file" required /><br>
	<input type="submit" value="Upload" class="submit" />
	</div>
	</form>
	<h4 id='loading' >Loading..</h4>
	<div id="message"></div><br><br>
</div>
<br><br><br>
<script src="uploadmsgimg.js"></script>
<div class="container-fluid white-box">
	<h3>Message Image</h3>
	<form id="uploadimage2" action="" method="post" enctype="multipart/form-data">
	<div id="image_preview2"><img id="previewing2" src="noimage.png" /></div>
	<hr id="line2">
	<div id="selectImage2">
	<label>Select Your Image</label><br/>
	<input style="position:relative;margin:0 auto;" type="file" name="file" id="file2" required /><br>
	<input type="submit" value="Upload" class="submit" />
	</div>
	</form>
	<h4 id='loading2' >Loading..</h4>
	<div id="message2"></div><br><br>
</div>
<script type="text/javascript">
function UpdateContactDetails() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState != 4)
    {

    }
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        //alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {

            $("#not3").hide();
            $("#not3").text("Error while updating!");
            $("#not3").css({color:'red'});
            $("#not3").slideDown();
        }
        else if(xhttp.responseText === "1")
        {                      
            $("#not3").slideUp();            
            $("#not3").text("Contact updated!");
            $("#not3").css({color:'green'});
            $("#not3").slideDown();                
        }
    }};  

    xhttp.open("POST", "do.php?action=update_contactdetails", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("phone1="+$("#phone1").val()+"&phone2="+$("#phone2").val()+"&email="+$("#email").val()+"&addr="+$("#addr").val()+"&ajax");
} 	

</script>