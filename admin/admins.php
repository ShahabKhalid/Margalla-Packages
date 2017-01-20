<?php 
require "../connection.php";
?>
<br><br>
<br><br>
<div id="new-account" class="container-fluid white-box">
	<h3>Add New Admin	</h3><br><br>
	<div class="row add_admin">
		<div class="col-md-2"></div>
		<div class="col-md-6">
		<form id="addadminform" action="do.php?action=addadmin&asdasdns7ad92u" method="POST">
			<div class="row"><div class="col-md-6"><label>First Name</label></div><div class="col-md-6"><input style="width:400px;" name="fname" /></div></div><br>
			<div class="row"><div class="col-md-6"><label>Second Name</label></div><div class="col-md-6"><input style="width:400px;" name="lname" /></div></div><br>
			<div class="row"><div class="col-md-6"><label>Email<br></label></div><div class="col-md-6"><input style="width:400px;" name="email" tyle="email" /></div></div><br>
			<div class="row"><div class="col-md-6"><label>Level<br></label></div><div class="col-md-6">
				<select name="level" style="width:400px;">
					<option value="Lead Admin">Lead Admin</option>
					<option value="Head Admin">Head Admin</option>
					<option value="Jr. Admin">Jr. Admin</option>
				</select></div></div><br>
			<div class="row"><div class="col-md-6"><label>Password<br></label></div><div class="col-md-6"><input style="width:400px;" name="pass" type="password" /></div></div><br>				
			</div>
		<div class="col-md-4"></div>
	</div>
	<br><br>
	<input type="hidden" name="ajax" value="yoo">
	<button name="update" onclick="sendAAForm()">Add</button><br>
	</form>
	<span id="not1"></span><br><br>
</div>
<div id="update-account" class="container-fluid white-box">
	<h3>Update Admin	</h3><br><br>
	<div class="row add_admin">
		<div class="col-md-2"></div>
		<div class="col-md-6">
		<form id="addadminform" action="do.php?action=updateadmin&asdasdns7ad92u" method="POST">
			<div class="row"><div class="col-md-6"><label>First Name</label></div><div class="col-md-6"><input style="width:400px;" name="up_fname" /></div></div><br>
			<div class="row"><div class="col-md-6"><label>Second Name</label></div><div class="col-md-6"><input style="width:400px;" name="up_lname" /></div></div><br>
			<div class="row"><div class="col-md-6"><label>Email<br></label></div><div class="col-md-6"><input style="width:400px;" name="up_email" tyle="email" /></div></div><br>
			<div class="row"><div class="col-md-6"><label>Level<br></label></div><div class="col-md-6">
				<select name="up_level" style="width:400px;">
					<option value="Lead Admin">Lead Admin</option>
					<option value="Head Admin">Head Admin</option>
					<option value="Jr. Admin">Jr. Admin</option>
				</select></div></div><br>
			<input name="up_oldpass" type="hidden" />		
			<div class="row"><div class="col-md-6"><label>Password<br></label></div><div class="col-md-6"><input style="width:400px;" name="up_pass" type="password" /></div></div><br>				
			</div>
		<div class="col-md-4"></div>
	</div>
	<br><br>
	<input type="hidden" name="ajax" value="yoo">
	<button name="update" onclick="sendUAForm()">Update</button><br><br>
	<button name="update" onclick="showNewAccForm()">New Account</button><br>
	</form>
	<span id="not1"></span><br><br>
</div>
<br><br><br>
<div class="container-fluid white-box">
	<h3>Current Admins</h3>
		    	<br>
	    	<div class="row" style="background-color:rgba(0,0,0,0.1);">
	    		<div class="col-sm-2">
	    		<h4>DP</h4>
	    		</div>
	    		<div class="col-sm-2"><h4>Name</h4>
	    		</div>
	    		<div class="col-sm-2"><h4>Level</h4>
	    		</div>
	    		<div class="col-sm-2"><h4>Email</h4>
	    		</div>
	    		<div class="col-sm-2"><h4>Update</h4>
	    		</div>
	    		<div class="col-sm-2"><h4>Delete</h4>
	    		</div>
	    	</div>
	<?php
	    $qry = "SELECT * FROM `admin`";             
	    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
	    $count = 1;
	    while($row = mysqli_fetch_array($run))
	    {
	    if($count % 2 == 0) echo '<div class="row" style="background-color:rgba(0,0,0,0.05);">';
	    else echo '<div class="row">';
	    ?>
	    	
	    		<div class="col-sm-2">
	    		<img id="pic_table" src="profile_pics/<?php echo $row['dp']; ?>" />
	    		</div>
	    		<div class="col-sm-2"><br>
	    		<p><?php echo $row['fname']." ".$row['lname']; ?></p>
	    		</div>
	    		<div class="col-sm-2"><br>
	    		<p><?php echo $row['title']; ?></p>
	    		</div>
	    		<div class="col-sm-2"><br>
	    		<p><?php echo $row['email']; ?></p>
	    		</div>
	    		<div class="col-sm-2"><br>
	    		<a href="javascript:void()" onclick="showUpdateAccForm()" title="update account">Update</a>	
	    		</div>
	    		<div class="col-sm-2"><br>
	    		<a href="do.php?action=deleteaccount&id=<?php echo $row['id']; ?>&asdasdns7ad92u" title="delete account">Delete</a>	
	    		</div>
	    	</div>
	    <?php
	    $count++;
	    }

	?>
	<br><br>
</div>
