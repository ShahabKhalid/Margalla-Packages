<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10">
<div class="graph" id="graph1"></div>
<h3>Month's Top SaleReps</h3>
</div>
<div class="col-md-1"></div>
</div>
<br><br><br>
<pre id="code" class="prettyprint linenums">

// Use Morris.Bar
Morris.Bar({
  element: 'graph1',
  data: [
  <?php
  require "123321.php";
  $qry = "SELECT sub.name,SUM(sub.total) as total FROM (SELECT sub.*,SUM(idd.weices * idd.rate + idd.charges) as total FROM (SELECT e.name,i.id FROM `invoice` i,`employee` e WHERE i.salerep = e.id and i.date >= '".date("Y-m")."-01') sub,`invoice_detail` idd WHERE sub.id = idd.ref GROUP BY sub.id) sub GROUP BY name order by total DESC LIMIT 5";
  $run = mysqli_query($con,$qry) or die(mysqli_error($con));
  while($row = mysqli_fetch_array($run))
  {
    ?>
    {x: '<?php echo $row['name']; ?>', y:<?php echo $row['total']; ?>},
    <?php
  }
  ?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Sale (Rs)']
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
