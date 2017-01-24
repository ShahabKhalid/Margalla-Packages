<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `customers` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$open_balance = $data['opening_balance'];
$filename = "../excel/".$data['name'].'-ledger.csv';
$fp = fopen($filename, "w");
$seperator = "Particular,Inv. #,Inv. Date,Pay #,Pay Date,Debit,Credit,Balance";

$seperator .= "\n";
fputs($fp, $seperator);

$seperator = "Opening Balance,,,,,,,".$open_balance."\n";
fputs($fp, $seperator);
$qry = "DELETE FROM `tmp` WHERE 1 ";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
						SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.no,i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.no = idd.ref GROUP BY idd.ref ) sub, invoice i,customers c WHERE i.no = sub.no and c.id = i.customer and c.id = '".$id."'";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv WHERE `customer` = '".$id."'";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "SELECT * FROM tmp order by date;";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$balanace = 0;
$total_balance = $open_balance;
$prev_inv_no = 0;
$total_of_inv = 0;
$total_of_pay = 0;
while($data = mysqli_fetch_array($run))
{
	if($prev_inv_no !== $data['id'])
	{
		$seperator = "";
		if($data['type'] == "invoice")
		{
			$total_balance += floatval($data['amount']);
			$total_of_inv += floatval($data['amount']);
			$seperator = "Bill,INV-".$data['id'].",".$data['date'].",---,----,".floatval($data['amount']).",---,".$total_balance."\n";

		}
		else
		{
			$total_balance -= floatval($data['amount']);
		 	$total_of_pay += floatval($data['amount']);
		 	$seperator = "Cash,---,---,PY-".$data['id'].",".$data['date'].",---,".floatval($data['amount']).",".$total_balance."\n";

		}
		fputs($fp, $seperator);
		if($data['type'] == "invoice") $prev_inv_no = $data['id'];
		else $prev_inv_no = 0;
	}
}
$seperator = "Total,,,,,".$total_of_inv.",".$total_of_pay.",".$total_balance."\n";
fputs($fp, $seperator);
fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>
