<?php
    include_once "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Bookshop</title>
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
                    <div class="card-header"><h2>Create an Account</h2></div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="">Name:</label>
                                <input type="text" name="name" class="w-100" placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label for="">Email:</label>
                                <input type="email" name="email" class="w-100" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label for="">Password:</label>
                                <input type="password" name="password" class="w-100" placeholder="Enter your password">
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="create" value="Sign up" class="btn btn-success w-100">
                            </div>
                        </form>
                        <?php
                            if(isset($_POST['create'])){
                                $name = $_POST['name'];
                                $email = $_POST['email'];
                                $password = $_POST['password'];


                                $query = mysqli_query($connect, "INSERT INTO accounts (name, email, password) VALUES ('$name', '$email', '$password')");

                                if($query){
                                    echo "<script>window.open('login.php','_self')</script>";
                                }
                                else{
                                    echo "<script>alert('failed')</script>";
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