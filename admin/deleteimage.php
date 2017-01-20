<?php
require "../connection.php";
if(isset($_SESSION['admin']) && isset($_GET['id']))
{
$id = $_GET['id'];
$qry = "SELECT * FROM `gallery` WHERE `id` = '".$id."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row = mysqli_fetch_array($run);
echo "gallery/".$row['link'];
if(unlink("gallery/".$row['link']."")) {
	$qry = "DELETE FROM `gallery` WHERE `id` = '".$id."'";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	header('location: index.php?page=gallery'); }
else
	echo "Error deleting file.";
}
else header('location: index.php');
?>