<?php

function closingBalance($con,$month,$year)
{
if(intval($year) < 2017) {
	if(intval($month) == 12) return 0;
	else return 0;
}
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
$vanProfit = 0;
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

$run = mysqli_query($con,$qry);
$data = mysqli_fetch_array($run);
$recd = floatval($data['total']);
$recable = $custInvTot - $recd;

$qry = "SELECT c.* FROM `customers` c WHERE 1  order by `id`";

$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;

$total_Investment = 0;

while($row = mysqli_fetch_array($run))
{
    $id = $row['id'];


    $qry = "SELECT * FROM employee WHERE id = '".$row['saleRep']."'";

		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
    $saleRepName = "NONE";
    if(mysqli_num_rows($run2) > 0)
    {
        $emp = mysqli_fetch_array($run2);
        $saleRepName = $emp['name'];
    }

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


    $qry = "SELECT * FROM `invoice` WHERE `customer` = '".$row['id']."' order by no DESC LIMIT 1";

		$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
    $data = mysqli_fetch_array($run3);
    $inv_result = mysqli_num_rows($run3);
    $inv_date = $data['date'];
    $qry = "SELECT SUM(charges + weices * rate) as tot FROM invoice_detail WHERE ref = '".$data['no']."' GROUP BY ref";

		$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
    $data = mysqli_fetch_array($run3);
    $tot = $data['tot'];

    $qry = "SELECT * FROM `payments_recv` WHERE `customer` = '".$row['id']."' order by id DESC LIMIT 1";

		$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
    $data = mysqli_fetch_array($run3);
    $pay_result = mysqli_num_rows($run3);
    $pay_date = $data['rec_date'];
    $pay_amount = $data['amount'];



    $total_Investment += floatval($total_balance);
}


$TOTAL_PAYABLE = 0;

$qry = "SELECT b.* FROM `bill` b,`vendor` v  WHERE v.id = b.vendor and  v.name = 'BLOCK' and date <= '$year-$month-31'";

$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_balance = 0;
while($data = mysqli_fetch_array($run))
{
	$advance = 0;
	$qry = "SELECT * FROM `bill_detail` WHERE `ref` = '".$data['id']."'";

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
if(intval($month) > 1) { $closingBalance = $total_Investment + closingBalance($con,intval($month) - 1,$year) - $TOTAL_PAYABLE; }
else { $closingBalance = $total_Investment + closingBalance($con,12,intval($year) - 1) - $TOTAL_PAYABLE; }
return $closingBalance;
}
?>
