<?php
require "../123321.php";
$qry = "SELECT * FROM `customers` WHERE 1 ".$filter_qry." order by `id`";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
$count = 1;

while($row = mysqli_fetch_array($run))
{
	$id = $row['id'];
	echo $id."<br>";
	$count = 1;



	$open_balance = $row['opening_balance'];
	$total_balance = $open_balance;
	echo $total_balance;
	$qry = "DELETE FROM `tmp` WHERE 1 ";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	$qry = "INSERT INTO tmp (id,ref,date,amount,type)
	SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.id = idd.ref GROUP BY i.id ) sub, invoice i,customers c WHERE i.id = sub.id and c.id = i.customer and c.id = '".$id."'";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	$qry = "INSERT INTO tmp (id,ref,date,amount,type)
	SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv WHERE `customer` = '".$id."'";
	mysqli_query($con,$qry) or die(mysqli_error($con));
	$qry = "SELECT * FROM tmp";
	$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
	while($data = mysqli_fetch_array($run3))
	{
	if($data['type'] == "invoice") {  $total_balance += intval($data['amount']); } 
	else if($data['type'] == "pay") {  $total_balance -= intval($data['amount']); } 
	}
		if($count % 2 == 0) echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.15);">';
	else echo '<div  class="row" id="r2" style="background-color:rgba(0,0,0,0.05);">';
	?>
	<div onclick='pageLoad("customers/customer_ledger.php?id=<?php echo $id; ?>")'>
	<div class="col-md-1"><?php echo $count++; ?></div>
	<div class="col-md-1"><?php echo "MPC-".$row['id']; ?></div>
	<div class="col-md-2"><?php echo $row['name']; ?></div>
	<div class="col-md-2"><?php echo $row['contact']; ?></div>
	<div class="col-md-3"><?php echo $row['address']; ?></div>
	<div class="col-md-2">Rs. <?php echo number_format($total_balance); ?></div>
	</div>
	<div class="col-md-1"><a href="javascript:void()" onclick='pageLoad("customers/edit.php?id=<?php echo $id; ?>")'>Edit</a></div>
	</div>
	<?php
}
?>