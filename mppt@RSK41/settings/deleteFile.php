<?php
require '../123321.php';
if(!isset($_SESSION['mppt_admin']))
{
    header('location: index.php');
}
unlink('../uploads/'.$_POST['file']);
echo "1";
?>