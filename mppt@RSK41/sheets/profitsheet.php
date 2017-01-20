<br><br>
<div class="container addBox" style="width:95%">
<div class="inBox">
<?php
require "../123321.php";
require "closingBalance.php";
if(!isset($_GET['year']) && !isset($_GET['month']))
{
$year = date("Y");
$month = date("m");
}
else
{
$year = $_GET['year'];
$month = $_GET['month'];
}
		switch ($month) {
      case 1:
        $monthT = "Jan";
        break;
      case 2:
        $monthT = "Feb";
        break;
      case 3:
        $monthT = "March";
        break;
      case 4:
        $monthT = "April";
        break;
      case 5:
        $monthT = "May";
        break;
      case 6:
        $monthT = "June";
        break;
      case 7:
        $monthT = "July";
        break;
      case 8:
        $monthT = "Aug";
        break;
      case 9:
        $monthT = "Sep";
        break;
      case 10:
        $monthT = "Oct";
        break;
      case 11:
        $monthT = "Nov";
        break;
      case 12:
        $monthT = "Dec";
        break;

      default:
        $monthT = "Unknown";
        break;
    }
?>
<br><br>
<div class="row" style="font-size:16px;">
<div class="col-sm-3"></div>
<div class="col-sm-2 text-right">
</div>
<div class="col-sm-4 text-left">
	<select id="yearOpt">
		<option value="2016" <?php if(intval($year) == 2016) echo "selected"; ?>>2016</option>
		<option value="2017" <?php if(intval($year) == 2017) echo "selected"; ?>>2017</option>
	</select>
<select id="monthOpt">
		<option value="1" <?php if(intval($month) == 1) echo "selected"; ?>>Jan</option>
		<option value="2" <?php if(intval($month) == 2) echo "selected"; ?>>Feb</option>
		<option value="3" <?php if(intval($month) == 3) echo "selected"; ?>>March</option>
		<option value="4" <?php if(intval($month) == 4) echo "selected"; ?>>April</option>
		<option value="5" <?php if(intval($month) == 5) echo "selected"; ?>>May</option>
		<option value="6" <?php if(intval($month) == 6) echo "selected"; ?>>June</option>
		<option value="7" <?php if(intval($month) == 7) echo "selected"; ?>>July</option>
		<option value="8" <?php if(intval($month) == 8) echo "selected"; ?>>Aug</option>
		<option value="9" <?php if(intval($month) == 9) echo "selected"; ?>>Sep</option>
		<option value="10" <?php if(intval($month) == 10) echo "selected"; ?>>Oct</option>
		<option value="11" <?php if(intval($month) == 11) echo "selected"; ?>>Nov</option>
		<option value="12" <?php if(intval($month) == 12) echo "selected"; ?>>Dec</option>
	</select>
	<button onclick="updatePSMonth()">Go</button>
</div>
<div class="col-sm-3"></div>
</div>
<h1>Profit Sheet <?php echo "(".$monthT."-".$year.")"; ?></h1>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:24px;font-weight:bold;">OPENING BALANCE</span></div>
	<div class="col-sm-5" style="border:1px solid black;"><span style="font-size:24px;font-weight:bold;"><?php if(intval($month) > 1) { $openBal = closingBalance(intval($month) - 1,$year); }
			else { $openBal = closingBalance(12,intval($year) - 1); } echo "Rs. ".number_format($openBal);?></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 text-left" style="border:1px solid black;"><span style="font-size:24px;font-weight:bold;">SALES</span></div>
	<div class="col-sm-1"></div>
</div>

<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;">Customer's Invoice</span></div>
	<?php 
	$qry = "SELECT SUM(idd.weices * idd.rate + idd.charges) as total FROM `invoice` i,`invoice_detail` idd WHERE i.no = idd.ref and i.date >= '$year-$month-01' and i.date <= '$year-$month-31'";
	//echo $qry;
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data = mysqli_fetch_array($run);
	$custInvTot = floatval($data['total']);
	?>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;"><?php echo "Rs. ".number_format(round($custInvTot,2, PHP_ROUND_HALF_EVEN)); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 text-left" style="border:1px solid black;"><span style="font-size:24px;font-weight:bold;">PURCHASES</span></div>
	<div class="col-sm-1"></div>
