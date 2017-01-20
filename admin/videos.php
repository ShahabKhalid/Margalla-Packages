<?php 
require "../connection.php";
?>
<script src="uploadvideo.js"></script>
<br><br>
<br><br>
<div class="container-fluid white-box">
	<h3>Upload Video</h3>
	<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
	<div id="image_preview"><img id="previewing" src="noimage.png" /></div>
	<hr id="line">
	<div id="selectImage">
	<label>Select Your Video</label><br/>
	<input style="position:relative;margin:0 auto;" type="file" name="file" id="file" required /><br>
	<input type="submit" value="Upload" class="submit" />
	</div>
	</form>
	<h4 id='loading' >Loading..</h4>
	<div id="message"></div><br><br>
</div><br><br><br><br>
<div class="container-fluid white-box">
	<h3>Current Images</h3>
		    	<br>
	    	<div class="row" style="background-color:rgba(0,0,0,0.1);">
	    		<div class="col-sm-3">
	    		<h4>Preview</h4>
	    		</div>
	    		<div class="col-sm-6"><h4>Path</h4>
	    		</div>
	    		<div class="col-sm-3"><h4>Delete</h4>
	    		</div>
	    	</div>
	<?php
	    $qry = "SELECT * FROM `videos`";             
	    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
	    $count = 1;
	    while($row = mysqli_fetch_array($run))
	    {
	    if($count % 2 == 0) echo '<div class="row" style="background-color:rgba(0,0,0,0.05);">';
	    else echo '<div class="row">';
	    ?>
	    	
	    		<div class="col-sm-3">
	    		<img id="pic_table" src="video-logo-1-256x225.png" />
	    		</div>
	    		<div class="col-sm-6"><br>
	    		<p>videos/<?php echo $row['link']; ?></p>
	    		</div>
	    		<div class="col-sm-3"><br>
	    		<a href="deletevideo.php?id=<?php echo $row['id']; ?>" title="delete video">Delete</a>
	    		</div>
	    	</div>
	    <?php
	    $count++;
	    }

	?>
	<br><br>
</div>