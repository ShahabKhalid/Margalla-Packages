<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Panel | Margalla Packages</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <?php
    require "../connection.php";
    ?>

</head>

<body>
    <?php

    if(!isset($_SESSION['admin']))
    {
    ?>
    <div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog">
                <div class="loginmodal-container">
                    <h1>Margalla Packages</h1>
                    <p>Login to Your Account</p><br>
                  <form>
                    <input type="email" name="email" id="_email" placeholder="Username">
                    <input type="password" name="pass" id="_pass" placeholder="Password">
                    <input type="button" name="login" class="login loginmodal-submit" value="Login" onclick="LoginAccount()">
                    <span id="wrong_msg"></span>
                  </form>
                    
                </div>
            </div>
          </div>
    <?php
    }
    else
    {
    ?>

        <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 head">
             <h4>Margalla Packages</h4>
            </div>
            <div class="col-sm-6 inav">
            <ul class="nav navbar-nav">
              <li class="active"><a href="javascript:void()" onclick="pageLoad('dashboard.php')">Dashboard</a></li>
              <li><a href="javascript:void()" onclick="pageLoad('gallery.php')">Gallery</a></li>
              <li><a href="javascript:void()">Products</a></li>
              <li><a href="javascript:void()" onclick="pageLoad('videos.php')">Videos</a></li>
              <li><a href="javascript:void()" onclick="pageLoad('admins.php')">Admins</a></li>
            </ul>
            </div>
            <div class="col-sm-4 lhead text-right">
                
                <?php
                    $qry = "SELECT * FROM `admin` WHERE `id` = '".$_SESSION['admin']."'";             
                    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $row = mysqli_fetch_array($run);
                ?>
                <img src="profile_pics/<?php echo $row['dp']; ?>" id="dp">
                <span id="name"><?php echo $row['fname']." ".$row['lname']; ?></span>
                <span id="post"><?php echo $row['title']; ?></span>
                <span id="dd_btn" class="glyphicon glyphicon-menu-down"></span>  
                <div class="dd-menu">
                <ul>
                    <li><a href="javascript:void()">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                </div>             
            </div>

        </div>
        <div class="row">

            <div class="col-md-12 main" id="apanel_area">
                
            </div>
        </div>

        </div>
    <?php
    }
    ?>
    <br><br>
    <p style="text-align:center;">Designed & Mainted By <a style="color:black;font-weight:bold;" target="_blank" href="http://www.bashsofts.com" title="BashSofts Website">BashSofts</a></p>
   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>

    $(document).ready(function(){
        $("#dd_btn").click(function() {
        if($(".dd-menu").css('visibility') == 'hidden')
          $(".dd-menu").css('visibility','visible');
        else
            $(".dd-menu").css('visibility','hidden');
        });
        
        <?php 
        if(isset($_GET['page']))
        { ?>
            pageLoad("<?php echo $_GET['page']; ?>.php");
        <?php
        }
        else
        {
        ?>
            pageLoad("dashboard.php");
        <?php
        }
        ?>
	}); 

    function sendAAForm()
    {
        document.getElementById("addadminform").submit();
    }

    function showUpdateAccForm()
    {
        alert("Under development....");
       //$("#new-account").slideUp();
        //$("#update-account").slideDown();
    }

    function showNewAccForm()
    {
        $("#update-account").slideUp();
        $("#new-account").slideDown();
    }

    function pageLoad(page)
    {
        $("#apanel_area").slideUp();
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {     
        if (xhttp.readyState != 4)
        {                
                $("#apanel_area").html('<h1 style="text-align:center;margin-top:20%;">Loading....</h1>');
        }
        if (xhttp.readyState == 4 && xhttp.status == 200) {         
            //alert(xhttp.responseText);            
            setTimeout(function(){ 
                $("#apanel_area").html(xhttp.responseText);
                $("#apanel_area").slideDown();
                $("#update-account").slideUp();
             }, 500);
            
        }
        };      
        xhttp.open("POST", ""+page+"", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();        
    }

    function LoginAccount() {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState != 4)
        {

        }
        if (xhttp.readyState == 4 && xhttp.status == 200) {  
            
            //alert(xhttp.responseText);
            if(xhttp.responseText === "0")
            {

                $("#wrong_msg").hide();
                $("#wrong_msg").text("Wrong credentials!");
                $("#wrong_msg").css({color:'red'});
                $("#wrong_msg").slideDown();
            }
            else if(xhttp.responseText === "1")
            {                               
                $("#wrong_msg").text("Logged in!");
                $("#wrong_msg").css({color:'green'});
                $("#wrong_msg").slideDown();
                window.location = "index.php";
            }
        }};  
        xhttp.open("POST", "do.php?action=login", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("email="+$("#_email").val()+"&pass="+$("#_pass").val()+"&ajax");
    } 

    function UpdateWCMsg() {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState != 4)
        {

        }
        if (xhttp.readyState == 4 && xhttp.status == 200) {  
            //alert(xhttp.responseText);
            if(xhttp.responseText === "0")
            {

                $("#not1").hide();
                $("#not1").text("Error while updating!");
                $("#not1").css({color:'red'});
                $("#not1").slideDown();
            }
            else if(xhttp.responseText === "1")
            {                      
                $("#not1").slideUp();            
                $("#not1").text("Message updated!");
                $("#not1").css({color:'green'});
                $("#not1").slideDown();                
            }
        }};  

        xhttp.open("POST", "do.php?action=update_wcmsg", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("text="+$("#_wc-msg").val()+"&ajax");
    } 

    function UpdateCEOMsg() {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (xhttp.readyState != 4)
        {

        }
        if (xhttp.readyState == 4 && xhttp.status == 200) {  
            //alert(xhttp.responseText);
            if(xhttp.responseText === "0")
            {

                $("#not2").hide();
                $("#not2").text("Error while updating!");
                $("#not2").css({color:'red'});
                $("#not2").slideDown();
            }
            else if(xhttp.responseText === "1")
            {                      
                $("#not2").slideUp();            
                $("#not2").text("Message updated!");
                $("#not2").css({color:'green'});
                $("#not2").slideDown();                
            }
        }};  

        xhttp.open("POST", "do.php?action=update_ceomsg", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("text="+$("#_ceo-msg").val()+"&ajax");
    } 


    </script>

</body>

</html>
