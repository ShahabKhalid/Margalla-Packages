<!DOCTYPE HTML>
<html>
<head>
<title>Customer List</title>
<link rel="shortcut icon" type="image/png" href="../../favicon.png">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<style>
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm;}
}
</style>
</head>
<body onload="init()" style="background-color:white;">
<br>
<?php
require "../123321.php";
?>
<div class="container" style="position:relative;left:-50px;width:800px;">
<div>
<div class="row">
<div class="col-sm-8">
<img style="width:800px;" src="logo.jpg">
</div>
<div class="col-sm-4 text-right">
<span style="font-size:20px;"></span></div>
</div>
</div>
<br><br>
<div class="row">
<div class="col-xs-12">
<h1 class="text-center" >Customers List</h1>
<br>
</div>

</div>
<div class="row" id="r2" style="border:1px solid black;">
<div class="col-xs-1" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><b>Serial</b></div>
<div class="col-xs-1" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;" onclick="updateCustomerList('id')"><b>ID</b></div>
<div class="col-xs-3" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;" onclick="updateCustomerList('name')"><b>Name</b></div>
<div class="col-xs-1" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;" onclick="updateCustomerList('contact')"><b>Contact</b></div>
<div class="col-xs-2" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><b>Last Invoice (Date)</b></div>
<div class="col-xs-2" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><b>Last Payment (Date)</b></div>
<div class="col-xs-2" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><b>Balance</b></div>
</div>
<?php
$qry = "SELECT * FROM `customers` WHERE 1 order by `id`";
					$run = mysqli_query($con,$qry) or die(mysqli_error($con));
					$count = 1;
					$first = 0;

					while($row = mysqli_fetch_array($run))
					{
						$id = $row['id'];
						



						$open_balance = $row['opening_balance'];
						$total_balance = $open_balance;
						$qry = "DELETE FROM `tmp` WHERE 1 ";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						$qry = "INSERT INTO tmp (id,ref,date,amount,type)
						SELECT i.no,i.id,i.date,sub.amount,'invoice' FROM (SELECT i.no,i.id,SUM(idd.weices * idd.rate + idd.charges) as amount FROM invoice i , invoice_detail idd WHERE i.no = idd.ref GROUP BY idd.ref ) sub, invoice i,customers c WHERE i.no = sub.no and c.id = i.customer and c.id = '".$id."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						$qry = "INSERT INTO tmp (id,ref,date,amount,type)
						SELECT id,ref_no,rec_date,amount,'pay' FROM payments_recv WHERE `customer` = '".$id."'";
						mysqli_query($con,$qry) or die(mysqli_error($con));
						$qry = "SELECT * FROM tmp";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$prev_inv_no = 0;
						while($data = mysqli_fetch_array($run3))
						{
						
						if($data['type'] == "invoice") {  if($prev_inv_no !== $data['id']) { $total_balance += floatval($data['amount']); } $prev_inv_no = $data['id']; } 
						else if($data['type'] == "pay") { $prev_inv_no = 0;  $total_balance -= floatval($data['amount']); } 

						}
						if($first == 0) {
							if($count % 20 == 0) {
								echo "<br><br><br>";
								$first= 1;
							}
						}
						else if($first == 1)
						{
							if($count % 24 == 0) {
								$first= 2;
							}
						}
						else if($first == 2)
						{
							if($count % 24 == 0) {
								echo "<br>";
							}
						}

							echo '<div  class="row" id="r2">';



						$qry = "SELECT * FROM `invoice` WHERE `customer` = '".$row['id']."'";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$data = mysqli_fetch_array($run3);
						$inv_result = mysqli_num_rows($run3);
						$inv_date = $data['date'];
						$qry = "SELECT SUM(charges + weices * rate) as tot FROM invoice_detail WHERE ref = '".$data['no']."' GROUP BY ref";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$data = mysqli_fetch_array($run3);
						$tot = $data['tot'];

						$qry = "SELECT * FROM `payments_recv` WHERE `customer` = '".$row['id']."'";
						$run3 = mysqli_query($con,$qry) or die(mysqli_error($con));
						$data = mysqli_fetch_array($run3);
						$pay_result = mysqli_num_rows($run3);
						$pay_date = $data['rec_date'];
						$pay_amount = $data['amount'];
						?>
						<div onclick='pageLoad("customers/customer_ledger.php?id=<?php echo $id; ?>")'>
						<div class="col-xs-1" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><?php echo $count++; ?></div>
						<div class="col-xs-1" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><?php echo $row['id']; ?></div>
						<div class="col-xs-3" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><?php if(strlen($row['name']) > 40) echo substr($row['name'],0,40)."..."; else echo $row['name']; ?></div>
						<div class="col-xs-1" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><?php echo $row['contact']; ?></div>
						<div class="col-xs-2" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><?php if($inv_result > 0) echo "Rs. ".$tot." (".$inv_date.")"; else echo "--"; ?></div>
						<div class="col-xs-2" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;"><?php if($pay_result > 0) echo "Rs. ".$pay_amount." (".$pay_date.")"; else echo "--"; ?></div>
						<div class="col-xs-2" style="border:1px solid black;height:40px;padding-top:5px;text-align:cente;text-align:center;font-size:12px;">Rs. <?php echo round( $total_balance, 2, PHP_ROUND_HALF_EVEN); ?></div>
						</div>
						</div>
						<?php
					}
?>
</div><br>
<script>
function init() {
    window.print();
    window.close();
}
</script>
</body>
