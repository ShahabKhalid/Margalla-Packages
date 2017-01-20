<?php
require "../connection.php";
if(isset($_POST['ajax']) || isset($_GET['asdasdns7ad92u']))
{


	if(isset($_GET['action']))
	{
		$action = $_GET['action'];

		switch ($action) {
				case 'login':
				if(isset($_POST['email']))
					{
						$qry = "SELECT * FROM `admin` WHERE `email` = '".htmlspecialchars($_POST['email'])."' and `password` = '".md5(htmlspecialchars($_POST['pass']))."'";
						//echo $qry;
						$run = mysqli_query($con,$qry) or die(mysqli_error($con));
						if(mysqli_num_rows($run) > 0)
						{
							$data = mysqli_fetch_array($run);
							$_SESSION['admin'] = $data['id'];
							echo "1";
						}
						else
						{
							echo "0";
						}
					}
					break;
				case 'update_wcmsg':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}
					$qry = "UPDATE `misc` SET `text` = '".htmlspecialchars($_POST['text'])."' WHERE `misc`.`name` = 'wc_msg';";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";

				case 'update_ceomsg':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}				
					$qry = "UPDATE `misc` SET `text` = '".htmlspecialchars($_POST['text'])."' WHERE `misc`.`name` = 'ceo_msg';";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";	
					break;
				case 'update_contactdetails':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}				
					$qry = "UPDATE `misc` SET `text` = '".htmlspecialchars($_POST['phone1'])."' WHERE `misc`.`name` = 'phone1';";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					$qry = "UPDATE `misc` SET `text` = '".htmlspecialchars($_POST['phone2'])."' WHERE `misc`.`name` = 'phone2';";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					$qry = "UPDATE `misc` SET `text` = '".htmlspecialchars($_POST['email'])."' WHERE `misc`.`name` = 'email';";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					$qry = "UPDATE `misc` SET `text` = '".htmlspecialchars($_POST['addr'])."' WHERE `misc`.`name` = 'address';";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					echo "1";	
					break;
				case 'addadmin':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}				
					$qry = "INSERT INTO `admin`(`id`, `fname`, `lname`, `title`, `email`, `password`, `dp`) VALUES (NULL,'".$_POST['fname']."','".$_POST['lname']."','".$_POST['level']."','".$_POST['email']."','".md5($_POST['pass'])."','male.png')";
					//echo $qry;
					mysqli_query($con,$qry) or die(mysqli_error($con));
					header("location: index.php?page=admins");	
					break;
				case 'deleteaccount':
					if(!isset($_SESSION['admin']))
					{
						header('location: index.php');
					}				
					$qry = "DELETE FROM `admin` WHERE `id` = '".$_GET['id']."'";
					mysqli_query($con,$qry) or die(mysqli_error($con));
					header("location: index.php?page=admins");
					break;
			}
	}
}
else
{

	echo "nononononon";
	header('location: 404.php');
}
?>