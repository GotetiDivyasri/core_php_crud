<?php
	// header("Location: https.php");
	// header("Refresh:5; url = https.php");
	echo "<h1> Hii I am Home page. </h1>";
	header("Expire: Sun,27 July 2025 06:40:00 GMT");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");

	echo "<pre>";
	print_r(headers_list());

//file download forcefully
	
	// header("Content-type: application/pdf");
	// header("Content-Disposition: attachment; filename = demo.pdf");
	// readfile(sctsdb_backup.sql);
?>