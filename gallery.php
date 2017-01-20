<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gallery | Margalla Packages</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <?php
    require "connection.php";
    ?>

</head>

<body>
    <div class="container-fluid main fullpageImage">
        <p>Press <b>Escape</b> to Exit</p>
        <img id="fullpageImg" src="images/logo.jpg" title="Margalla Packages Islamabad" />   
    </div>
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
            </div>
        </div>
        <div class="container-fluid menu-tab3">
            <div class="row">
                <div class="col-sm-2 menu" style="min-height: 2200px;">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="products.php">Our Products</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-10 msg-box gallery">  
                <h1>Our Gallery</h1>     
                <br>
                <div id="big-box">
                <div id="img_vid_space">
                <img src="" id="big">
                </div>
                <marquee id="video_queue" scrollamount="4" onmouseover="this.stop();" onmouseout="this.start();">
                <?php
                 $qry = "SELECT * FROM `videos`";             
                    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
                    $count = 1;
                    while($row = mysqli_fetch_array($run))
                    {
                    ?>  
                    <video class="videoall" width="100" height="60" style="border:2px solid black;" title="Video: Click to play" src="admin/videos/<?php echo $row['link']; ?>" type="video/mp4">
                      Your browser does not support HTML5 video.
                    </video>
                    <?php 
                }
                ?>
                </marquee>
                <br><br><br>
                <div style="position:relative; background-color: white; margin:0 auto;"><br><br>
                <div class="row">
                    <?php                        
                        $filenameArray = [];
                        $count = 0;
                        $count_i = 0;
                        $handle = opendir(dirname(realpath(__FILE__)).'/admin/gallery/');
                        while($file = readdir($handle) ){
                            if($file !== '.' && $file !== '..'){
                                    echo '<div class="col-sm-1">
                                    <img src="admin/gallery/'.$file.'" id="img_'.$count++.'" class="gal_img"/>
                                    </div>';
                                    $count_i++;
                                    if($count_i == 11)
                                    {
                                        echo "</div><br><div class='row'>";
                                        $count_i = 0;
                                    }
                            }                            
                        }            
                     ?>
                     </div>
                    <br><br> 
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
    </div>
   	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    var isImage = true;
    var currentImage = 0;
    function changeImage(img,currentImage)
    {
        $("#big").fadeOut(500);                   
        setTimeout(function(){
        $("#big").attr("src", img);
        $("#big").fadeIn(500);
        $(".gal_img").css("border","2px solid black");
        $("#img_"+currentImage+"").css("border","5px solid #5379ba");
         }, 500);
    }

    

    $(document).ready(function(){

        $(document).keyup(function(e) {
             if (e.keyCode == 27) { // escape key maps to keycode `27`
                $(".fullpageImage").fadeOut();
            }
        });

         
         $(".fullpageImage").fadeOut();
         $( ".gal_img" ).click(function() {
            if(!isImage){
                isImage = true;
                $("#img_vid_space").html('<img src="" id="big">');
            }
            currentImage = parseInt(this.id.substring(this.id.indexOf("_")+1,this.id.length));
            changeImage($(this).attr("src"),currentImage);
        });


         $( "#big" ).click(function() {
            $("#fullpageImg").attr("src", $(this).attr("src"));
            $(".fullpageImage").fadeIn();
        });




         $( ".videoall" ).click(function() {
            //currentImage = parseInt(this.id.substring(this.id.indexOf("_")+1,this.id.length));
            //changeImage($(this).attr("src"),currentImage);
            //alert($(this).attr("src"));
            $("#img_vid_space").html('<video class="videoall" width="100%" height="91%" style="border:2px solid black;" title="Video: Click to\ play" src="'+$(this).attr("src")+'" type="video/mp4" controls>\
                      Your browser does not support HTML5 video.\
                    </video>');
            isImage = false;

        });
         changeImage($("#img_"+currentImage+"").attr("src"),currentImage);
         setInterval(function(){ 
            if(isImage) {
                    currentImage+=1;
                    
                    //alert(currentImage);
                    if(currentImage == <?php echo $count; ?>)
                        currentImage = 0;
                    changeImage($("#img_"+currentImage+"").attr("src"),currentImage);
                }
            }, 5000);
            

        /*$(".gal_img").click(function(){
            var img = this.src;
            changeImage(img);
        });*/

	}); 




    </script>

</body>

</html>
