<?php
@session_start();
unset($_SESSION['mppt_admin']);
header('location: index.php');
?>
