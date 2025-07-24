<?php
	session_start();
	if(isset($_POST['submit-btn'])){
		$path = 'uploads/';
		$path = $path . basename($_FILES['files']['name']);
		$allowed_extensions = [
			'png',
			'jpg',
			'jpeg'
		];
		$file_extension = pathinfo($_FILES['files']['tmp_name'], PATHINFO_EXTENSION);
		if(!file_exists($_FILES['files']['tmp_name'])){
			$response = [
				'type' => 'danger',
				'msg' => 'Please select file to upload'
			];
		}elseif(!in_array($file_extension, $allowed_extensions)){
			$response = [
				'type' => 'danger',
				'msg' => 'Upload valid images'
			];
		}elseif($_FILES['files']['size'] > 2000000){
			$response = [
				'type' => 'danger',
				'msg' => 'File size is more than 2mb.'
			];
		}else{
			if(move_uploaded_file($_FILES['files']['tmp_name'], $path)){
				$response = [
					'type' => 'success',
					'msg' => 'Image uploaded successfully'
				];
			}else{
				$response = [
					'type' => 'danger',
					'msg' => 'Something went wrong!'
				];
			}
		}
		
	}
	if(!empty($response)){
		echo '<div class="alert alert-'. $response['type'].'" role="alert">'
				  .$response['msg'] .
				'</div>';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HTTPS</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
	<form method="POST" enctype="multipart/form-data">
		<fieldset style="width:20rem;">
			<legend>Personal Details</legend>
			<label>Name</label>
			<input type="text" name="name" id="name"><br><br>
			<label>Email</label>
			<input type="email" name="email" id=email><br><br>
			<label>DOB</label>
			<input type="date" name="dob" id=dob><br><br>
			<label>Enter your marks</label>
			<input type="number" name="marks"><br><br>
			<label>Profile</label>
			<input type="file" name="files"> 
			<input type="submit" name="submit-btn">
		</fieldset>
	</form>
	<fieldset>
		<?php
			// echo "<pre>";
			// print_r($_REQUEST);
			// $marks = $_REQUEST['marks'];
			// switch ($marks) {
			// 	case $marks > 35 :
			// 		echo "failed";
			// 		break;
			// 	case $marks > 35 & $marks < 70:
			// 		echo "second class";
			// 		break;
			// 	case $marks > 70:
			// 		echo "first class";
			// 		break;
			// 	default:
			// 		echo "give me valid value";
			// 		break; 
			// }

			// if($_REQUEST['marks'] < 35){
			// 	echo "failed";
			// }elseif ($_REQUEST['marks'] > 35 && $_REQUEST['marks'] < 70) {
			// 	echo "second class - PASS";
			// }else{
			// 	echo "first class - PASS";
			// }

			//print_r($_FILES);
		?>
	</fieldset>
</body>
</html>

<?php
	// $a=10;
	// $b=20;
	// function adding_numbers(){
	// 	$GLOBALS['adding_num'] = $GLOBALS['a'] + $GLOBALS['b'];
	// }
	// adding_numbers();
	// echo $adding_num;
?>