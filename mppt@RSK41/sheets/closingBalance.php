<?php

function closingBalance($con,$month,$year)
{
if(intval($month) < 11 && intval($year) == 2016) return 0;
$qry = "SELECT SUM(idd.weices * idd.rate + idd.charges) as total FROM `invoice` i,`invoice_detail` idd WHERE i.no = idd.ref and i.date >= '$year-$month-01' and i.date <= '$year-$month-31'";

$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$custInvTot = floatval($data['total']);
$qry = "SELECT SUM(bd.weices * bd.rate) as total,v.name as name FROM `bill` b,`bill_detail` bd,`vendor` v WHERE v.id = b.vendor and b.ref = bd.ref and b.date >= '$year-$month-01' and b.date <= '$year-$month-31' and v.name = 'Factory' group by b.vendor ";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$fac_bill = 0;
if(mysqli_num_rows($run) > 0)
{
	$data = mysqli_fetch_array($run);
	$fac_bill = floatval($data['total']);
}

$qry = "SELECT SUM(bd.weices * bd.rate) as total,v.name as name FROM `bill` b,`bill_detail` bd,`vendor` v WHERE v.id = b.vendor and b.ref = bd.ref and b.date >= '$year-$month-01' and b.date <= '$year-$month-31' and v.name = 'Block' group by b.vendor ";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$block_bill = 0;
if(mysqli_num_rows($run) > 0)
{
	$data = mysqli_fetch_array($run);
	$block_bill = floatval($data['total']);
}


$qry = "SELECT a.name,SUM(e.amount) as total FROM `expAccounts` a, expences e WHERE a.id = e.acc_id  and e.date >= '$year-$month-01' and e.date <= '$year-$month-31' group by a.id";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$exp_tot = 0;
while($data = mysqli_fetch_array($run))
{
	$exp_tot += floatval($data['total']);
}

$qry = "SELECT * FROM `employee` WHERE 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$tot_sal_all = 0;
$count = 0;
while($data = mysqli_fetch_array($run))
{

	$id = $data['id'];
	$salary = $sal;

	$qry = "SELECT i.*,c.name as cName FROM `invoice` i, customers c WHERE i.customer = c.id and i.`salerep` = '$id' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' order by i.no";
	$run1 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total_profit = 0;
	$earned = 0;

	while($data1 = mysqli_fetch_array($run1))
	{
		$advance = intval($data['advance']);


		$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data1['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material = 'LD' group by i.id";
		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
		$ldCount = mysqli_num_rows($run2);
		$data2 = mysqli_fetch_array($run2);

		$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data1['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material != 'LD' group by i.id";
		//echo $qry;
		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
		$hdCount = mysqli_num_rows($run2);
		$data3 = mysqli_fetch_array($run2);
		$total_profit += intval($data1['hdRate'])  * floatval($data3['weices']) + intval($data1['ldRate'])  * floatval($data2['weices']);



	}

	$qry = "SELECT SUM(amount) as amount,SUM(duration) as dur FROM `advance` WHERE employee = '$id' and date > '$year-$month-01' and date < '$year-$month-31' group by employee";
	$run1 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$advance = 0;
	$dur = 0;
	$advdeduct = 0;
	if(mysqli_num_rows($run1) > 0)
	{
		$data1 = mysqli_fetch_array($run1);
		$advance = $data1['amount'];
		$dur = $data1['dur'];
		if(intval($advance) > 0)
		{
			if(intval($dur) > 0)
			{
				$advdeduct = intval($advance) / intval($dur);
			}
			else
			{
				$advdeduct = intval($advance);
			}
		}


	}

	$qry = "SELECT * FROM absents WHERE employee = '".$id."' and year = '".$year."' and month = '".$month."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$abs = 0;
	if(mysqli_num_rows($run2))
	{
		$data4 = mysqli_fetch_array($run2);
		$abs = $data4['absents'];
	}
	$sal = 0;
	//echo $month." - ".date("m"). " ".strcmp($month,date("m"));
	$sal = $data['salary'];
	$qry = "SELECT * FROM salaries WHERE employee = '".$id."' and year = '".date('Y')."' and month = '".$month."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));

	if(mysqli_num_rows($run2))
	{
		$data4 = mysqli_fetch_array($run2);
		$sal = $data4['salary'];
	}
	$bonus = 0;
	$bonusdesc = '--';
	$qry = "SELECT * FROM bonuses WHERE employee = '".$id."' and year = '".date('Y')."' and month = '".$month."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));

	if(mysqli_num_rows($run2))
	{
		$data4 = mysqli_fetch_array($run2);
		$bonus = intval($data4['bonus']);
		$bonusdesc = $data4['desc'];
	}

	$tot_sal += (intval($sal) + $total_profit + intval($bonus)) - $advdeduct - floatval(intval($sal) / 30 * intval($abs));
	$tot_sal_all += (intval($sal) + $total_profit + intval($bonus)) - $advdeduct - floatval(intval($sal) / 30 * intval($abs));
	$count++;
}

$profitEarned = $custInvTot - $fac_bill - $block_bill - $exp_tot - $tot_sal_all;


$qry = "SELECT vl.*,c.name as cName FROM `vanledger` vl,`customers` c WHERE vl.PartyName = c.id";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$Profit = 0;
$InHand = 0;
$totRent = 0;
$totToll = 0;
$totRec = 0;
$totLedger = 0;
$totPetrol = 0;
while($data2 = mysqli_fetch_array($run2))
{
	$InHand += floatval($data2['Rent']) - floatval($data2['Toll']) - floatval($data2['Petrol']) - floatval($data2['Ledger']);
	$vanProfit += floatval($data2['Rate']) - floatval($data2['Petrol']);
	$totRent += floatval($data2['Rate']);
	$totToll += floatval($data2['Toll']);
	$totRec += floatval($data2['Rent']);
	$totLedger += floatval($data2['Ledger']);
	$totPetrol += floatval($data2['Petrol']);
}

$finTotal = floatval($profitEarned) + floatval($vanProfit);

$qry = "SELECT SUM(amount) as total FROM `payments_recv` WHERE rec_date >= '$year-$month-01' and rec_date <= '$year-$month-31'";
//echo $qry;
$run = mysqli_query($con,$qry);
$data = mysqli_fetch_array($run);
$recd = floatval($data['total']);
$recable = $custInvTot - $recd;

$qry = "SELECT SUM(idd.weices * idd.rate + idd.charges) as total FROM `invoice` i,`invoice_detail` idd WHERE i.no = idd.ref and i.date <= '$year-$month-31'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$custInvTot_ALL = floatval($data['total']);

$qry = "SELECT SUM(amount) as total FROM `payments_recv` WHERE rec_date <= '$year-$month-31'";
//echo $qry;
$run = mysqli_query($con,$qry);
$data = mysqli_fetch_array($run);
$recd_ALL = floatval($data['total']);

$recable_ALL = $custInvTot_ALL - $recd_ALL;


$TOTAL_PAYABLE = 0;
$qry = "SELECT b.* FROM `bill` b,`vendor` v  WHERE v.id = b.vendor and  v.name = 'FACTORY' and date > '$year-$month-01' and date < '$year-$month-31'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_balance = 0;
while($data = mysqli_fetch_array($run))
{
	$advance = 0;
	$qry = "SELECT * FROM `bill_detail` WHERE `ref` = '".$data['ref']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
		$total += floatval($data2['weices']) * floatval($data2['rate']);
	}
	$balance = $advance - $total; $total_balance += $balance;
	$qry = "SELECT * FROM `payments_paid` WHERE `bill_no` = '".$data['id']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
		$balance += floatval($data2['amount']);
		$total_balance += floatval($data2['amount']);
	}
}
$total_balance = $total_balance * -1;
$TOTAL_PAYABLE += $total_balance;

$qry = "SELECT b.* FROM `bill` b,`vendor` v  WHERE v.id = b.vendor and  v.name = 'BLOCK' and date > '$year-$month-01' and date < '$year-$month-31'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_balance = 0;
while($data = mysqli_fetch_array($run))
{
	$advance = 0;
	$qry = "SELECT * FROM `bill_detail` WHERE `ref` = '".$data['ref']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
		$total += floatval($data2['weices']) * floatval($data2['rate']);
	}
	$balance = $advance - $total; $total_balance += $balance;
	$qry = "SELECT * FROM `payments_paid` WHERE `bill_no` = '".$data['id']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
		$balance += floatval($data2['amount']);
		$total_balance += floatval($data2['amount']);
	}
}
$total_balance = $total_balance * -1;
$TOTAL_PAYABLE += $total_balance;

$payableCount = 0;
$qry = "SELECT * FROM `monthPayable` WHERE `month` = '$month' and `year` = '$year'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data = mysqli_fetch_array($run))
{
	$payableCount++;
	$amount = $data['amount'];
	$TOTAL_PAYABLE += floatval($amount);
}
if(intval($month) > 1) { $closingBalance = $recable_ALL + closingBalance($con,intval($month) - 1,$year) - $TOTAL_PAYABLE; }
else { $closingBalance = $recable_ALL + closingBalance($con,12,intval($year) - 1) - $TOTAL_PAYABLE; }
return $closingBalance;
}
?>
