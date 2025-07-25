<?php
session_start();
// echo "<pre>";
// print_r($_SESSION);die;
// unset($_SESSION['user_data']);
session_destroy();
header('Location:login.php');

?>