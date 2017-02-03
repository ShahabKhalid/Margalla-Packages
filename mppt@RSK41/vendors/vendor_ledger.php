<div class="container addBox" style="width:95%;">
<div class="inBox">
	<?php
	require "../123321.php";
	if(!isset($_GET['year']) && !isset($_GET['month']))
	{
		$year = '0';
		$month = '0';
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
	$id = $_GET['id'];
	$qry = "SELECT * FROM `vendor` WHERE `id` = '$id'";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data = mysqli_fetch_array($run);
	?>
		<br>
	<div class="row">
		<div class="col-sm-11 text-center">
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
	<input type="hidden" value="<?php echo $id; ?>" id="_id">
	<button onclick="updateLMonth()">Go</button>
	<button onclick="updateAllMonth()">Show All</button>
	</div>
	</div>
<div class="row">

<div class="col-md-10">

<h1 style="position:relative;left:100px;">Vendor Ledger / Statement</h1>
</div>

<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ID: VEND-<?php echo $id; ?></span>
</div>
</div>

<div class="row" id="r1"><div class="col-md-2"><label>Name</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-3 text-left"><span style="font-size:18px;"><?php echo $data['contact']; ?></span></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Address</label></div><div class="col-md-10 text-left"><span style="font-size:18px;"><?php echo $data['address']; ?></span></div><div class="col-md-3"></div></div>
<br><br><br>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Particular</div>
	<div class="col-sm-1">Bill #</div>
	<div class="col-sm-1">Bill. Date</div>
	<div class="col-sm-1">Pay. #</div>
	<div class="col-sm-1">Pay. Date</div>
	<div class="col-sm-2">Debit</div>
	<div class="col-sm-2">Credit</div>
	<div class="col-sm-2">Balance</div>
</div>
<?php
if(intval($year) == 0) $qry = "SELECT * FROM `bill` WHERE `vendor` = '$id' order by `date`	";
else $qry = "SELECT * FROM `bill` WHERE `vendor` = '$id' and date > '$year-$month-01' and date < '$year-$month-31' order by `date`	";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_balance = 0;
while($data = mysqli_fetch_array($run))
{
$advance = 0;
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Bill</div>
	<div class="col-sm-1 pointer" onclick="viewBill('<?php echo $data['id'] ?>')">BILL-<?php echo $data['id'] ?></div>
	<div class="col-sm-1"><?php echo $data['date'] ?></div>
	<div class="col-sm-1">--</div>
	<div class="col-sm-1">--</div>
	<div class="col-sm-2">--</div>
	<?php
	$qry = "SELECT * FROM `bill_detail` WHERE `ref` = '".$data['ref']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
		$total += floatval($data2['weices']) * floatval($data2['rate']);
	}
	?>
	<div class="col-sm-2"><?php echo number_format($total); ?></div>
	<div class="col-sm-2"><?php $balance = $advance - $total; $total_balance += $balance; echo number_format($balance); ?></div>
</div>
<?php
	$qry = "SELECT * FROM `payments_paid` WHERE `bill_no` = '".$data['id']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$total = 0;
	while($data2 = mysqli_fetch_array($run2))
	{
	?>
		<div class="row" style="width:95%;position:relative;margin:0 auto;">
			<div class="col-sm-2">Cash</div>
			<div class="col-sm-1 pointer" onclick="viewBill('<?php echo $data['bill_no'] ?>')">BILL-<?php echo $data2['bill_no']; ?></div>
			<div class="col-sm-1">--</div>
			<div class="col-sm-1 pointer" onclick="viewPayment('<?php echo $data2['id'] ?>')">PD-<?php echo $data2['id']; ?></div>
			<div class="col-sm-1"><?php echo $data2['paid_date']; ?></div>
			<div class="col-sm-2"><?php echo number_format($data2['amount']); ?></div>
			<div class="col-sm-2">--</div>
			<div class="col-sm-2"><?php $balance += floatval($data2['amount']); echo number_format($balance);
			$total_balance += floatval($data2['amount']); ?></div>
		</div>
	<?php
	}
}
?>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2">Total</div>
	<div class="col-sm-2">Rs. <?php echo number_format($total_balance); ?></div>
</div>
<a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function printView(id)
{
	window.open("vendors/vendor_ledger_print.php?id="+id);
}
function viewPayment(id)
{
    pageLoad("vendors/payment_update.php?id="+id);
}

function viewBill(id)
{
	pageLoad("vendors/bill_detail.php?id="+id);
}
function updateLMonth()
{
	var month = $("#monthOpt").val();
	var year = $("#yearOpt").val();
	var id = $("#_id").val();
	pageLoad('vendors/vendor_ledger.php?year='+year+'&month='+month+'&id='+id);
}

function updateAllMonth()
{
	var id = $("#_id").val();
	pageLoad('vendors/vendor_ledger.php?year=0&month=0&id='+id);
}
</script>
