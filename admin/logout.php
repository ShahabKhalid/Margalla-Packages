<?php
require "../connection.php";
unset($_SESSION['admin']);
header("location: index.php");
?>