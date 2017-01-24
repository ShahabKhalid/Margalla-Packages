<?php
@session_start();
$con = mysqli_connect("172.17.0.2","root","123","bashsoft_mppt_default_db") or die(mysqli_error());

//$con = mysqli_connect("localhost","bashsoft_shahab","AshaSha41","bashsoft_mppt_default_db");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
