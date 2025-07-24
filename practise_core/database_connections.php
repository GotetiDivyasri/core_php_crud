<?php
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'testing';

	//mysqli connection

	//error_reporting(0); // it wont show errors
	// mysqli_report(MYSQLI_REPORT_STRICT);
	// try{
	// 	$conn = new mysqli($servername,$username,$password,$database);
	// 	echo "Connection Successful";
	// 	//get data from mysqli
	// 	$sql = "SELECT * FROM users";
	// 	$exec = $conn->query($sql);
	// 	echo "<pre>";

	// 	echo "returns index array";
	// 	$res = mysqli_fetch_array($exec,MYSQLI_NUM);
	// 	print_r($res);
	// 	echo "returns associate array";
	// 	$res2 = mysqli_fetch_array($exec,MYSQLI_ASSOC);
	// 	print_r($res2);
	// 	echo "returns numeric and associate array";
	// 	$res3 = mysqli_fetch_array($exec,MYSQLI_BOTH);
	// 	print_r($res3);
	// 	echo "returns object";
	// 	$exec->data_seek(0);
	// 	$res4 = $exec->fetch_object();
	// 	print_r($res4); 

	// }catch(Exception $ex){
	// 	echo "connection failed: ".$ex->getMessage();
	// }

	//pdo connection

	try{
		$conn = new PDO("mysql:host=$servername;dbname=$database",$username,$password);
		$conn->setAttribute(PDO::ATTR_CASE,PDO::CASE_NATURAL);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		echo "connected successfully";
		//get data from pdo
		$sql = "SELECT * FROM users";
		$exec = $conn->prepare($sql);
		$exec->execute();

		echo "<pre>";
		//return index array
		echo "return numeric array";
		$result = $exec->fetch(PDO::FETCH_NUM);
		print_r($result);

		//return associative array
		echo "return associative array";
		$result2 = $exec->fetch(PDO::FETCH_ASSOC);
		print_r($result2);

		//return index and assoc array
		echo "return numeric and associative array";
		$result3 = $exec->fetch(PDO::FETCH_BOTH);
		print_r($result3);

		//return object
		echo "return object";
		$result4 = $exec->fetch(PDO::FETCH_OBJ);
		print_r($result4);
	}catch(PDOException $ex){
		echo "connection failed :". $ex->getMessage();
	}
?>