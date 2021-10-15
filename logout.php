<?php
session_start();
setcookie("property_login", "pro", time()-1, "/");
session_destroy();
$_SESSION['update'] = "<div class='alert alert-success'>You have been logged out. Sign in again to proceed.</div>";
header("Location: index.php"); exit;
?>