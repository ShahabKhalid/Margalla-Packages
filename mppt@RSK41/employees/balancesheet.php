<div class="container addBox">
<div class="inBox">
<div class="row">
<div class="col-md-10">
<h1 style="position:relative;left:100px;">Balance Sheet</h1>
</div>
</div>
<br><br><br>
<div class="row" style="font-weight:bold;border-bottom:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1">Particular</div>
	<div class="col-sm-2">ID</div>
	<div class="col-sm-2">Date</div>
	<div class="col-sm-2 text-left">Debit</div>
	<div class="col-sm-2 text-left">Credit</div>
	<div class="col-sm-3 text-left">Balance</div>
</div>
<?php
require "../123321.php";
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.id = idd.ref GROUP BY i.id ) sub, invoice i WHERE i.id = sub.id";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
SELECT b.id,sub.ref,b.date,sub.amount,'bill' FROM (SELECT b.ref,SUM(bd.weices * bd.rate) as amount FROM bill b,bill_detail bd WHERE b.ref = bd.ref GROUP by b.ref) sub,bill b WHERE sub.ref = b.ref";
mysqli_query($con,$qry) or die(mysqli_error($con));
//$qry = "INSERT INTO tmp (id,ref,date,amount,type)
//SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv";
//mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "INSERT INTO tmp (id,ref,date,amount,type)
SELECT id,'0',date,amount,'expence' FROM expences";
mysqli_query($con,$qry) or die(mysqli_error($con));
$qry = "SELECT * FROM tmp order by date;";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$balanace = 0;
while($data = mysqli_fetch_array($run))
{
$advance = intval($data['advance']);


$qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.id = idd.ref and idd.ref = '".$data['id']."' and idd.material = 'LD' group by idd.id order by idd.id";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$ldCount = mysqli_num_rows($run2);
$data2 = mysqli_fetch_array($run2);

$qry = "SELECT i.id,idd.id,SUM(idd.weices) as weices FROM `invoice` i,invoice_detail idd WHERE i.id = idd.ref and idd.ref = '".$data['id']."' and idd.material = 'HD' group by idd.id order by idd.id";
$run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
$hdCount = mysqli_num_rows($run2);
$data3 = mysqli_fetch_array($run2);

?>
<div class="row" style="width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1"><?php echo ucfirst($data['type']); ?></div>
	<div class="col-sm-2 pointer"
	<?php if($data['type'] == "invoice") { ?> onclick="viewInvoice('<?php echo $data['id'] ?>')"  <?php } ?>
	<?php if($data['type'] == "bill") { ?> onclick="viewBill('<?php echo $data['id'] ?>')"  <?php } ?>
	<?php if($data['type'] == "expence") { ?> onclick="viewExpence('<?php echo $data['id'] ?>')"  <?php } ?>
	>
	<?php if($data['type'] == "invoice") echo "INV-"; else if($data['type'] == "bill") echo "BILL-"; if($data['type'] == "pay") echo "PY-"; if($data['type'] == "expence") echo "EXP-"; echo $data['id'] ?></div>
	<div class="col-sm-2"><?php echo $data['date']; ?></div>
	<div class="col-sm-2 text-left"><?php if($data['type'] == "invoice") { echo "Rs. ".number_format($data['amount']); $balanace += intval($data['amount']); } else echo "--"; ?></div>
	<div class="col-sm-2 text-left"><?php if($data['type'] == "expence" || $data['type'] == "bill") { echo "Rs. ".number_format($data['amount']); $balanace -= intval($data['amount']); } else echo "--"; ?></div>
	<div class="col-sm-3 text-left">Rs. <?php echo number_format($balanace); ?></div>
</div>
<?php
}
$qry = "DELETE FROM `tmp` WHERE 1 ";
mysqli_query($con,$qry) or die(mysqli_error($con));
?>
<br>
<div class="row" style="border-top:2px solid black;width:95%;position:relative;margin:0 auto;">
	<div class="col-sm-1"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2"></div>
	<div class="col-sm-2 text-left">Total</div>
	<div class="col-sm-3 text-left">Rs. <?php echo number_format($balanace); ?></div>
</div><br><br>
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

function viewExpence(id)
{
    pageLoad("expences/edit.php?id="+id);
}

function viewBill(id)
{
    pageLoad("vendors/bill_detail.php?id="+id);
}

function viewInvoice(id)
{
	pageLoad("customers/invoice_print.php?no="+id);
}
</script>
