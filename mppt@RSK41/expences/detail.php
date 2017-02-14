<div class="container addBox" style="width:98%;">
<div class="inBox">
	<?php
	require "../123321.php";
	$id = $_GET['id'];
	$qry = "SELECT * FROM `expAccounts` WHERE id = '$id'";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data = mysqli_fetch_array($run);
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
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Expence Details</h1>
</div>

<div class="col-md-2 text-left">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ACCOUNT ID:-<?php echo $id; ?><br>
<label>Name: </label><span style="font-size:18px;"><?php echo " ".$data['name']; ?></span><br>
<b><a style="font-size:14px;text-decoration:none;" href="javascript:void()" onclick="exportExcel(<?php echo $id; ?>)">Export to excel</a></b></span>
</div>
</div>
<div class="row" style="font-size:16px;">
<div class="col-sm-12 text-center">
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
	<button onclick="refreshPage()">Go</button>
	<button onclick="refreshPage(1)">All</button>
</div>
</div>
<br>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1">Exp. #</div>
	<div class="col-sm-2">Sub Account</div>
	<div class="col-sm-2">Date</div>
	<div class="col-sm-5">Description</div>
	<div class="col-sm-2">Amount</div>
</div>
<?php
if(intval($year) == 0) $qry = "SELECT e.*,a.name,a.parent,a.id as aid FROM `expences` e,`expAccounts`a WHERE e.acc_id = a.id and (a.parent = '$id' or a.id = '$id')";
else  $qry = "SELECT e.*,a.name,a.parent,a.id as aid FROM `expences` e,`expAccounts`a WHERE e.date >= '$year-$month-01' and e.date <= '$year-$month-31' and e.acc_id = a.id and (a.parent = '$id' or a.id = '$id')";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total = 0;
while($data = mysqli_fetch_array($run))
{
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
  <div class="col-sm-1">EXP-<?php echo $id; ?></div>
  <div class="col-sm-2">EXP-<?php echo $data['aid']; ?></div>
	<div class="col-sm-2"><?php echo $data['date']; ?></div>
	<div class="col-sm-5"><?php echo $data['description']; ?></div>
	<div class="col-sm-2"><?php echo "Rs. ".number_format(intval($data['amount'])); $total += intval($data['amount']);?></div>
		</div>
	<?php
	}
?>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2"></div>
	<div class="col-sm-6"></div>
	<div class="col-sm-1">Total</div>
	<div class="col-sm-3">Rs. <?php echo number_format($total); ?></div>
</div>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function refreshPage(all = null) {
	if(all != null) {
			pageLoad("expences/detail.php?year=0&month=0");
	}
	else {
		var year = $("#yearOpt").val();
		var month = $("#monthOpt").val();
		pageLoad("expences/detail.php?year="+year+"&month="+month);

	}
}

function exportExcel(id)
{
	window.open("expences/detail_export.php?id="+id);
}
</script>
