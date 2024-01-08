<?php
include_once "../connect.php";
if (!isset($_SESSION['admin'])) {
    echo "<script>window.open('../login.php','_self')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mannage categories | Admin | Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body class="bg-secondary">
    <?php include_once "./admin_header.php";  ?>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-3">
                <?php include_once "sidebar.php"; ?>
            </div>

            <div class="col-9">
                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="text-white">Mannage categories</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Insert Category Details</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="cat_title">Category title</label>
                                        <input type="text" name="cat_title" id="cat_title" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" name="create_category" class="btn btn-primary w-100" value="Insert Category">
                                    </div>
                                    <!-- Add more fields for category details here -->
                                </form>
                                <?php
                                if (isset($_POST['create_category'])) {
                                    $cat_title = $_POST['cat_title'];
                                    $query = mysqli_query($connect, "INSERT INTO categories (cat_title) VALUES ('$cat_title')");
                                    if ($query) {
                                        echo "<script>window.open('insert_book.php','_self')</script>"; // Added the closing parenthesis for window.open
                                    } else {
                                        echo "<script>alert('Failed')</script>";
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-9">

                        <table class="table bg-light table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>cat_title</th>
                                    <th>action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $callingCategories = mysqli_query($connect, "SELECT * FROM categories");
                                while ($data = mysqli_fetch_array($callingCategories)) :
                                ?>

                                    <tr>
                                        <td><?= $data['cat_id']  ?></td>
                                        <td><?= $data['cat_title']  ?></td>
                                        <td>
                                            <a href="mannage_category.php?c_id=<?= $data['cat_id']; ?>" class="btn btn-danger">X</a>
                                            <a href="" class="btn btn-info">Edit</a>
                                            <a href="" class="btn btn-success">View</a>
                                        </td>

                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>

<?php
    if(isset($_GET['c_id'])){
        $id = $_GET['c_id'];

        $query = mysqli_query($connect,"DELETE from categories where cat_id='$id'");

        if($query){
            echo "<script>window.open('mannage_category.php','_self')</script>";
        }
        else{
            echo "<script>alert('failed to delete')</script>";

        }
    }