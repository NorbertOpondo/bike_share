<?php
session_start();
session_destroy();
header("location: /localhost/dashboard/admin_login.php");

?>