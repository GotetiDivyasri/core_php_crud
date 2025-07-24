<?php 
	function factorial_res($x){
		if($x <= 0){
			return 1;
		}else{
			return($x * factorial_res($x-1));
		}
	}
	$res = factorial_res(4);
	echo $res;
?>