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
                    <img src="images/logo.jpg" title="Margalla Packages Islamabad" />                    
                </div>
            </div>
            <div class="col-sm-6">
                <div class="contact-info text-right">
                    <ul>
                        <li><span class="glyphicon glyphicon-phone"></span> 0333-5552099 <span class="glyphicon glyphicon-phone"></span> 0300-5552099</li>
                        <li><span class="glyphicon glyphicon-envelope"></span> ceo@margallapackages.com</li>
                        <li>Plot. 81F, Street 6 I-10/3 Islamabad</li>
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
                  <h1 id="page-title">Quotations</h1>
            </div>
        </div>
        <div class="container-fluid menu-tab">
            <div class="row">
                <div class="col-sm-2 menu" style="height:1200px;">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="products.php">Our Products</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="quotations.php">Quotations</a></li>
                    </ul>
                </div>
                <div class="col-md-10 msg-box" style="background-image:url('images/sp_page.png');height:1100px;background-size:100% 100%;background-repeat:no-repeat;">
                    <br><br><br><br>
                    <div class="row quot">
                     <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label>Bag Size</label></div><div class="col-sm-2"><input type="" name="bagsize" /></div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label>Bag Material</label></div><div class="col-sm-2"><input type="" name="bagmat" /></div>
                    <div class="col-sm-2"></div>
                    </div><br><br>
                    <div class="row quot">
                     <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label>Colors</label></div><div class="col-sm-2"><input type="number" name="bagsize" /></div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label>Loops</label></div><div class="col-sm-2"><input type="" name="bagmat" /></div>
                    <div class="col-sm-2"></div>
                    </div><br><br>
                    <div class="row quot">
                     <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label>Quantity</label></div><div class="col-sm-2"><input type="" name="bagsize" /></div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label style="font-size:12px;">Golden/Silver Colour in  printing or bag</label></div><div class="col-sm-2"><input type="" name="bagmat" /></div>
                    <div class="col-sm-2"></div>
                    </div><br><br>
                    <div class="row quot">
                     <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label>Block Size</label></div><div class="col-sm-2"><input type="" name="bagsize" /></div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label style="font-size:12px;">Guage (Thinkness Of Bag)</label></div><div class="col-sm-2"><input type="" name="bagmat" /></div>
                    <div class="col-sm-2"></div>
                    </div><br><br>
                    <div class="row quot">
                     <div class="col-sm-1"></div>
                        <div class="col-sm-2"><label>Bag Color</label></div><div class="col-sm-2"><input type="" name="bagsize" /></div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2"></div><div class="col-sm-2"></div>
                    <div class="col-sm-2"></div>
                    </div><br><br><br><br>
                    <p style="padding-left:70px;font-weight:normal;">
                    MATERIALS:
                    <br><br>
                    HD (High Density): These bags are used in shopping malls and have good strength.These shoppers can lift weight upto 15kgs depends upon its guage and its size.

                    HD Shopping bags are also divide in sub categories.
                    Hd3,Hdp,Hdr,Hdab3,Hdab6
                    <br><br>
                    LD (Low Density): These are used in garments shops having some grace and attraction, if you want transparent shoppers then LD materials is best.It is also use for packing of salt, oil, tea, rice, daal, sugar and many more.

                    <br><br>
                    COLORS:<br>
                    Our flexo machine can print maximum 6 colours (3+3) at a time (3 colours on back and 3 on front)<br>
                    1+0: means print only one side front or back and havinf only one colour so your block wil also be 1<br>
                    1+1: print front and back but only one colour prining in one side but you can print another colour on another size in 1 + 1 colour job blocks wil be 2 for front and back<br>
                    1+2: in this job 1 colour in one side and 2 in other side.<br>
                    1+3: 1 colour on one side 3 on other side.<br>
                    1+4: 1 colour on one side 4 on other side.<br>
                    2+2: 2 colour on one side 2 on other side.<br>
                    2+3: 2 colour on one side 3 on other side.<br>
                    2+4: 2 colour on one side 4 on other side.<br>
                    3+3: 3 colour on one side 3 on other side.<br>
                    <br><br>
                    Note: if you want to print bitmap image then it will be 4 colour job and will print only one side (cyan, magenta, yellow and black)<br>
                    10Rs/Colour/Kg is the rate of printing

                    Block: it is like stamp to print your brand or image in shopping bags.<br>Life of one block is about 2 years, so after 2 years you will need a new blovk for your job if you want better results.<br>
                    <br>
                    Bag Colour:
                    You can also change the colour of bag like yellow, pink, green or any other. 10Rs/kg will be charge if you want to change colour from white to any other.And 20Rs/kg will be charge for golder and silver colour.<br>
                    <br>
                    Loop:
                    If you want extra handles (loops) in your basg then 3rs/piece of bag will be charge.<br>
                    <br>
                    Bag Size:
                    We can make any size of bag you want.<br>
                    Note: Width of bag is include guzets, that are inside layer in left and right sides of bags.
                    </p>
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
