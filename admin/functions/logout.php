<?php 

session_start();
session_destroy();
$_SESSION['link'] = "http://localhost/theserve-amarah-s-corner-bf-resort/admin/";
header("Location: ../login");
?>