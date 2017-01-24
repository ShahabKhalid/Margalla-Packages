<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `Ledgers` WHERE id = '".$id."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$total = 0;
$filename = "../excel/".$data['name'].'-ledger.csv';
$fp = fopen($filename, "w");
$seperator = "Particular,Bill #,Pay #,Date,Debit,Credit,Balance";

$seperator .= "\n";
fputs($fp, $seperator);
$qry = "SELECT * FROM `Ledgers_bill` WHERE ref = '".$id."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data = mysqli_fetch_array($run))
{
	$seperator = $data['particular'];
	if($data['bill'] == '1') {
		$seperator .= ",".$data['id'].",--";
	}
	else if($data['bill'] == '0') {
		$seperator .= ",--,".$data['id'];
	}
	$seperator .= ",".$data['date'];
	if($data['bill'] == '1') {
		$total += floatval($data['amount']);
		$seperator .= ",".$data['amount'].",--";
	}
	else if($data['bill'] == '0') {
		$total -= floatval($data['amount']);
		$seperator .= ",--,".$data['amount'];
	}
	$seperator .= ",".floatval($total);
	$seperator .= "\n";
	fputs($fp, $seperator);
}
$seperator = "Total,,,,,,".$total."\n";
fputs($fp, $seperator);
fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>
