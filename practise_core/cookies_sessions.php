<!-- cookies -->

<?php
	// echo "<h1>Cookies</h1>";
	//setcookie("habbits","drawing",time()+2*24*60*60);
	// setcookie("habbits","drawing",time()+5);
?>
<!-- <!DOCTYPE html> 
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cookies</title>
</head>
<body>
	<fieldset style="width:20rem;">
		<legend>cookie values</legend>
		<?php
		   // print_r($_COOKIE);
		?>
	</fieldset>

</body>
</html> -->

<!-- sessions -->
<?php
	session_start();
	echo session_save_path();
	echo '<br>';
	echo session_name();
	$_SESSION['fav_hobby']= 'Drawing';
	$_SESSION['aim']= 'Dancer';
	unset($_SESSION['aim']);
	print_r($_SESSION);
	session_destroy();
?>