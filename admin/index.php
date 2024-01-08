<?php
    include_once "../connect.php";
    if(!isset($_SESSION['admin'])){
        echo "<script>window.open('../login.php','_self')</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="bg-secondary">
    <?php include_once "./admin_header.php";  ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <?php include_once "sidebar.php"; ?>
            </div>

            <div class="col-9">
                <div class="row">
                    <div class="col-4">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <h2>
                                    <?php
                                      echo $countBooks = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM books"));

                                    ?>
                                </h2>
                                <h4>Total Books</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h2>
                                    <?php
                                      echo $countBooks = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM categories"));

                                    ?></h2>
                                <h4>Total Categories</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h2>
                                    <?php
                                      echo $countBooks = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM accounts"));

                                    ?></h2>
                                <h4>Total User</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</body>
</html>