<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `employee` WHERE `id` = '".$id."'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$row = mysqli_fetch_array($run);

$filename = "../excel/".$row['name'].'_profitSheet_'.date("Y-m-d").'.csv';
$fp = fopen($filename, "w");
$seperator = "Sr.,Inv #,Customer,Inv. Date,LD(Kg/p),LD Rate,LD Total,HD(Kg/p),HD Rate,HD Total,Total";

$seperator .= "\n";
fputs($fp, $seperator);

$qry = "SELECT i.*,c.name as cName FROM `invoice` i, customers c WHERE i.customer = c.id and i.`salerep` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;
$first = 0;
$total_profit = 0;
while($row = mysqli_fetch_array($run))
{
	$advance = intval($row['advance']);


	$qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$row['no']."' and idd.material like '%LD%' group by idd.id order by idd.id";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$ldCount = mysqli_num_rows($run2);
	$data2 = mysqli_fetch_array($run2);

	$qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$row['no']."' and idd.material like '%HD%' group by idd.id order by idd.id";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$hdCount = mysqli_num_rows($run2);
	$data3 = mysqli_fetch_array($run2);
	
	$total_profit += intval($row['ldRate']) * $ldCount * $data2['weices'];
	$total_profit += intval($row['hdRate']) * $hdCount * $data3['weices'];

	$seperator = $count++.",".$row['no'].",".$row['cName'].",".$row['date'].",".round($ldCount * $data2['weices'], 1, PHP_ROUND_HALF_UP).",".round( $row['ldRate'], 1, PHP_ROUND_HALF_UP).",".round( intval($row['ldRate']) * $ldCount * $data2['weices'], 1, PHP_ROUND_HALF_UP).",".round( $hdCount * $data3['weices'], 1, PHP_ROUND_HALF_UP).",".round( $row['hdRate'], 1, PHP_ROUND_HALF_UP).",".round( intval($row['hdRate']) * $hdCount * $data3['weices'], 1, PHP_ROUND_HALF_UP).",".round( intval($row['hdRate']) * $hdCount * $data3['weices'] + intval($row['ldRate']) * $ldCount * $data2['weices'], 1, PHP_ROUND_HALF_UP)."\n";
	fputs($fp, $seperator);
}
	$seperator = ",,,,,,,,,Total,".$total_profit."\n";
	fputs($fp, $seperator);
fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>