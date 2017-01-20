<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10">
<div class="graph" id="graph1"></div>
<h3>Two Weeks Bills</h3>
</div>
<div class="col-md-1"></div>
</div>
<br><br><br>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-7">
<div class="graph" id="graph3"></div>
<h3>Highest Bills</h3>
</div>
<div class="col-md-3">
<div class="graph" id="graph2"></div>
<h3>Top Vendors</h3>
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
      $qry = "SELECT sub.ref,SUM(bd.weices * bd.rate) as total FROM (SELECT * FROM `bill` WHERE `date` = '".date("Y-m-d",strtotime("-".$i." days"))."') sub,bill_detail bd WHERE sub.ref = bd.ref GROUP BY bd.ref";
      $run = mysqli_query($con,$qry) or die(mysqli_error($con));
      $row = mysqli_fetch_array($run);
      $rowCount = mysqli_num_rows($run);
      ?>
  	  {x: '<?php echo (14 - $i).". ".date("Y-m-d",strtotime("-".$i." days")); ?>', y: <?php echo $rowCount; ?>},
      <?php
    }
    ?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Bills']
}).on('click', function(i, row){
  console.log(i, row);
});

Morris.Donut({
  element: 'graph2',
  data: [
    <?php
    $total = 0;
    $qry = "SELECT SUM(sub.total) as ftotal,v.name FROM (SELECT bd.ref,SUM(bd.weices * bd.rate) as total FROM vendor v,bill b,bill_detail bd WHERE v.id = b.vendor and b.ref = bd.ref Group By bd.ref) sub,bill b,vendor v WHERE sub.ref = b.ref and b.vendor = v.id GROUP by name";
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($run))
    {
      $total += intval($row['ftotal']);

    }
    $qry = "SELECT SUM(sub.total) as ftotal,v.name FROM (SELECT bd.ref,SUM(bd.weices * bd.rate) as total FROM vendor v,bill b,bill_detail bd WHERE v.id = b.vendor and b.ref = bd.ref Group By bd.ref) sub,bill b,vendor v WHERE sub.ref = b.ref and b.vendor = v.id GROUP by name";
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

// Use Morris.Bar
Morris.Bar({
  element: 'graph3',
  data: [
  <?php
  $qry = "SELECT b.vendor,SUM(bd.weices * bd.rate) as amount FROM bill b,`bill_detail` bd WHERE b.ref = bd.ref GROUP BY b.id,b.vendor order by amount DESC LIMIT 4";
  $run = mysqli_query($con,$qry) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($run))
  {
    $qry = "SELECT * FROM `vendor` WHERE `id` = '".$row['vendor']."'";

    $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
    $row2 = mysqli_fetch_array($run2);
    ?>
    {x: '<?php echo $row2['name']." | ".$row['rec_date']; ?>', y: <?php echo $row['amount']; ?>},
    <?php
  }
  ?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Amount']
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
