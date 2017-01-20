<?php
require "../connection.php";
if(isset($_SESSION['admin']) && isset($_GET['id']))
{
$id = $_GET['id'];
$qry = "SELECT * FROM `videos` WHERE `id` = '".$id."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row = mysqli_fetch_array($run);
echo "videos/".$row['link'];
if(unlink("videos/".$row['link']."")) {
	$qry = "DELETE FROM `videos` WHERE `id` = '".$id."'";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	header('location: index.php?page=videos'); }
else
	echo "Error deleting file.";
}
else header('location: index.php');
?>