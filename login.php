<?php
    include_once "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <?php
        include_once "header.php";
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4 mt-5 " >
                <div class="card">
                    <div class="card-header"><h2>Login Here</h2></div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="">Email:</label>
                                <input type="email" name="email" class="w-100" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label for="">Password:</label>
                                <input type="password" name="password" class="w-100" placeholder="Enter your password">
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="login" value="Sign in" class="btn btn-success w-100">
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['login'])){
                                $email = $_POST['email'];
                                $password = $_POST['password'];


                                $query = mysqli_query($connect, "SELECT * FROM accounts WHERE email='$email' AND password='$password'");
                                $count = mysqli_num_rows($query);

                                $checkAccessLevel = mysqli_fetch_array($query);

                                if($count > 0){
                                    $_SESSION['account'] = $email;

                                    if($checkAccessLevel['isAdmin'] == 1){
                                        $_SESSION['admin'] = $email;
                                        echo "<script>window.open('admin/index.php','_self')</script>";
                                    }
                                    else{
                                        echo "<script>window.open('index.php','_self')</script>";
                                    }
                                }
                                else{
                                    echo "<script>alert('user name or password is invalid')</script>";
                                }
                            }

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>