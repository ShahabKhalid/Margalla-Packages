<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `expAccounts` WHERE id = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);


$filename = "../excel/".$data['name']."_ledger_".strtotime("now").'.csv';
$fp = fopen($filename, "w");
$seperator = "Exp. #,Sub Account,Date,Description,Amount";

$seperator .= "\n";
fputs($fp, $seperator);

$qry = "SELECT e.*,a.name,a.parent,a.id as aid FROM `expences` e,`expAccounts`a WHERE e.acc_id = a.id and (a.parent = '$id' or a.id = '$id')";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total = 0;
while($data = mysqli_fetch_array($run))
{
$seperator = "EXP-".$id.",EXP-".$data['aid'].",".$data['date'].",".$data['description'].",".$data['amount']."\n";
fputs($fp, $seperator);
$total += floatval($data['amount']);
}
$seperator = ",,,Total,".$total."\n";
fputs($fp, $seperator);

fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>