</div>
<?php 
$qry = "SELECT SUM(bd.weices * bd.rate) as total,v.name as name FROM `bill` b,`bill_detail` bd,`vendor` v WHERE v.id = b.vendor and b.ref = bd.ref and b.date >= '$year-$month-01' and b.date <= '$year-$month-31' and v.name = 'Factory' group by b.vendor ";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$fac_bill = 0;
	if(mysqli_num_rows($run) > 0)
	{
		$data = mysqli_fetch_array($run);
		$fac_bill = floatval($data['total']);
	}
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;">Factory Bills</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;"><?php echo "Rs. ".number_format($fac_bill); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<?php 
$qry = "SELECT SUM(bd.weices * bd.rate) as total,v.name as name FROM `bill` b,`bill_detail` bd,`vendor` v WHERE v.id = b.vendor and b.ref = bd.ref and b.date >= '$year-$month-01' and b.date <= '$year-$month-31' and v.name = 'Block' group by b.vendor ";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$block_bill = 0;
	if(mysqli_num_rows($run) > 0)
	{
		$data = mysqli_fetch_array($run);
		$block_bill = floatval($data['total']);
	}
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;">Block Bills</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;"><?php echo "Rs. ".number_format($block_bill); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 text-left" style="border:1px solid black;"><span style="font-size:24px;font-weight:bold;">EXPENCES</span></div>
	<div class="col-sm-1"></div>
</div>
<?php 
$qry = "SELECT a.name,SUM(e.amount) as total FROM `expAccounts` a, expences e WHERE a.id = e.acc_id  and e.date >= '$year-$month-01' and e.date <= '$year-$month-31' group by a.id";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$exp_tot = 0;
while($data = mysqli_fetch_array($run))
{
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;"><?php  echo "Rs.". number_format(floatval($data['total'])); $exp_tot += floatval($data['total']); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<?php 
}
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Total Expence</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Rs. <?php echo number_format($exp_tot); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<?php
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
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Salaries</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;">Rs. <?php echo number_format($tot_sal_all); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<?php 
$profitEarned = $custInvTot - $fac_bill - $block_bill - $exp_tot - $tot_sal_all;
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Profit Earned</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;">Rs. <?php echo number_format($profitEarned); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<div id="tableDIV">
<?php
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
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Van Profit</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;">Rs. <?php echo number_format($vanProfit); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Total</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Rs. <?php $finTotal = floatval($profitEarned) + floatval($vanProfit); echo number_format($finTotal);?></span></div>
	<div class="col-sm-1"></div>
</div>
<?php
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
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-2 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Received Payments</span></div>
	<div class="col-sm-3 text-center" style="border:1px solid black;"><span style="font-size:18px;">Rs. <?php echo number_format($recd);  ?></span></div>
	<div class="col-sm-2 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Receivable</span></div>
	<div class="col-sm-3 text-center" style="border:1px solid black;"><span style="font-size:18px;">Rs. <?php echo number_format($recable); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Market Investment</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Rs. <?php echo number_format($recable_ALL);?></span></div>
	<div class="col-sm-1"></div>
</div>
<h3>Payables<h3>
<?php
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
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Factory</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Rs. <?php echo number_format($total_balance); $TOTAL_PAYABLE += $total_balance; ?></span></div>
	<div class="col-sm-1"></div>
</div>
<?php
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
?>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Block</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Rs. <?php echo number_format($total_balance); $TOTAL_PAYABLE += $total_balance; ?></span></div>
	<div class="col-sm-1"></div>
