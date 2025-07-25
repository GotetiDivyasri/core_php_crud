<?php
    session_start();
    require_once 'db_connection.php';
     if(!isset($_SESSION['user_data'])){
        header('Location:login.php');
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE id='$id'";
        $exec = $conn->query($sql);
        $user = $exec->fetch_object();
    }
    if(isset($_POST['submit-btn'])){

        //for image update
        $uid = $_POST['uid'];
        $sql_id = "SELECT * FROM users WHERE id='$uid'";
        $exec_data = $conn->query($sql_id);
        $user_dt = $exec_data->fetch_object();
        if (isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic']['name'])) {
            $path = 'uploads/';
            $extension = pathinfo($_FILES['profile_pic']['name'],PATHINFO_EXTENSION);
            $file_name = $_FILES['profile_pic']['name'];
            // $file_name = $_FILES['profile_pic']['name'] .'_'. date('YmdHis').'.'.$extension;
            $profile = (file_exists($_FILES['profile_pic']['tmp_name'])) ? $file_name : '';
        } else {
            // If no new file is uploaded, retain the existing profile picture
            $profile = $user_dt->profile_picture; 
        }


        
        $insert_data = [
            'first_name' =>$_POST['first_name'],
            'last_name' =>$_POST['last_name'],
            'email' =>$_POST['email'], 
            'username' =>$_POST['username'],
            'password' =>md5($_POST['password']),
            'mobile_number' =>$_POST['contact'],
            'gender' =>$_POST['gender'],
            'address' =>$_POST['address'],
            'state' =>$_POST['state'],
            'profile_picture' =>$profile,
            'hobbies' =>implode(',',$_POST['hobbies']),
        ];
        $cols = implode(',', array_keys($insert_data));
        $vals = implode("','", array_values($insert_data));
        if (isset($_POST['uid'])) {
            $set_clause = [];
            foreach ($insert_data as $column => $value) {
                $set_clause[] = "$column='" . $conn->real_escape_string($value) . "'";
            }
            $set_clause = implode(', ', $set_clause);
            $sql = "UPDATE users SET $set_clause WHERE id='$uid'";
        } else {
            $sql = "INSERT INTO users ($cols) VALUES ('$vals')";
        }
        
        $insert = $conn->query($sql);
        if($insert){
            if(!is_null($profile)){
                if (!empty($_FILES['profile_pic']['name'])) {
                 move_uploaded_file($_FILES['profile_pic']['tmp_name'],$path.$file_name);
               }
            }
            if(isset($uid)){
                echo '<div class="alert alert-success" role="alert">Data Updated successfully.</div>';
            }else{
                echo '<div class="alert alert-success" role="alert">Data Inserted successfully.</div>';
            }
        }else{
            echo '<div class="alert alert-danger" role="alert">Something went wrong.</div>';
            header("refresh:3;url=registration.php");
        }
        // echo '<pre>'; 
        // print_r($insert_data);die;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
     <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* Card shadow */
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Transition effects */
        .transition-all {
            transition: all 0.3s ease;
        }
        
        /* Button hover effects */
        .btn-hover:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        /* Responsive table */
        @media (max-width: 768px) {
            .responsive-table thead {
                display: none;
            }
            .responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            }
            .responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
                text-align: right !important;
                border-bottom: 1px solid #e2e8f0;
            }
            .responsive-table td::before {
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
                margin-right: auto;
                color: #4a5568;
            }
            .responsive-table td:last-child {
                border-bottom: 0;
            }
        }
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            margin-top: 100px;
        }
        .login-card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-row {
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header with logout button -->
    <header class="bg-indigo-600 text-white py-4 px-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">
                <!-- <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c9462ab0-a728-41b3-9a31-381e45dac6d4.png" alt="Contact Management System logo with modern minimalist design in white text" /> -->
            </h1>
            <button id="logoutBtn" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-medium hover:bg-indigo-50 transition-all btn-hover">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </button>
        </div>
    </header>
    <main class="container mx-auto py-8 px-4 md:px-6">
        <!-- Page title and actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4 md:mb-0">Add User</h2>
            <a class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-all btn-hover" href="view.php">
                <!-- <i class="fas fa-plus mr-2"></i> -->
                Back
            </a>
        </div>
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card login-card">
                        <div class="card-body">
                            <form action="registration.php" method="POST" enctype="multipart/form-data">
                                <div class="form-row">
                                    <input type="hidden" class="form-control" id="uid" name="uid" value="<?= isset($user->id) ? $user->id:''?>">
                                    <div class="form-group col-md-6">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= isset($user->first_name) ? $user->first_name:''?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?= isset($user->last_name) ? $user->last_name:''?>" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= isset($user->email) ? $user->email:''?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= isset($user->username) ? $user->username:''?>" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" value="<?= isset($user->password) ? $user->password:''?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="contact">Contact Number</label>
                                        <input type="tel" class="form-control" id="contact" name="contact" value="<?= isset($user->mobile_number) ? $user->mobile_number:''?>" required>
                                    </div>
                                    <!-- <div class="form-group col-md-6">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    </div> -->
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="state">State</label>
                                        <select class="form-control" id="state" name="state" value="<?= isset($user->state) ? $user->state:''?>" required>
                                            <option value="">Select State</option>
                                            <option value="andhra pradesh" <?= ($user->state == 'andhra pradesh') ? 'Selected':''?>>Andhra Pradesh</option>
                                            <option value="telangana" <?= ($user->state == 'telangana') ? 'Selected':''?>>Telangana</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Gender</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?= (isset($user->gender) && $user->gender == 'male') ? 'Checked':''?>>
                                            <label class="form-check-label" for="male">Male</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?= (isset($user->gender) && $user->gender == 'female') ? 'Checked':''?>>
                                            <label class="form-check-label" for="female">Female</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required><?= isset($user->address) ? $user->address:''?></textarea>
                                </div>
                                <div class="form-row">
                                    
                                    <div class="form-group col-md-6">
                                        <label for="profile_pic">Profile Picture</label>
                                        <input type="file" class="form-control-file" id="profile_pic" name="profile_pic"> 
                                    </div>
                                    <?php
                                        if(isset($user->profile_picture)){ 
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label for="profile_pic">Previous Profile Picture</label>
                                        <img src="<?= 'uploads/'.$user->profile_picture ?>" width="50px" height="50px"> 
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label>Hobbies</label>
                                    <?php 
                                        if(isset($user->hobbies)){
                                            $hobbies = explode(',', $user->hobbies);
                                        }
                                    ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="travel" name="hobbies[]" value="travel"
                                        <?= isset($hobbies) && in_array('travel', $hobbies) ? 'Checked':''?>>
                                        <label class="form-check-label" for="travel">Travelling</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="music" name="hobbies[]" value="music" <?= isset($hobbies) && in_array('music', $hobbies) ? 'Checked':''?>>
                                        <label class="form-check-label" for="music">Music</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="coding" name="hobbies[]" value="coding" <?= isset($hobbies) && in_array('coding', $hobbies) ? 'Checked':''?>>
                                        <label class="form-check-label" for="coding">Coding</label>
                                    </div>
                                </div>
                                <button type="submit" name="<?= isset($user)?'submit-btn':'update-btn'?>" class="btn btn-primary bg-indigo-600 text-white w-full py-2 rounded-md hover:bg-indigo-700 transition-all mt-4">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
