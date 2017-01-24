<?php
include 'excel_reader.php';

function importLedger($file)
{
	//$con = mysqli_connect("localhost","root","raftaar","bashsofts_mppt_default_db") or die(mysqli_error());

	$con = mysqli_connect("localhost","bashsoft_shahab","AshaSha41","bashsoft_mppt_default_db");
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$data = new PhpExcelReader;
	$data->read($file);
	$fileName = basename($file,".xls");
	$qry = "INSERT INTO `Ledgers`(`id`, `name`) VALUES (NULL,'$fileName')";	
	mysqli_query($con,$qry) or die(mysqli_error($con));
	//echo $qry;

	$qry = "SELECT * FROM `Ledgers` WHERE `name`= '$fileName'";
	//echo $qry;

	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$dataX = mysqli_fetch_array($run);
	$refID =  $dataX['id'];
	//echo $refID;
	for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) 
	{
		$data->sheets[0]['cells'][$i][2] = str_replace("_","-",$data->sheets[0]['cells'][$i][2]);
		if(intval($data->sheets[0]['cells'][$i][3]) > 0)
		{
        	$qry = "INSERT INTO `Ledgers_bill`(`id`, `ref`, `amount`, `date`, `bill`, `particular`) VALUES (NULL,'$refID','".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][2]."','1','".$data->sheets[0]['cells'][$i][1]."')";
    	}
    	else
    	{
    		$qry = "INSERT INTO `Ledgers_bill`(`id`, `ref`, `amount`, `date`, `bill`, `particular`) VALUES (NULL,'$refID','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][2]."','0','".$data->sheets[0]['cells'][$i][1]."')";
    	}
    	//echo $qry;
		mysqli_query($con,$qry) or die(mysqli_error($con));
		echo "<br>Ledger Added!";
		//echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
	}	

}
?>