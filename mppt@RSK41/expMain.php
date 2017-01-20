<div class="row">
<div class="col-md-1"></div>
<div class="col-md-10">
<div class="graph" id="graph3"></div>
<h3>Monthly Expences</h3>
</div>
<div class="col-md-1"></div>
</div>
<br><br><br>
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-7">
<div class="graph" id="graph1"></div>
<h3>Daily Expences</h3>
</div>
<div class="col-md-3">
<div class="graph" id="graph2"></div>
<h3>Highest Expences</h3>
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
  for($i = 0;$i <= 31;$i++)
  {
    $qry = "SELECT SUM(amount) as exp FROM `expences` WHERE `date` = '".date("Y-m")."-".sprintf('%02d',$i)."' GROUP by `date`";
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    $exp = 0;
    if(mysqli_num_rows($run) > 0) {
    $row = mysqli_fetch_array($run);
    $exp = $row['exp'];
    }
    ?>
    {x: '<?php echo ($i).". ".date("Y-m")."-".sprintf("%02d",$i); ?>', y: <?php echo $exp; ?>},
    <?php
  }
  ?>
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Expences(Rs)']
}).on('click', function(i, row){
  console.log(i, row);
});

Morris.Donut({
  element: 'graph2',
  data: [
    <?php
    $total = 0;
    $qry = "SELECT a.name,SUM(e.amount) as ftotal FROM expAccounts a,expences e WHERE a.id = e.acc_id GROUP BY a.name";
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    while($row = mysqli_fetch_array($run))
    {
      $total += intval($row['ftotal']);

    }
    $qry = "SELECT a.name,SUM(e.amount) as ftotal FROM expAccounts a,expences e WHERE a.id = e.acc_id GROUP BY a.name LIMIT 5";
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    $total_byFive = 0;
    while($row = mysqli_fetch_array($run))
    {
    ?>
    {value: <?php echo sprintf('%0.2f',intval($row['ftotal'])  * 100 / $total); ?>, label: '<?php echo $row['name']; ?>'},
    <?php
    $total_byFive += sprintf('%0.2f',intval($row['ftotal'])  * 100 / $total);
    }
    ?>
    {value: <?php echo sprintf('%0.2f',100 - $total_byFive); ?>, label: 'Others'},
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
  for($i = 1;$i <= 12;$i++) {
    $qry = "SELECT SUM(amount) as exp FROM `expences` WHERE `date` > '".date('Y-')."-".sprintf("%02d",$i)."-01' and `date` < '".date('Y-')."-".sprintf("%02d",($i+1))."-01'";
    $exp = 0;
    $run = mysqli_query($con,$qry) or die(mysqli_error($con));
    $row = mysqli_fetch_array($run);
    if($row['exp'] != NULL) {
    $exp = $row['exp'];
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
    {x: '<?php echo $month." ".date('y'); ?>', y: <?php echo $exp; ?>},
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
