<?php 
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('no', '', 0, '/' );
setcookie('key', '', 0, '/' );



header("location: login.php");
exit;
?>