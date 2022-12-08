<?php


session_start();
unset($_SESSION["userID"]);
//unset($_SESSION["fullname"]);
session_write_close();
session_destroy();
header("Location:login.php");
?>