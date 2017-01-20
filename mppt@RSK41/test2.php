<?php
require "123321.php";
$qry = "SELECT * FROM invoice WHERE 1";
$run = mysqli_query($con,$qry) or die(mysqli_error($con));
while($data = mysqli_fetch_array($run))
{
  $qry = "SELECT * FROM invoice_detail WHERE ref = '".$data['no']."'";
  $run2 = mysqli_query($con,$qry) or die(mysqli_error($con));
  if(mysqli_num_rows($run2) == 1)
  {
    $qry = "INSERT INTO `invoice_detail`(`id`, `ref`, `size`, `material`, `exp_name`, `charges`, `weices`, `rate`, `bag`) VALUES (NULL,'".$data['no']."','--','--','Total Bill','0','0','0','0')";
    echo $qry;
    mysqli_query($con,$qry) or die(mysqli_error($con));
  }
}
?>
