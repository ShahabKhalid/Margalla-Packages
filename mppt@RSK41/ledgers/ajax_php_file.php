<?php

include '../excel_reader/ledgerreader.php'; 
$validextensions = array("xls");
$temporary = explode(".", $_FILES["file"]["name"]);
$file_extension = end($temporary);
if (in_array($file_extension, $validextensions))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
	}
	else
	{
		if (file_exists("../excel/ledgers/" . $_FILES["file"]["name"])) 
		{
			echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
		}
		else
		{
			$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
			$targetPath = "../excel/ledgers/".$_FILES['file']['name']; // Target path where file is to be stored
			move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
			echo "<span id='success'>Ledger Uploaded Successfully...!!</span><br/>";
			echo "<br/><b>Path:</b> " . $_FILES["file"]["name"] . "<br>";
			echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
			echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			echo "<b>Temp file:</b> " . $_FILES["file"]["tmp_name"] . "<br>";
			importLedger("../excel/ledgers/".$_FILES["file"]["name"]);
		}
	}
}
else
{
	echo "<span id='invalid'>***Invalid file Size or Type***<span>";
}
?>

