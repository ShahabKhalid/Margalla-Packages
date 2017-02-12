<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MPPT | Margalla Packages Islamabad</title>
    <link rel="shortcut icon" type="image/png" href="../favicon.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/_style.css" rel="stylesheet">
    <?php
    require "123321.php";
    ?>
</head>

<body>
    <?php
    if(!isset($_SESSION['mppt_admin']))
    {
    ?>
    <div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog">
                <div class="loginmodal-container">
                    <h1>Margalla Packages</h1>
                    <p>Login to Your Account</p><br>
                  <form>
                    <input type="text" name="email" id="_email" placeholder="Username" value="">
                    <input type="password" name="pass" id="_pass" placeholder="Password" value="">
                    <input type="password" name="pin" id="_pin" placeholder="Security Pin" value="">
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
            <div class="col-sm-10 inav" style="padding-left: 0px;">
            <ul class="nav navbar-nav mainMenu" >
                <?php
                $qry = "SELECT a.*,l.title FROM `alpha` a, `level` l WHERE a.level = l.id and a.id = '".$_SESSION['mppt_admin']."'";
                $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                $row = mysqli_fetch_array($run);
                ?>
                <li><a href="javascript:void()" style="color: black; background-color: white;"><span class=" 	glyphicon glyphicon-user"></span> <?php echo $row['fname']." ".$row['lname']." [<span style='color:green;'> ".$row['title']."</span> ]"; ?></a></li>

                <li class="active"><a href="?page=customers" >Customer</a></li>
              <li><a href="?page=vendors">Vendors</a></li>
              <li><a href="?page=employees">Employees</a></li>
                <?php
              if(strcmp($_SESSION['access'],"all") === 0)
              {
              ?>
              <li><a href="?page=expences">Expences</a></li>
              <li><a href="?page=ledgers">Ledgers</a></li>
              <li><a href="?page=vanledger">Van Ledger</a></li>
              <li><a href="?page=sheets"><span class="glyphicon glyphicon-list-alt"></span> Sheets</a></li>
              <li><a href="?page=settings"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>

                  <?php
              }
              ?>
                <li><a href="logout.php" style="color: black;"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
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
   	<script src="js/jquery.min.js"></script>

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
            pageLoadX("<?php echo $_GET['page']; ?>.php");
        <?php
        }
        else
        {
        ?>
            pageLoadX("customers.php");
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

    function pageLoadX(page)
    {
        //alert(page);
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
                 //alert("Work Done\n1) Customers LD and HD Rate! Also Change it for old invoices!\n2)Ledger new req. particular is hardcore!\n3)Files can be uploaded at Settings>Files.");
                window.location = "index.php";
            }
        }};
        xhttp.open("POST", "do.php?action=login", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("email="+$("#_email").val()+"&pass="+$("#_pass").val()+"&pin="+$("#_pin").val()+"&ajax");
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
