<div class="row">
<div class="col-md-1"></div>
<div class="col-md-7">
<div class="graph" id="graph1"></div>
<h3>Two Weeks Invoices</h3>
</div>
<div class="col-md-3">
<div class="graph" id="graph4"></div>
<h3>Top Defaulters</h3>
</div>
<div class="col-md-1"></div>
</div>
<br><br><br>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-7">
<div class="graph" id="graph3"></div>
<h3>Monthly Payments</h3>
</div>
<div class="col-md-3">
<div class="graph" id="graph2"></div>
<h3>Top Customers</h3>
</div>
<div class="col-md-1"></div>
</div>
<pre id="code" class="prettyprint linenums">
// Use Morris.Bar
Morris.Line({
  element: 'graph1',
  data: [
    <?php
    require "123321.php";
    for($i = 13;$i >= 0;$i--)
    {
      $qry = "SELECT * FROM `invoice` WHERE `date` = '".date("Y-m-d",strtotime("-".$i." days"))."'";
      $run = mysqli_query($con,$qry) or die(mysqli_error($con));
      $rowCount = mysqli_num_rows($run);
      ?>
  	  {x: '<?php echo (14 - $i).". ".date("Y-m-d",strtotime("-".$i." days")); ?>', y: <?php echo $rowCount; ?>},
      <?php
    }
    ?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Invioces']
}).on('click', function(i, row){
  console.log(i, row);
});

Morris.Donut({
  element: 'graph2',
  data: [
    <?php
    $total = 0;
    $qry = "SELECT name,SUM(total) as ftotal FROM (SELECT c.name,i.no,idd.ref,(SUM(idd.charges) + SUM(idd.weices * idd.rate)) as total FROM customers c,invoice i,invoice_detail idd WHERE c.id = i.customer and i.id = idd.ref Group By idd.ref) AS subquery GROUP BY name";
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($run))
    {
      $total += intval($row['ftotal']);

    }
    $qry = "SELECT name,SUM(total) as ftotal FROM (SELECT c.name,i.no,idd.ref,(SUM(idd.charges) + SUM(idd.weices * idd.rate)) as total FROM customers c,invoice i,invoice_detail idd WHERE c.id = i.customer and i.id = idd.ref Group By idd.ref) AS subquery GROUP BY name LIMIT 5";
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    $total_byFive = 0;
    while($row = mysqli_fetch_array($run))
    {
    ?>
    {value: <?php echo intval((intval($row['ftotal'])  * 100 / $total)); ?>, label: '<?php echo $row['name']; ?>'},
    <?php
    $total_byFive += intval((intval($row['ftotal'])  * 100 / $total));
    }
    ?>
    {value: <?php echo (100 - $total_byFive); ?>, label: 'Others'},
  ],
  formatter: function (x) { return x + "%"}
}).on('click', function(i, row){
  console.log(i, row);
});


Morris.Donut({
  element: 'graph4',
  data: [
    <?php
    $total = 0;
    $qry = "SELECT s3.*,i.customer,c.name FROM (SELECT s1.no,s1.total,s2.payment,(100 - (s2.payment / s1.total) * 100) as perc FROM ( (SELECT i.no,SUM(idd.weices * idd.rate + idd.charges) as total FROM invoice i LEFT JOIN invoice_detail idd ON i.id = idd.ref GRoUP by i.id) ) s1 LEFT JOIN ( (SELECT i.no,IFNULL(SUM(p.amount),0) as payment FROM invoice i LEFT JOIN payments_recv p ON i.no = p.inv_no GRoUP by i.no) ) s2 ON s1.no = s2.no) s3,invoice i,customers c WHERE s3.no = i.no and i.customer = c.id and s3.perc != 0 order by s3.perc DESC LIMIT 5";
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($run))
    {
    ?>
    {value: <?php echo intval($row['perc']); ?>, label: '<?php echo $row['name']; ?>'},
    <?php
    }
    ?>
  ],
  formatter: function (x) { return x + "%"}
}).on('click', function(i, row){
  console.log(i, row);
});

// Use Morris.Bar
Morris.Line({
  element: 'graph3',
  data: [
  <?php
  for($i = 1;$i <= 12;$i++) {
    $qry = "SELECT SUM(amount) as pay FROM payments_recv WHERE `rec_date` >= '".date('Y-')."-".sprintf("%02d",$i)."-01' and `rec_date` < '".date('Y-')."-".sprintf("%02d",($i+1))."-01'";
    $exp = 0;
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    $row = mysqli_fetch_array($run);
    if($row['pay'] != NULL) {
    $exp = $row['pay'];
    }
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
    ?>
    {x: '<?php echo $i.". ".$month." ".date('y'); ?>', y: <?php echo $exp; ?>},
    <?php
  }
  ?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Payment']
  }).on('click', function(i, row){
  console.log(i, row);
  });
</pre>
<script type="text/javascript">
function onPageLoad()
{

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
