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
                <br><br>
                <div style="position:relative;left:60px;">
                <?php
                    $qry = "SELECT `text` FROM misc WHERE `name` = 'msgImage'";
                    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $row = mysqli_fetch_array($run);
                ?>
                <img src="<?php echo $row['text']; ?>" style="width:95%;height:450px;"/>
    
                </div>
                    
                    <div class="speciality">
                        <h1>Our Speciality</h1>
                        <div class="row container sp_box_super">
                            <div class="col-md-4 sp_box">
                                <img src="images/quality.jpg" title="Quality Products" />
                                <h2>Quality Concerns</h2><br>
                                <p>Quality at Margalla Packages is not just reflected in their products and procedures but it is the state of mind of each employee and the system which they follow to acheive their work objectives.</p>
                            </div>
                            <div class="col-md-4 sp_box">
                                <img src="images/vision.jpg" title="Our Vision" />
                                <h2>Our Visions</h2><br>
                                <p>Our vision is to persistently seeking ways to improve production efficiency and quality. Our strength lies in personalized skills and clode monitoring of the requirenments of our varied range.</p>
                            </div>
                            <div class="col-md-4 sp_box">
                                <img src="images/wedesign.jpg" title="We designs" />
                                <h2>We Design</h2><br>
                                <p>New style in new millennium. Keeping in view our lofty tradition, Flexo printing is now offered. Printing of fabrics bags, ghee bags, sweet bags, carry bags, shoe, garments, surf and soap bags.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
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

</body>

</html>
