<?php
session_start();
session_destroy();
header("Location: index.php");
exit;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>