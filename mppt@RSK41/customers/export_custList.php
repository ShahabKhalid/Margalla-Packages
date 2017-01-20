<?php
require "../123321.php";
$filename = "../excel/customer_list_".strtotime("now").'.csv';
$fp = fopen($filename, "w");
$seperator = "Serial,ID,Name,Contact,Last Invoice,Last Invoice Date,Last Payment,Last Payment Date,Balance";

$seperator .= "\n";
fputs($fp, $seperator);

$qry = "SELECT * FROM `customers` WHERE 1 order by `id`";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;
$first = 0;

while($row = mysqli_fetch_array($run))
{
	$id = $row['id'];
	



	$open_balance = $row['opening_balance'];
	$total_balance = $open_balance;
	$qry = "DELETE FROM `tmp` WHERE 1 ";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	$qry = "INSERT INTO tmp (id,ref,date,amount,type)
	SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.no,i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.no = idd.ref GROUP BY idd.ref ) sub, invoice i,customers c WHERE i.no = sub.no and c.id = i.customer and c.id = '".$id."'";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	$qry = "INSERT INTO tmp (id,ref,date,amount,type)
	SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv WHERE `customer` = '".$id."'";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	$qry = "SELECT * FROM tmp";
	$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$prev_inv_no = 0;
	while($data = mysqli_fetch_array($run3))
	{
	
	if($data['type'] == "invoice") {  if($prev_inv_no !== $data['id']) { $total_balance += floatval($data['amount']); } $prev_inv_no = $data['id']; } 
	else if($data['type'] == "pay") { $prev_inv_no = 0;  $total_balance -= floatval($data['amount']); } 

	}




	$qry = "SELECT * FROM `invoice` WHERE `customer` = '".$row['id']."'";
	$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data = mysqli_fetch_array($run3);
	$inv_result = mysqli_num_rows($run3);
	$inv_date = $data['date'];
	$qry = "SELECT SUM(charges + weices * rate) as tot FROM invoice_detail WHERE ref = '".$data['no']."' GROUP BY ref";
	$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data = mysqli_fetch_array($run3);
	$tot = $data['tot'];

	$qry = "SELECT * FROM `payments_recv` WHERE `customer` = '".$row['id']."'";
	$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data = mysqli_fetch_array($run3);
	$pay_result = mysqli_num_rows($run3);
	$pay_date = $data['rec_date'];
	$pay_amount = $data['amount'];
	
	$seperator = $count++.",".$row['id'].",".$row['name'].",".$row['contact'].",".$tot.",".$inv_date.",".$pay_amount.",".$pay_date.",".$total_balance."\n";
	fputs($fp, $seperator);
}
fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>