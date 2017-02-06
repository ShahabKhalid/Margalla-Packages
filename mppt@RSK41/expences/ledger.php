<div class="container addBox">
<div class="inBox">
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
?>
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Expence Ledger</h1>
</div>

<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;"></span>
</div>
</div>
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
	<button onclick="refreshPage()">Go</button>
	<button onclick="refreshPage(1)">All</button>
</div>
<div class="col-sm-3"></div>
</div>
<div class="row">
	<div class="col-sm-9"></div>
	<div class="col-sm-2" style="text-align:right;"><b><a href="javascript:void()" onclick="exportExcel()">Export to excel</a></b></div>
	<div class="col-sm-1" style="text-align:left;"><b><a href="javascript:void()" onclick="printLedger()">Print</a></b></div>
</div>
<div class="row" style="border:1px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2" style="border:1px solid black;">Particular</div>
	<div class="col-sm-1" style="border:1px solid black;">Exp. #</div>
	<div class="col-sm-2" style="border:1px solid black;">Account</div>
	<div class="col-sm-1" style="border:1px solid black;">Date</div>
	<div class="col-sm-2" style="border:1px solid black;">Description</div>
	<div class="col-sm-1" style="border:1px solid black;">Debit</div>
	<div class="col-sm-1" style="border:1px solid black;">Credit</div>
	<div class="col-sm-2" style="border:1px solid black;">Balance</div>
</div>
<?php
if(intval($year) == 0) $qry = "SELECT e.* FROM `expences` e WHERE 1";
else $qry = "SELECT e.* FROM `expences` e WHERE date >= '$year-$month-01' and date <= '$year-$month-31'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$total = 0;
while($data = mysqli_fetch_array($run))
{
if($data['acc_id'] != '-1')
{
	$qry = "SELECT name FROM `expAccounts` a WHERE a.id = '".$data['acc_id']."'";
	$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
	$data2 = mysqli_fetch_array($run2);
}
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') echo "Petty Cash"; else echo "Expence"; ?></div>
  <div class="col-sm-1" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') echo "PC-"; else echo "EXP-"; echo $data['id']; ?></div>
	<div class="col-sm-2" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') echo "---"; else { if(strlen($data2['name']) > 13) echo substr($data2['name'],0,13)."..."; else echo $data2['name']; } ?></div>
	<div class="col-sm-1" style="border:1px solid black;"><?php echo $data['date']; ?></div>
	<div class="col-sm-2" style="border:1px solid black;"><?php if(strlen($data['description']) > 13) echo substr($data['description'],0,13)."..."; else echo $data['description']; ?></div>
	<div class="col-sm-1" style="border:1px solid black;"><?php if($data['acc_id'] == '-1') { echo $data['amount']; $total += intval($data['amount']); } else  echo "---"; ?></div>
		<div class="col-sm-1" style="border:1px solid black;"><?php if($data['acc_id'] != '-1') { echo $data['amount']; $total -= intval($data['amount']); } else  echo "---"; ?></div>
	<div class="col-sm-2" style="border:1px solid black;"><?php echo "Rs. ".number_format(intval($total)); ?></div>
		</div>
	<?php
	}
?>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-3"></div>
	<div class="col-sm-6"></div>
	<div class="col-sm-1">Total</div>
	<div class="col-sm-2">Rs. <?php echo number_format($total); ?></div>
</div>
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function refreshPage(all = null) {
	if(all != null) {
			pageLoad("expences/ledger.php?year=0&month=0");
	}
	else {
		var year = $("#yearOpt").val();
		var month = $("#monthOpt").val();
		pageLoad("expences/ledger.php?year="+year+"&month="+month);

	}
}
function printLedger()
{
	alert("Error: Too much fields to print! Please export to Excel and print!");
	//window.open("expences/ledger_print.php?id="+id);
}


function exportExcel()
{
	window.open("expences/ledger_export.php");
}
</script>
