<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Margalla Packages</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <?php
    require "connection.php";
    ?>

</head>

<body>
    <div class="container-fluid main">
            <div class="row">
            <div class="col-sm-6">
                <div class="conatiner-fluid">
                <?php
                    $qry = "SELECT `text` FROM misc WHERE `name` = 'headImage'";
                    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $row = mysqli_fetch_array($run);
                ?>
                    <img src="<?php echo $row['text']; ?>" title="Margalla Packages Islamabad" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="contact-info text-right">
                    <ul>
                        <?php
                            $qry = "SELECT `text` FROM misc WHERE `name` = 'phone1'";
                            $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                            $row = mysqli_fetch_array($run);
                        ?>
                        <li><span class="glyphicon glyphicon-phone"></span> <?php echo $row['text']; ?> <span class="glyphicon glyphicon-phone"></span> 
                        <?php
                            $qry = "SELECT `text` FROM misc WHERE `name` = 'phone2'";
                            $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                            $row = mysqli_fetch_array($run);
                        ?>
                        <?php echo $row['text']; ?></li>
                        <?php
                            $qry = "SELECT `text` FROM misc WHERE `name` = 'email'";
                            $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                            $row = mysqli_fetch_array($run);
                        ?>
                        <li><span class="glyphicon glyphicon-envelope"></span> <?php echo $row['text']; ?></li>
                        <?php
                            $qry = "SELECT `text` FROM misc WHERE `name` = 'address'";
                            $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                            $row = mysqli_fetch_array($run);
                        ?>
                        <li><?php echo $row['text']; ?></li>
                    </ul>
                </div>
            </div>
            </div>
        <div class="container-fluid info-bar text-center">
        <?php
            $qry = "SELECT `text` FROM misc WHERE `name` = 'wc_msg'";             
            $run = mysqli_query($con,$qry) or die(mysqli_error($con));
            $row = mysqli_fetch_array($run);
        ?>
            <marquee scrolldelay="150"><p><?php echo $row["text"]; ?></p></marquee>
        </div>
        <div class="body">
        <div class="container-fluid content">
            <div class="container-fluid">
                  <img src="images/msg_logo.png" id="msg_logo" />
            </div>
        </div>
        <div class="container-fluid menu-tab">
            <div class="row">
                <div class="col-sm-2 menu">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="products.php">Our Products</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-10 msg-box">
                <br><br><br><br>
                <div class="row">
                 <div class="col-sm-1"></div>
                    <div class="col-sm-5">
                        <p style="font-weight:normal">
                        <b>Our Products</b><br><br>
                        <ul>
                        <li>Ld material</li>
                        <li>Hd material</li></ul>   
                        <br><br>
                        <b>We are making packings and bags of  following products</b><br>
                        <ul>
                        <li>Flour bags</li>
                        <li>Tea packing</li>
                        <li>Soap and all detergents packing</li>
                        <li>Cooking oil packing</li>
                        <li>Cooking salt packing</li>
                        <li>Pickle packing</li>
                        <li>Nimko packing</li>
                        <li>Dall and nuts pakings</li>
                        <li>Sugar packing</li>
                        <li>Rice packing</li>
                        <li>1Sweets and bakers ( carry bags )</li>
                        <li>Garments (shopping bags )</li>
                        <li>Marts ( carry bags)</li>
                        <li>Medical and pharmacy’s products packing ( carry bags)</li>
                        <li>And any packing of material ld , hd and pp with flexo or gravior printing</li></p>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-4"><h2 style="text-align:center;">Featured</h2>
                    <img src="images/gallery/1.jpg" style="width:400px;height:400px;border:1px solid black;" title="Featured Product">
                    </div>
                    

                    <div class="col-sm-1"></div>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 menu-btm">
                </div>
                <div class="col-md-10">                
                    <div class="container-fluid text-center footer">
                    <div id="socail">
                    <ul >
                        <li><a href="https://www.facebook.com/margallapackages?__mref=message_bubble" title="Facebook Page">FaceBook</a></li>
                        <li><a href="https://twitter.com/xubair2099" title="witter">Twitter</a></li>
                    </ul>
                    </div>
                    <p id="cpyright">© 2016 <b>Margalla Packages Islamabad</b> All Rights Reserved</p>  

                    <p>Designed By <a target="_blank" href="http://www.bashsofts.com" title="BashSofts Website">BashSofts</a></p>      
                    </div>
                </div>
            </div>
        </div>  
        
    </div>
    </div>
   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>

    $(document).ready(function(){

	}); 




    </script>

</body>

</html>
