<div class="container addBox" style="width:95%">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Customer Ledger / Statement</h1>
</div>
<?php
require "../123321.php";
$id = $_GET['id'];
$qry = "SELECT * FROM `customers` WHERE `id` = '$id'";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$data = mysqli_fetch_array($run);
$open_balance = $data['opening_balance'];
?>
<div class="col-md-2 text-right">
<span style="font-size:20px;padding-right:20px;position:relative;top:20px;text-decoration:underline;">ID: MPC-<?php echo $id; ?></span>
</div>
</div>
<table id="testTable">
<div class="row" id="r1"><div class="col-md-2"><label>Name</label></div><div class="col-md-4 text-left"><span style="font-size:18px;"><?php echo $data['name']; ?></span></div><div class="col-md-3"><label>Contact #</label></div><div class="col-md-3 text-left"><span style="font-size:18px;"><?php echo $data['contact']; ?></span></div></div><br>
<div class="row" id="r1"><div class="col-md-2"><label>Address</label></div><div class="col-md-10 text-left"><span style="font-size:18px;"><?php echo $data['address']; ?></span></div><div class="col-md-3"></div></div>
<br><br><br>
<div class="row" style="border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2 bold">Particular</div>
	<div class="col-sm-1 bold">Inv #</div>
	<div class="col-sm-1 bold">Inv. Date</div>
	<div class="col-sm-1 bold">Pay. Ref.#</div>
	<div class="col-sm-1 bold">Pay. Date</div>
	<div class="col-sm-2 bold">Debit</div>
	<div class="col-sm-2 bold">Credit</div>
	<div class="col-sm-2 bolds">Balance</div>
</div>
<div class="row" style="border-bottom:1px dotted gray;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-10 bold">Opening Balance</div>
	<div class="col-sm-2 bold">Rs. <?php echo floatval($open_balance); ?></div>
</div>
<?php
$qry = "DELETE FROM `tmp` WHERE 1 ";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
						SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.no,i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.no = idd.ref GROUP BY idd.ref ) sub, invoice i,customers c WHERE i.no = sub.no and c.id = i.customer and c.id = '".$id."'";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv WHERE `customer` = '".$id."'";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "SELECT * FROM tmp order by date;";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$balanace = 0;
$total_balance = $open_balance;
$prev_inv_no = 0;
$total_of_inv = 0;
$total_of_pay = 0;
while($data = mysqli_fetch_array($run))
{
if($prev_inv_no !== $data['id'])
{
?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">

<div class="col-sm-2" style="border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "invoice") echo "Bill"; else echo "Cash"; ?></div>
<div class="col-sm-1 pointer" style="border-right:1px solid black;border-bottom:1px solid gray;" onclick="viewInvoice('<?php echo $data['id'] ?>')"><?php if($data['type'] == "invoice") echo "INV-".$data['id']; else echo "---";?></div>
<div class="col-sm-1" style="border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "invoice") echo $data['date']; else echo "---"; ?></div>
<div class="col-sm-1 pointer" style="border-right:1px solid black;border-bottom:1px solid gray;" onclick="viewPayment('<?php echo $data['id'] ?>')"><?php if($data['type'] == "pay") echo $data['ref']; else echo "---"; ?></div>
<div class="col-sm-1" style="border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "pay") echo $data['date']; else echo "---"; ?></div>
<div class="col-sm-2" style="border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "invoice") { echo "Rs.".floatval($data['amount']); $total_of_inv += floatval($data['amount']); $total_balance += floatval($data['amount']); } else echo "---"; ?></div>
<div class="col-sm-2" style="border-right:1px solid black;border-bottom:1px solid gray;"><?php if($data['type'] == "pay") { echo "Rs. ".floatval($data['amount']); $total_of_pay += floatval($data['amount']); $total_balance -= floatval($data['amount']); } else echo "---"; ?></div>
<div class="col-sm-2" style="border-right:1px solid black;border-bottom:1px solid gray;">Rs. <?php echo $total_balance; ?></div>
</div>
<?php
if($data['type'] == "invoice") $prev_inv_no = $data['id'];
else $prev_inv_no = 0;
}
}
?>
<?php
$qry = "DELETE FROM `tmp` WHERE 1 ";
mysqli_query($con,$qry) or die(mysqli_error($con));
?>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-2">Total</div>
	<div class="col-sm-1"></div>
	<div class="col-sm-1"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2">Rs <?php echo $total_of_inv; ?></div>
	<div class="col-sm-2">Rs <?php echo $total_of_pay; ?></div>
	<div class="col-sm-2">Rs. <?php echo $total_balance; ?></div>
</div>
</table>
<a href="javascript:void()" onclick="return exportLedger('<?php echo $id; ?>')">Export to excel</a> 
<a href="javascript:void()" onclick="return printView('<?php echo $id; ?>')">Print</a>
</div><br>
<p id="esc">Press Escape to go back!</p>
</div>
<script>
function exportLedger(id)
{
	window.open("customers/customer_ledger_export.php?id="+id);
}
function printView(id)
{
	window.open("customers/customer_ledger_print.php?id="+id);
}
function viewPayment(id)
{
    pageLoad("customers/payment_update.php?id="+id);
}

function viewInvoice(no)
{
	pageLoad("customers/invoice_print.php?no="+no);
}

</script>
