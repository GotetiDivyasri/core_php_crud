<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'core_php';
    mysqli_report(MYSQLI_REPORT_STRICT);
    try{
        $conn = new mysqli($servername,$username,$password,$database);
        //echo "Connection Successful";
    }catch(Exception $ex){
        echo "connection failed: ".$ex->getMessage();
    }
  
?>