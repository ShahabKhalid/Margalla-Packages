<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Contact Us | Margalla Packages</title>
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
        <div class="container-fluid content">
            <div class="container-fluid">
                  <img src="images/contact.png" id="contact" />
            </div>
        </div>
        <div class="container-fluid menu-tab2">
            <div class="row" >
                <div class="col-sm-2 menu" style="height: 900px;">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="products.php">Our Products</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-10 msg-box" style="position:relative;top:-120px;">
                    <div class="row" style="padding-left:10px;padding-right:10px;">
                        <div class="col-md-6 contact-form">
                            <h1>Contact Us</h1>
                            <form name="msg-form" method="POST" action="sendmail.php">
                                <input type="text" name="fname" placeholder="First Name"><br>
                                <input type="text" name="lname" placeholder="Last Name"><br>
                                <input type="email" name="email" placeholder="Email"><br>
                                <input type="text" name="phone" placeholder="Phone"><br>
                                <textarea name="msg" placeholder="Enter your message for us here, we will get back to you within 2 working days">
                                    
                                </textarea>
                                <input type="submit" name="submit" value="Submit">                        
                            </form>
                        </div>
                        <div class="col-md-6 contact-form">
                            <h1>Our Office</h1>
                            <div style="width: 100%;border:1px solid black;"><iframe width="100%" height="350" src="http://www.maps.ie/create-google-map/map.php?width=100%&amp;height=400&amp;hl=en&amp;q=Street%206%20I-10%2F3%20Islamabad+(Margalla%20Packages)&amp;ie=UTF8&amp;t=&amp;z=17&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="http://www.mapsdirections.info/de/erstellen-sie-eine-google-map/">Google Maps meine karten</a> by <a href="http://www.mapsdirections.info/de/">Erstellen Google Map</a></iframe></div><br />
     
                        </div>
                        <div class="row">
                        <div class="col-md-6 feedback-form">
                            <h1>FeedBacks</h1>
                            <div class="feedback-box">
                                <div class="row">
                                <h4>Shahab Khalid</h4>
                                <p>Best services in Islamabad!</p>
                                </div>
                                <div class="row">
                                <h4>Tandoori</h4>
                                <p>Good services, will surely contact them again...</p>
                                </div>
                                <div class="row">
                                <h4>Rahat Backers</h4>
                                <p>Thanks for such services, highly recommended.</p>
                                </div>
                                <div class="row">
                                <h4>Karachi Baryani, F-8 Islamabad</h4>
                                <p>Thanks for such services, highly recommended.</p>
                                </div>
                            </div>
                            <form name="msg-form" method="POST" action="msg_send.php">
                                <input type="text" name="fname" placeholder="Name">
                                <input type="email" name="email" placeholder="Email"><br>
                                <textarea name="msg" placeholder="Enter your message for us here, we will get back to you within 2 working days">
                                    
                                </textarea>
                                <input type="submit" name="submit" value="Send FeedBack">                        
                            </form>
                        </div>
                        <div class="col-md-6 contact-form">
                            <h1>Our Factory</h1>
                            <div style="width: 100%;border:1px solid black;"><iframe width="100%" height="350" src="http://www.maps.ie/create-google-map/map.php?width=100%&amp;height=400&amp;hl=en&amp;q=Street%206%20I-10%2F3%20Islamabad+(Margalla%20Packages)&amp;ie=UTF8&amp;t=&amp;z=17&amp;iwloc=A&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="http://www.mapsdirections.info/de/erstellen-sie-eine-google-map/">Google Maps meine karten</a> by <a href="http://www.mapsdirections.info/de/">Erstellen Google Map</a></iframe></div><br />
                        </div>
                    </div>
                </div>
            </div>

        </div>  
                    <div class="row">
                <div class="col-sm-2 menu-btm">
                </div>
                <div class="col-md-10">
                    <div class="container-fluid text-center footer">
                    <p id="cpyright">© 2016 <b>Margalla Packages Islamabad</b> All Rights Reserved</p>  

                    <p>Designed By <a target="_blank" href="http://www.bashsofts.com" title="BashSofts Website">BashSofts</a></p>      
                    </div>
                </div>
            </div>  
    </div>
   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src='https://maps.googleapis.com/maps/api/js?v=3.exp'></script>

    <script>

    $(document).ready(function(){

	}); 




    </script>

</body>

</html>
