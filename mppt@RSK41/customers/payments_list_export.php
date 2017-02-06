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
	$numberOfDays = cal_days_in_month(CAL_JEWISH, $month, $year);
	$d = $d_day + $d_month * $numberOfDays + $d_year * 356 + $paymentTime;
	return $d;

}



$filename = "../excel/payments_list_".strtotime("now").'.csv';
$fp = fopen($filename, "w");
$seperator = "Sr.,Pay #,Ref #,Inv #,Customer,Receiver,Rec. Date,Entry Date,Amount";

$seperator .= "\n";
fputs($fp, $seperator);

$filter_qry = "";
if(isset($_GET['f_inv'])) $filter_qry .= "and `inv_no` LIKE '".$_GET['f_inv']."%'";
if(isset($_GET['f_ref'])) $filter_qry .= "and `ref_no` LIKE '".$_GET['f_ref']."%'";
if(isset($_GET['f_edate'])) $filter_qry .= "and `entry_date` LIKE '".$_GET['f_edate']."%'";
if(isset($_GET['f_customer'])) $filter_qry .= "and c.name LIKE '".$_GET['f_customer']."%'";
if(isset($_GET['f_receiver'])) $filter_qry .= "and e.name LIKE '".$_GET['f_receiver']."%'";
if(isset($_GET['f_rdate'])) $filter_qry .= "and `rec_date` LIKE '".$_GET['f_rdate']."%'";
if(isset($_GET['f_amount'])) $filter_qry .= "and `amount` LIKE '".$_GET['f_amount']."%'";

if(isset($_GET['f_paymentOnly']))
	$filter_qry .= "and `advance` = '0'";

if(isset($_GET['f_advanceOnly']))
	$filter_qry .= "and `advance` = '1'";


$qry = "SELECT p.id,p.ref_no,p.inv_no,p.advance,c.name as cname,e.name as ename,p.amount,p.rec_date,p.entry_date FROM `payments_recv` p,customers c,employee e WHERE p.customer = c.id and p.receiver = e.id ".$filter_qry." order by `".$_GET['orderBy']."` ";
//echo $qry;
$count = 0;
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data = mysqli_fetch_array($run))
{
$seperator = $count.",".$data['id'].",".$data['ref_no'].",".$data['inv_no'].",".$data['cname'].",".$data['ename'].",".$data['rec_date'].",".$data['entry_date'].",".$data['amount']."\n";
fputs($fp, $seperator);
}

fclose($fp);
echo "<h1 style='text-align:center;margin:0 auto;'>Your file is ready. You can download it from <a href='$filename'>here!</a></h1>";

?>
