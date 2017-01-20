<div class="row">
<div class="col-md-1"></div>
<div class="col-md-5">
<div class="graph" id="graph1"></div>
<h3>Company Savings</h3>
</div>
<div class="col-md-5">
<div class="graph" id="graph2"></div>
<h3>Employee Profit</h3>
</div>
<div class="col-md-1"></div>
</div>
<div class="container addBox" style="width:95%;">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Employee Performance</h1>
</div>
<?php
require "../123321.php";
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

$id = $_GET['id'];
$qry = "SELECT * FROM `employee` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$salary = $data['salary'];
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ID: MPE-<?php echo $id; ?></span>
</div>
</div>
<input type="hidden" id="empid" value="<?php echo $id; ?>">
<div class="row" id="r1"><div class="col-md-2"><label>Name</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-3 text-left"><span style="font-size:18px;"><?php echo $data['contact']; ?></span></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Address</label></div><div class="col-md-10 text-left"><span style="font-size:18px;"><?php echo $data['address']; ?></span></div><div class="col-md-3"></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Month-Year</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $monthT."-".$year; ?></span></div><div class="col-md-3"><label>Month</label></div>
<div class="col-md-3 text-left">	
<select id="monthOpt" onchange="updatePSMonth()">
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

</div></div>
<br><br><br>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1 bold">Inv #</div>
	<div class="col-sm-1 bold">Date</div>
	<div class="col-sm-1 bold">LD(kg/p)</div>
	<div class="col-sm-1 bold">LD Rate</div>
	<div class="col-sm-1 bold">LD Total</div>
	<div class="col-sm-1 bold">HD(kg/p)</div>
	<div class="col-sm-1 bold">HD Rate</div>
	<div class="col-sm-1 bold">HD Tot</div>
	<div class="col-sm-2 bold">Total Profit</div>
	<div class="col-sm-2 bold">Invoice Total</div>
