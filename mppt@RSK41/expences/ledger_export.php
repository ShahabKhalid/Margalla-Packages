<?php
require "../123321.php";



$filename = "../excel/expence_ledger_".strtotime("now").'.csv';
$fp = fopen($filename, "w");
$seperator = "Particular,Exp. #,Account,Date,Description,Debit,Credit,Balance";

$seperator .= "\n";
fputs($fp, $seperator);

$qry = "SELECT e.* FROM `expences` e WHERE 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total = 0;
while($data = mysqli_fetch_array($run))
{
	if($data['acc_id'] != '-1')
	{
		$qry = "SELECT name FROM `expAccounts` a WHERE a.id = '".$data['acc_id']."'";
		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
		$data2 = mysqli_fetch_array($run2);
	}
	if($data['acc_id'] == '-1')
	{
		$total += intval($data['amount']);
		$seperator = "Petty Cash,PC-".$data['id'].",---,".$data['date'].",".$data['description'].",".$data['amount'].",---,".$total."\n";
	}
	else 
	{
		$total -= intval($data['amount']);
		$seperator = "Expence,EXP-".$data['id'].",".$data2['name'].",".$data['date'].",".$data['description'].",---,".$data['amount'].",".$total."\n";
	}
	fputs($fp, $seperator);
}	

fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>