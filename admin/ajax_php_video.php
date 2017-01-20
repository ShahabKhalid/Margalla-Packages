<?php
require "../connection.php";
if(isset($_FILES["file"]["type"]))
{
$validextensions = array("mp4","flv");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if ((($_FILES["file"]["type"] == "video/mp4") || ($_FILES["file"]["type"] == "video/flv"))
 && ($_FILES["file"]["size"] < 10000000000)//Approx. 10Mb files can be uploaded.
&& in_array($file_extension, $validextensions)) {
if ($_FILES["file"]["error"] > 0)
{
echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
}
else
{
if (file_exists("videos/" . $_FILES["file"]["name"])) {
echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
}
else
{
$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
$targetPath = "videos/".$_FILES['file']['name']; // Target path where file is to be stored
move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
$qry = "INSERT INTO `videos` (`id`, `link`) VALUES (NULL, '".$_FILES['file']['name']."');";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
echo "<span id='success'>Video Uploaded Successfully...!!</span><br/>";
echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
}
}
}
else
{
echo "<span id='invalid'>***Invalid file Size or Type***<span>";
}
}
?>

