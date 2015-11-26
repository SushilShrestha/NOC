<?php
session_start();
session_unset();

session_destroy();
header("Location: /NOC/login.php");
die();
?>