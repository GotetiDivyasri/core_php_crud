<?php
	putenv("adding=30");
	echo "<pre>";
	print_r(getenv());
	$_ENV['divya'] = 'srinivas';
	print_r($_ENV);
?>