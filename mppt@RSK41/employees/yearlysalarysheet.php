<div class="container addBox" style="width:95%;">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Employees Salary Sheet</h1>
</div>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-3 bold" style="border:1px solid black;">Year</div>
	<div class="col-sm-3 bold" style="border:1px solid black;">Month</div>
	<div class="col-sm-3 bold" style="border:1px solid black;">Salary Out</div>
	<div class="col-sm-3 bold" style="border:1px solid black;">Open</div>
</div>
<?php
require "../123321.php";
$tot_sal_all = 0;
for($month = 1;$month <= date('m');$month++)
{
	$qry = "SELECT * FROM `employee` WHERE 1";
	$run = mysqli_query($con,$qry) or die(mysqli_error($con));
	$tot_sal = 0;
	while($data = mysqli_fetch_array($run))
	{
		$id = $data['id'];
		$salary = $data['salary'];

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
			$total_profit += intval($data['hdRate']) * $data3['weices'];
			$total_profit += intval($data['ldRate']) * $data2['weices'];



		}

		$qry = "SELECT SUM(amount) as amount,SUM(duration) as dur FROM `advance` WHERE employee = '$id' and date >= '$year-$month-01' and date <= '$year-$month-31' group by employee";
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

		$tot_sal += (intval($sal) + $total_profit + intval($bonus)) - $advdeduct ;
		$tot_sal_all += (intval($sal) + $total_profit + intval($bonus)) - $advdeduct ;

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
	}
	?>
	<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
		<div class="col-sm-3" style="border:1px solid black;"><?php echo date("Y"); $year = date("Y"); ?></div>
		<div class="col-sm-3" style="border:1px solid black;"><?php echo $monthT; ?></div>
		<div class="col-sm-3" style="border:1px solid black;"><?php echo "Rs.".round($tot_sal, PHP_ROUND_HALF_UP); ?></div>
		<div class="col-sm-3" style="border:1px solid black;"><a onclick="return pageLoad('employees/salarysheet.php?year=<?php echo $year; ?>&month=<?php echo $month; ?>')">Open</a></div>
	</div>
	<?php
}

?>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
		<div class="col-sm-3 bold" style="border:1px solid black;"><?php echo date("Y"); $year = date("Y"); ?></div>
		<div class="col-sm-3 bold" style="border:1px solid black;"></div>
		<div class="col-sm-3 bold" style="border:1px solid black;"><?php echo "Rs.".round($tot_sal_all, PHP_ROUND_HALF_UP);; ?></div>
		<div class="col-sm-3 bold" style="border:1px solid black;">-</div>
	</div>
<!-- 	<a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a> -->
<br><br>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
</div>
<script>
function deductSal(id)
{
	var abs = $("#absents_"+id).val();
	var salperday = $("#salperdayDIV_"+id).html();
	var sal = $("#normsalDIV_"+id).html();
	var profit = $("#profitDIV_"+id).html();
	var advdeduct = $("#advdeductDIV_"+id).html();
	$("#salDIV_"+id).html("" + Number(parseFloat(sal) - parseFloat(salperday) * parseFloat(abs).toFixed(1)));
	$("#salProfitDIV_"+id).html("" + Number(parseFloat(sal) - parseFloat(salperday) * parseFloat(abs) + parseFloat(profit)).toFixed(1));
	$("#finalSalDIV_"+id).html("" + Number(parseFloat(sal) - parseFloat(salperday) * parseFloat(abs) + parseFloat(profit) - parseFloat(advdeduct)).toFixed(1));

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
        alert(xhttp.responseText);

    }};
    xhttp.open("POST", "do.php?action=updateabsents", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id+"&abs="+abs+"&ajax");
}

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
</script>

<script src="../js/jquery.min.js"></script>
<script src="../js/raphael-min.js"></script>
<script src="../js/prettify.min.js"></script>
<script src="lib/morris.js"></script>
<script src="lib/example.js"></script>
<link rel="stylesheet" href="lib/example.css">
<link rel="stylesheet" href="../css/prettify.min.css">
<link rel="stylesheet" href="lib/morris.css">