</div>
<?php
$qry = "SELECT i.*,SUM(idd.weices * idd.rate) as total FROM `invoice` i,`invoice_detail` idd WHERE i.salerep = '$id' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and i.no = idd.ref group by idd.ref";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_profit = 0;
$earned = 0;
while($data = mysqli_fetch_array($run))
{
$advance = intval($data['advance']);


$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material like '%LD%' group by i.id";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$ldCount = mysqli_num_rows($run2);
$data2 = mysqli_fetch_array($run2);

$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material not like '%LD%' group by i.id";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$hdCount = mysqli_num_rows($run2);
$data3 = mysqli_fetch_array($run2);
?>
<input type="hidden" id="empid" value="<?php echo $id; ?>">
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1 pointer" onclick="viewInvoice('<?php echo $data['id'] ?>')">INV-<?php echo $data['no'] ?></div>
	<div class="col-sm-1"><?php echo $data['date'] ?></div>
	<div class="col-sm-1"><?php echo round($data2['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"><?php echo $data['ldRate']; ?></div>
	<div class="col-sm-1">Rs. <?php $total_profit += intval($data['ldRate']) * $ldCount * $data2['weices'];echo round(floatval($data['ldRate']) * $data2['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"><?php echo round($data3['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"><?php echo $data['hdRate']; ?></div>
	<div class="col-sm-1">Rs. <?php $total_profit += intval($data['hdRate']) * $hdCount * $data3['weices'];echo round(floatval($data['hdRate']) * $data3['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-2">Rs. <?php echo round(floatval($data['hdRate']) * $data3['weices'] + intval($data['ldRate']) * $data2['weices'], 1, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-2">Rs. <?php echo round(floatval($data['total']), 1, PHP_ROUND_HALF_UP); $earned += intval($data['total']);?></div>
</div>
<?php
}
?>
<br>
<div class="row" style="padding-top:5px;border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-8"></div>
	<div class="col-sm-2 bold">Rs. <?php echo number_format($total_profit); ?></div>
	<div class="col-sm-2 bold">Rs. <?php echo number_format($earned); ?></div>
</div><br>
<div class="row" style="padding-top:5px;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-4 bold"></div>
	<div class="col-sm-2 bold text-left">Employee Salary</div>
	<div class="col-sm-2 bold text-left">Rs. <?php echo number_format($salary); ?></div>
	<div class="col-sm-4 bold"></div>
</div>
<div class="row" style="padding-top:5px;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-4 bold"></div>
	<div class="col-sm-2 bold text-left">Employee Profit</div>
	<div class="col-sm-2 bold text-left">Rs. <?php echo number_format($total_profit); ?></div>
	<div class="col-sm-4 bold"></div>
</div>
<div class="row" style="padding-top:5px;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-4 bold"></div>
	<div class="col-sm-2 bold text-left">Invoice's Total</div>
	<div class="col-sm-2 bold text-left">Rs. <?php echo number_format($earned); ?></div>
	<div class="col-sm-4 bold"></div>
</div>
<div class="row" style="padding-top:5px;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-4 bold"></div>
	<div class="col-sm-2 bold text-left">Saving</div>
	<div class="col-sm-2 bold text-left">Rs. <?php echo number_format($earned - $total_profit - $salary); ?></div>
	<div class="col-sm-4 bold"></div>
</div>
<br>
<!-- 	<a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a> -->
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function printView(id)
{
	window.open("customers/customer_ledger_print.php?id="+id);
}
function viewPayment(id)
{
    pageLoad("customers/payment_update.php?id="+id);
}

function viewInvoice(id)
{
	pageLoad("customers/invoice_print.php?id="+id);
}


function updatePSMonth()
{
	var month = $("#monthOpt").val();
	var id = $("#empid").val();
	//alert(month);
	pageLoad('employees/performance.php?year=2016&month='+month+'&id='+id);
}
</script>
<pre id="code" class="prettyprint linenums">
// Use Morris.Bar
Morris.Line({
  element: 'graph1',
  data: [
	<?php
	for($i = 1;$i <= 12;$i++)
	{
	  $save = 0;
	  $qry = "SELECT i.*,SUM(idd.weices * idd.rate) as total FROM `invoice` i,`invoice_detail` idd WHERE i.salerep = '$id' and i.date > '".date('Y-')."-".sprintf("%02d",$i)."-01' and i.date < '".date('Y-')."-".sprintf("%02d",($i+1))."-01' and i.no = idd.ref group by idd.ref";
	  $run = mysqli_query($con,$qry) or die(mysqli_error($con));
	  $total_profit = 0;
	  $earned = 0;
	  $month = "";
	  switch ($i) {
	    case 1:
	      $month = "Jan";
	      break;
	    case 2:
	      $month = "Feb";
	      break;
	    case 3:
	      $month = "March";
	      break;
	    case 4:
	      $month = "April";
	      break;
	    case 5:
	      $month = "May";
	      break;
	    case 6:
	      $month = "June";
	      break;
	    case 7:
	      $month = "July";
	      break;
	    case 8:
	      $month = "Aug";
	      break;
	    case 9:
	      $month = "Sep";
	      break;
	    case 10:
	      $month = "Oct";
	      break;
	    case 11:
	      $month = "Nov";
	      break;
	    case 12:
	      $month = "Dec";
	      break;

	    default:
	      $month = "Unknown";
	      break;
	  }
	  while($data = mysqli_fetch_array($run))
	  {
	  $advance = intval($data['advance']);


	  $qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material like '%LD%' group by idd.id order by idd.id";
	  $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	  $ldCount = mysqli_num_rows($run2);
	  $data2 = mysqli_fetch_array($run2);

	  $qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material like '%HD%' group by idd.id order by idd.id";
	  $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	  $hdCount = mysqli_num_rows($run2);
	  $data3 = mysqli_fetch_array($run2);
	  $total_profit += intval($data['ldRate']) * $ldCount * $data2['weices'];
	  $total_profit += intval($data['hdRate']) * $hdCount * $data3['weices'];
	  $earned += intval($data['total']);
	  }
	  $save = $earned - $total_profit - $salary;
	  ?>
	  {x: '<?php echo ($i).". ".$month." ".date('y'); ?>', y: <?php echo $save; ?>},<br>
	  <?php
	}
	?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Company Earn']
}).on('click', function(i, row){
  console.log(i, row);
});

Morris.Line({
  element: 'graph2',
  data: [
	<?php
	for($i = 1;$i <= 12;$i++)
	{
		$save = 0;
		$qry = "SELECT i.*,SUM(idd.weices * idd.rate) as total FROM `invoice` i,`invoice_detail` idd WHERE i.salerep = '$id' and i.date > '".date('Y-')."-".sprintf("%02d",$i)."-01' and i.date < '".date('Y-')."-".sprintf("%02d",($i+1))."-01' and i.no = idd.ref group by idd.ref";
		$run = mysqli_query($con,$qry) or die(mysqli_error($con));
		$total_profit = 0;
		$earned = 0;
		$month = "";
		switch ($i) {
			case 1:
				$month = "Jan";
				break;
			case 2:
				$month = "Feb";
				break;
			case 3:
				$month = "March";
				break;
			case 4:
				$month = "April";
				break;
			case 5:
				$month = "May";
				break;
			case 6:
				$month = "June";
				break;
			case 7:
				$month = "July";
				break;
			case 8:
				$month = "Aug";
				break;
			case 9:
				$month = "Sep";
				break;
			case 10:
				$month = "Oct";
				break;
			case 11:
				$month = "Nov";
				break;
			case 12:
				$month = "Dec";
				break;

			default:
				$month = "Unknown";
				break;
		}
		while($data = mysqli_fetch_array($run))
		{
		$advance = intval($data['advance']);


		$qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material like '%LD%' group by idd.id order by idd.id";
		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
		$ldCount = mysqli_num_rows($run2);
		$data2 = mysqli_fetch_array($run2);

		$qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data['no']."' and idd.material like '%HD%' group by idd.id order by idd.id";
		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
		$hdCount = mysqli_num_rows($run2);
		$data3 = mysqli_fetch_array($run2);
		$total_profit += intval($data['ldRate']) * $ldCount * $data2['weices'];
		$total_profit += intval($data['hdRate']) * $hdCount * $data3['weices'];
		$earned += intval($data['total']);
		}
		$save = $total_profit;
		?>
		{x: '<?php echo ($i).". ".$month." ".date('y'); ?>', y: <?php echo $save; ?>},<br>
		<?php
	}
	?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Profit']
}).on('click', function(i, row){
  console.log(i, row);
});

</pre>
<script src="../js/jquery.min.js"></script>
<script src="../js/raphael-min.js"></script>
<script src="../js/prettify.min.js"></script>
<script src="lib/morris.js"></script>
<script src="lib/example.js"></script>
<link rel="stylesheet" href="lib/example.css">
<link rel="stylesheet" href="../css/prettify.min.css">
<link rel="stylesheet" href="lib/morris.css">
