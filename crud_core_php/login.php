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
    <?php
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'testing';
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
          $conn = new mysqli($servername,$username,$password,$database);
        }catch(Exception $ex){
          echo "connection failed: ".$ex->getMessage();
          exit;
        }
        if(isset($_POST['login'])){
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $password = mysqli_real_escape_string($conn,$_POST['password']);
            $sql = "SELECT * FROM users WHERE email='$username' AND password='$password'";
            $exec= $conn->query($sql);
            if($exec->num_rows > 0){
                $name = $exec->fetch_object()->username;
                echo '<div class="alert alert-success" role="alert">Successfully logged in.</div>';
                print_r($name);
            }else{
                echo '<div class="alert alert-danger" role="alert">Something went wrong.</div>';
            }
        }
    ?>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Login</h5>
                        <form action="sql_injection.php" method="POST">
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
                        <div class="text-center mt-3">
                            <a href="#">Forgot Password?</a>
                        </div>
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
