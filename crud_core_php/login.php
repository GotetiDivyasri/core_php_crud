<?php
    session_start();
    require_once 'db_connection.php';
    if(isset($_POST['login'])){
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,md5($_POST['password']));
        $sql = "SELECT * FROM admins WHERE email='$username' AND password='$password'";
        $exec= $conn->query($sql);
        if($exec->num_rows > 0){
            $_SESSION['user_data'] = $exec->fetch_object();
            echo '<div class="alert alert-success" role="alert">Successfully logged in.</div>';
            header("Refresh:1;url=view.php");
        }
    }
    if(isset($_SESSION['user_data'])){
        header("Location:view.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Login</h5>
                        <?php
                            if(isset($_POST['login'])){
                                if(isset($_SESSION['user_data'])){
                                    echo '<div class="alert alert-success" role="alert">Welcome '. $_SESSION['user_data']->name . ' .</div>';
                                }elseif($exec->num_rows < 1){
                                    echo '<div class="alert alert-danger" role="alert">Email or password is invalid.</div>';
                                }
                            }
                        ?>
                        <form action="login.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <!-- <div class="text-center mt-3">
                            <a href="#">Forgot Password?</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
