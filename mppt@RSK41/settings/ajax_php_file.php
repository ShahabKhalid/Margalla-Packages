<?php

//$validextensions = array("xls");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
//if (in_array($file_extension, $validextensions))
//{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
	}
	else
	{
		if (file_exists("../uploads/" . $_FILES["file"]["name"])) 
		{
			echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
		}
		else
		{
			$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
			$targetPath = "../uploads/".$_FILES['file']['name']; // Target path where file is to be stored
			move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
			echo "<span id='success'>File Uploaded Successfully...!!</span><br/>";
			echo "<br/><b>Path:</b> " . $_FILES["file"]["name"] . "<br>";
			echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
			echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
		}
	}
/*}
else
{
	echo "<span id='invalid'>***Invalid file Size or Type***<span>";
}*/
?>

