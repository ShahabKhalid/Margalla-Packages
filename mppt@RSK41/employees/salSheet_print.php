<!DOCTYPE HTML>
<html>
<head>

<link rel="shortcut icon" type="image/png" href="../../favicon.png">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<style>
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm;  }
}
</style>
</head>
<body onload="init()" style="background-color:white;">
<br>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM employee WHERE id = $id";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$sal = $data['salary'];
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
<title>SALARY--<?php echo $data['name']."__".$monthT."-".$year; ?></title>
<div class="container" style="position:relative;left:-40px;">
<div>
<div class="row">
<div class="col-sm-8">
<img style="width:800px;" src="../customers/logo.jpg">
</div>
<div class="col-sm-4 text-right">
<span style="font-size:20px;"><b>ID: </b> MPE-<?php echo $id; ?></span></div>
</div>
</div>
<br><br>
<div class="row">
<div class="col-md-12">
<h1 class="text-center" >Employee Salary Sheet</h1>
</div>

</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 bold text-left" style="font-size:20px;"><label>Name</label></div>
	<div class="col-sm-3 text-left" style="font-size:20px;"><?php echo $data['name']; ?></div>
		<div class="col-sm-2 bold text-left" style="font-size:20px;"><label>ID</label></div>
	<div class="col-sm-3 text-left" style="font-size:20px;">MPC-<?php echo $data['id']; ?></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-2 bold text-left" style="font-size:20px;"><label>Designation</label></div>
	<div class="col-sm-3 text-left" style="font-size:20px;"><?php echo $data['designation']; ?></div>
	<div class="col-sm-2 bold text-left" style="font-size:20px;"><label>Contact</label></div>
	<div class="col-sm-3 text-left" style="font-size:20px;"><?php echo $data['contact']; ?></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 bold text-center" style="font-size:20px;"><label>For <?php echo $monthT."-".$year; ?></label></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row" style="width:95%;margin:0 auto;">
	<div class="col-sm-4 bold" style="border:1px solid black;"><label>Customer Name</label></div>
	<div class="col-sm-2 bold" style="border:1px solid black;"><label>LD Sale in kg</label></div>
	<div class="col-sm-2 bold" style="border:1px solid black;"><label>HD Sale in kg</label></div>
	<div class="col-sm-4 bold" style="border:1px solid black;"><label>Profit</label></div>
</div>
<?php
$qry = "SELECT * FROM customers c WHERE c.saleRep = $id order by c.name";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_profit = 0;

while($data = mysqli_fetch_array($run))
{
	$qry = "SELECT * FROM salaries WHERE employee = $id and year = '$year' and month ='$month'";
	$run1 = mysqli_query($con,$qry) or die(mysqli_error($con));
	if(mysqli_num_rows($run1) > 0)
	{
		$data1 = mysqli_fetch_array($run1);
		$sal = $data1['salary'];
	}
	else
	{
		$sal = 0;
	}
	$cust = $data['id'];
	$qry = "SELECT i.* FROM `invoice` i WHERE i.customer = $cust and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' order by i.no";
	$run1 = mysqli_query($con,$qry) or die(mysqli_error($con));

	$ldTotal = 0;
	$hdTotal = 0;
	$_profit = 0;


	$count = mysqli_num_rows($run1);


	while($data1 = mysqli_fetch_array($run1))
	{
		$advance = intval($data1['advance']);

		$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data1['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material = 'LD' group by i.id";
		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
		$ldCount = mysqli_num_rows($run2);
		$data2 = mysqli_fetch_array($run2);

		$qry = "SELECT i.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.no = idd.ref and idd.ref = '".$data1['no']."' and i.date >= '$year-$month-01' and i.date <= '$year-$month-31' and idd.material != 'LD' group by i.id";
		//echo $qry;
		$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
		$hdCount = mysqli_num_rows($run2);
		$data3 = mysqli_fetch_array($run2);
		$_profit += intval($data1['hdRate'])  * floatval($data3['weices']) + intval($data1['ldRate'])  * floatval($data2['weices']);
		$total_profit += intval($data1['hdRate'])  * floatval($data3['weices']) + intval($data1['ldRate'])  * floatval($data2['weices']);
		$ldTotal += floatval($data2['weices']);
		$hdTotal += floatval($data3['weices']);

	}
	if($count > 0)
	{
		?>
		<div class="row" style="width:95%;margin:0 auto;">
			<div class="col-sm-4" style="border:1px solid black;"><?php echo $data['name']; ?></div>
			<div class="col-sm-2" style="border:1px solid black;"><?php echo round($ldTotal, PHP_ROUND_HALF_UP); ?> Kg</div>
			<div class="col-sm-2" style="border:1px solid black;"><?php echo round($hdTotal, PHP_ROUND_HALF_UP); ?> Kg</div>
			<div class="col-sm-4" style="border:1px solid black;">Rs. <?php echo round($_profit, PHP_ROUND_HALF_UP); ?></div>
		</div>
		<?php
	}
}
?>
<br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-4 bold text-left" style="font-size:20px;">Total Profit</div>
	<div class="col-sm-6 text-left" style="font-size:20px;">Rs. <?php echo round($total_profit, PHP_ROUND_HALF_UP); ?></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-4 bold text-left" style="font-size:20px;">Tour Refreshment</div>
	<div class="col-sm-6 text-left" style="font-size:20px;">Rs. 0</div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-4 bold text-left" style="font-size:20px;">Salary</div>
	<div class="col-sm-6 text-left" style="font-size:20px;">Rs. <?php echo $sal; ?></div>
	<div class="col-sm-1"></div>
</div>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-4 bold text-left" style="font-size:20px;">Earned</div>
	<div class="col-sm-6 text-left" style="font-size:20px;">Rs. <?php echo round($sal + $total_profit, PHP_ROUND_HALF_UP);; ?></div>
	<div class="col-sm-1"></div>
</div><br><br><br>
<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10 bold" style="font-size:20px;">New Parties in <?php echo $monthT."-".$year; ?></div>
	<div class="col-sm-1"></div>
</div><br>
<div class="row" style="width:95%;margin:0 auto;">
	<div class="col-sm-4 bold" style="border:1px solid black;">Customer Name</div>
	<div class="col-sm-4 bold" style="border:1px solid black;">Date</div>
	<div class="col-sm-2 bold" style="border:1px solid black;">Weight in kg</div>
	<div class="col-sm-2 bold" style="border:1px solid black;">Invoice No.</div>
</div>
<?php
$qry = "SELECT * FROM customers c WHERE c.saleRep = $id and date >= '$year-$month-01' and date <= '$year-$month-31' order by date";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total_profit = 0;
$count = 0;
while($data = mysqli_fetch_array($run))
{
	?>
	<div class="row" style="width:95%;margin:0 auto;">
		<div class="col-sm-4 " style="border:1px solid black;"><?php echo $data['name']; ?></div>
		<div class="col-sm-4 " style="border:1px solid black;"><?php echo $data['date']; ?></div>
		<div class="col-sm-2 " style="border:1px solid black;">Weight in kg</div>
		<div class="col-sm-2 " style="border:1px solid black;">Invoice No.</div>
	</div>
	<?php
	$count++;
}
if($count < 1)
{
	?>
	<div class="row" style="width:95%;margin:0 auto;">
		<div class="col-sm-12 text-center" style="border:1px solid black;">No new parties this month.</div>
	</div>
	<?php
}
?>
<br><br>
<script>
function init() {
    window.print();
    window.close();
}
</script>
</body>
