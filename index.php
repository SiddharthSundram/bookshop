<?php
include_once('connect.php');

if (!isset($_SESSION['account'])) {
    echo "<script>window.open('login.php','_self')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include_once('header.php') ?>

    <div class="bg-success text-white w-100 position-relative" style="
        height: 400px;
        background-image: url('https://cdn.wallpapersafari.com/63/99/HvnCaw.jpg'); 
        background-position: center; 
        background-repeat: no-repeat; 
        background-size: cover; 
        ">
        <!-- Black overlay using ::before pseudo-element -->
        <div class="position-absolute w-100 h-100" style="background-color: rgba(0, 0, 0, 0.5);"></div>

        <div class="container d-flex flex-column justify-content-center align-items-center position-relative">
            <h1 class="mt-3 mb-3">Explore Any Books</h1>
            <form action="index.php" method="get" class="d-flex justify-conten-center flex-column gap-4">
                <input type="search" name="search" class="form-control form-control-lg" size="70">
                <input type="submit" class="btn btn-dark btn-lg" name="find">
            </form>
        </div>
    </div>


    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="index.php?cat_id= <?= $row['cat_id']; ?>" class="list-group-item list-group-item-action active">Categories</a>

                    <?php
                    $q = mysqli_query($connect, "SELECT * FROM categories");
                    while ($row = mysqli_fetch_array($q)) :
                    ?>
                        <a href="index.php?cat_id=<?= $row['cat_id']; ?>" class="list-group-item list-group-item-action">
                            <?= $row['cat_title']; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="col-9">
                <div class="row">
                    <?php
                    if (isset($_GET['find'])) {
                        $search = $_GET['search'];
                        $q = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id WHERE title LIKE '%$search%' ");
                    } else {
                        if (isset($_GET['cat_id'])) {
                            $cat_id = $_GET['cat_id'];
                            $q = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id WHERE cat_id = '$cat_id' ");
                        } else {
                            $q = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id");
                        }
                    }

                    $count = mysqli_num_rows($q);
                    if ($count < 1) {
                        echo "<h1 class='display-3'>Not found any book</h1>";
                    }


                    while ($data = mysqli_fetch_array($q)) :
                    ?>
                        <div class="col-3">
                            <div class="card">
                                <img src="<?= "images/" . $data['cover_image']; ?>" alt="" class="w-100" style='height:300px;object-fit:cover;'>
                                <div class="card-body">
                                    <h2 class="h5">Rs. <?= $data['discount_price'];  ?>/- <del><?= $data['price']; ?>/-</del></h2>
                                    <h2 class="h6 text-truncate" title="<?= $data['title']; ?>"> <?= $data['title']; ?></h2>
                                    <h2 class="h6 text-truncate" title="<?= $data['author']; ?>"> By - <?= $data['author']; ?></h2>
                                    <span class="bg-success text-white badge"> <?= $data['cat_title']; ?> </span>
                                    <a href="view_book.php?book_id=<?= $data['id']; ?>" class="btn btn-info">View</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>


            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>