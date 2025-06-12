<?php
session_start();
session_unset();
session_destroy();
setcookie("PHPSESSID", "", TIME() -3600, "/");
header("location: login.php");
exit;