</div>
<div id="payableArea">
	<?php 
	$payableCount = 0;
	$qry = "SELECT * FROM `monthPayable` WHERE `month` = '$month' and `year` = '$year'";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($data = mysqli_fetch_array($run))
	{
		$payableCount++;
		$name = $data['name'];
		$amount = $data['amount'];
		$TOTAL_PAYABLE += floatval($amount);
	?>
	<div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;"><input type='text' value='<?php echo $name; ?>' id='otherspayable<?php echo $payableCount; ?>' placeholder="Others payable name" style="width:100%;position:relative;top:-1px;" /></span></div>
		<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;"><input style="text-align:center;" type='text' value='<?php echo $amount; ?>' id='otherspayable<?php echo $payableCount; ?>Amount' placeholder="Others payable amount" style="width:100%;position:relative;top:-1px;" /></span></div>
		<div class="col-sm-1"></div>
	</div>
	<?php	
	}
	if($payableCount == 0) { $payableCount = 1;
	?>
	<div class="row">
		<div class="col-sm-1" ></div>
		<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;"><input type='text' id='otherspayable<?php echo $payableCount; ?>' placeholder="Others payable name" style="width:100%;position:relative;top:-1px;" /></span></div>
		<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;"><input style="text-align:center;" type='text' id='otherspayable<?php echo $payableCount; ?>Amount' placeholder="Others payable amount" style="width:100%;position:relative;top:-1px;" /></span></div>
		<div class="col-sm-1"></div>
	</div>
	<?php } ?>
	<input type="hidden" value="<?php echo $payableCount; ?>" id="payableCount"/>
</div>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-10 text-center"><span style="font-size:18px;font-weight:bold;"><a href="javascript:void()" onclick="addPayable();">Add Payable</a></span></div>
	<div class="col-sm-1"></div>
</div>
<br>
<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Total Payables</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;"><?php echo number_format($TOTAL_PAYABLE); ?></span></div>
	<div class="col-sm-1"></div>
</div>

<div class="row">
	<div class="col-sm-1" ></div>
	<div class="col-sm-5 text-left" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;">Closing Balance</span></div>
	<div class="col-sm-5 text-center" style="border:1px solid black;"><span style="font-size:18px;font-weight:bold;"><?php echo number_format($recable_ALL + $TOTAL_PAYABLE + $openBal); ?></span></div>
	<div class="col-sm-1"></div>
</div>
<br>
<button onclick="savePayable()">Save All</button><br><br>
<span id="not"></span>
<br>
</div>
</div>
<br><br><br><br>
<br><br><br><br>
<br><br><br><br>
<script type="text/javascript">
var currentPayable = $("#payableCount").val();
function updatePSMonth()
{
	//alert('123');
	var month = $("#monthOpt").val();
	var year = $("#yearOpt").val();
	//alert(month);
	pageLoad('sheets/profitsheet.php?year='+year+'&month='+month);
}

function savePayable()
{
	var month = $("#monthOpt").val();
	var year = $("#yearOpt").val();
	var postStr = "year="+year+"&month="+month+"&dataCount="+currentPayable;
	
	var jsonStr = "";
	for (var i = 1; i <=  currentPayable; i++) {
		var name = $("#otherspayable"+i).val()
		var amount = $("#otherspayable"+i+"Amount").val()
		jsonStr =  '{"name":"'+name+'","amount":"'+amount+'"}'
		postStr += "&data_"+i+"="+jsonStr;
	}
	//alert(postStr);
	
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        //alert(xhttp.responseText);
        if(xhttp.responseText === "0")
        {
            $("#not").hide();
            $("#not").text("Error while adding!");
            $("#not").css({color:'red'});
            $("#not").slideDown();
        }
        else
        {
            $("#not").slideUp();
            $("#not").text("Payabales Updated!");
            $("#not").css({color:'green'});
            $("#not").slideDown();
        }
    }};

    xhttp.open("POST", "do.php?action=addpayable", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(postStr+"&ajax");
}



function addPayable()
{
	currentPayable++;
	$("#payableArea").append('<div class="row">\
		<div class="col-sm-1" ></div>\
		<div class="col-sm-5 text-left" style="border:1px solid black;"><span\ style="font-size:18px;font-weight:bold;"><input type="text" id="otherspayable'+currentPayable+'"\ placeholder="Others payable name" style="width:100%;position:relative;top:-1px;" /></span></div>\
		<div class="col-sm-5 text-center" style="border:1px solid black;"><span\ style="font-size:18px;font-weight:bold;"><input type="text" id="otherspayable'+currentPayable+'Amount"\ placeholder="Others payable amount" style="width:100%;position:relative;top:-1px;" /></span></div>\
		<div class="col-sm-1"></div>\
	</div>')
}
</script>
