<?php
require "../123321.php";

function getDays($date,$paymentTime)
{
	list($year, $month, $day) = explode('-', $date);
	$currentdate = date("Y-m-d");
	list($c_year, $c_month, $c_day) = explode('-', $currentdate);
	$d_year = intval($year) - intval($c_year);
	$d_month = intval($month) - intval($c_month);
	$d_day = intval($day) - intval($c_day);

	$d = $d_day + $d_month * 30 + $d_year * 356 + $paymentTime;
	return $d;

}



$filename = "../excel/invoice_list_".strtotime("now").'.csv';
$fp = fopen($filename, "w");
$seperator = "Sr.,Date,Inv. #,Ref. #,Party Name,Sales Rep.,Weight / Pieces,Block Charges,0. Charge,Total,Advance,Balance,Payment(s)";

$seperator .= "\n";
fputs($fp, $seperator);

$filter_qry = "";
$overTime = 0;
$todaysInvoice = 0;
$filterCustomer = 0;
$filterSaleRep = 0;
if(isset($_GET['f_inv'])) $filter_qry .= "and `no` LIKE '".$_GET['f_inv']."%'";
if(isset($_GET['f_ref'])) $filter_qry .= "and `id` LIKE '".$_GET['f_ref']."%'";
if(isset($_GET['f_date'])) $filter_qry .= "and `date` LIKE '".$_GET['f_date']."%'";
if(isset($_GET['f_overTime'])) $overTime = 1;
if(isset($_GET['f_todaysInvoice'])) $todaysInvoice = 1;
if(isset($_GET['f_customer'])) $filterCustomer = 1;
if(isset($_GET['f_salerep'])) $filterSaleRep = 1;

$qry = "SELECT i.*,c.name as cName,e.name eName,c.paymentMethod as payMethod FROM `invoice` i,`customers` c,`employee` e WHERE i.customer = c.id and i.salerep = e.id ".$filter_qry." order by `".$_GET['orderBy']."` ";

$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;

while($row = mysqli_fetch_array($run))
{
	$dayDif = getDays($row['date'],$row['paymentTime']);



	$qry2 = "SELECT * FROM `invoice_detail` WHERE `ref` = '".$row['no']."'";
	$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
	$total_weight = 0;
	$total_rate = 0;
	$total_blockCharges = 0;
	$total_otherCharges = 0;
	$total_ = 0;
	while($row2 = mysqli_fetch_array($run2))
	{
		$total_weight += floatval($row2['weices']);
		$total_rate += floatval($row2['rate']);
		if($row2['exp_name'] == "Block") {
			$total_blockCharges += floatval($row2['charges']);
		}
		else {
			$total_otherCharges += floatval($row2['charges']);
		}
		$total_here = floatval($row2['weices']) * floatval($row2['rate']) + floatval($row2['charges']);
		$total_ += $total_here;
	}
	$advance = 0;
	$qry2 = "SELECT * FROM `payments_recv` WHERE `inv_no` = '".$row['no']."'";
	$run2 = mysqli_query($con,$qry2) or die(mysqli_error($con));
	$total_amount = 0;
	while($row2 = mysqli_fetch_array($run2))
	{
		if(intval($row2['advance']) == 0 )$total_amount += floatval($row2['amount']);
		else $advance += floatval($row2['amount']);
	}


	if($filterCustomer == 1)
	{
		$pos = strpos($row['cName'], $_GET['f_customer']);
		if($pos === false)
			continue;
	}

	if($row['paymentTime'] > '0' && $dayDif < 0 && $total_ - $advance - $total_amount > 0 && intval($row['payMethod']) == 0)
	{
		$color = "rgba(255,0,0,0.5);font-weight:bold";
	}


	if($total_ - $advance - $total_amount == 0)
	{
		$color = "rgba(0,255,0,0.1);color:green";
	}
	if(intval($row['payMethod']) == 1)
	{
		$color = "rgba(0,0,255,0.1);color:rgba(0,0,255,0.7)";
	}
	if($overTime == 1)
		if(!($dayDif < 0 && $total_ - $advance - $total_amount > 0 && floatval($row['payMethod']) == 0))
			continue;

	if($todaysInvoice == 1)
		if($row['date'] != date("d-m-Y"))
			continue;



	if(isset($_GET['f_b2b']))
		if(intval($row['payMethod']) == 0)
			continue;


	if($filterSaleRep == 1)
	{
		$pos = strpos($row['eName'], $_GET['f_salerep']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_weight']))
	{
		$pos = strpos($total_weight, $_GET['f_weight']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_blockCharge']))
	{
		$pos = strpos($total_blockCharges, $_GET['f_blockCharge']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_otherCharge']))
	{
		$pos = strpos($total_otherCharges, $_GET['f_otherCharge']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_total']))
	{
		$pos = strpos($total_, $_GET['f_total']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_advance']))
	{
		$pos = strpos($advance, $_GET['f_advance']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_balance']))
	{
		$balance = $total_ - $advance - $total_amount;
		$pos = strpos($balance, $_GET['f_balance']);
		if($pos === false)
			continue;
	}

	if(isset($_GET['f_payment']))
	{
		$pos = strpos($total_amount, $_GET['f_payment']);
		if($pos === false)
			continue;
	}


	if($row['date'] <= "2016-09-19" && $row['paymentTime'] < '1')
	{
		$color = "rgba(255,255,0,0.2);font-weight:bold";
	}

	$seperator = "".$count.",".$row['date'];
	if($row['paymentTime'] > '0' && $dayDif < 0 && $total_ - $advance - $total_amount > 0 && intval($row['payMethod']) == 0) 
	{ 
		$seperator .= "(".($dayDif*-1)."),";
	}
	else
	{
		$seperator .= ",";
	}

	$seperator .= $row['no'].",".$row['id'].",".$row['cName'].",".$row['eName'].",".$total_weight.",".$total_blockCharges.",".$total_otherCharges.",".$total_.",".$advance.",".($total_ - $advance - $total_amount).",".$total_amount."\n";
	$count++;
	fputs($fp, $seperator);
}

fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>