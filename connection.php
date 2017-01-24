<?php
@session_start();
$con = mysqli_connect("localhost","root","raftaar","bashsoft_mpi") or die(mysqli_error());

//$con = mysqli_connect("localhost","bashsoft_shahab","AshaSha41","bashsoft_mpi");
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
