<?php
include_once('connect.php');

if(!isset($_GET['book_id'])){
    echo "<script>window.open('index.php','_self')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include_once('header.php') ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <div class="list-group">
                    <a href="index.php?cat_id= <?= $row['cat_id']; ?>" class="list-group-item list-group-item-action active">Categories</a>

                    <?php
                    $q = mysqli_query($connect, "SELECT * FROM categories");
                    while ($row = mysqli_fetch_array($q)) :
                    ?>
                        <a href="" class="list-group-item list-group-item-action">
                            <?= $row['cat_title']; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="col-9">
                <?php
                $book_id = $_GET['book_id'];


                $q = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id WHERE id = '$book_id'");
                $data = mysqli_fetch_array($q);

                ?>
                <div class="row">

                    <div class="col-3">
                        <div class="card">
                            <img src="<?= "images/" . $data['cover_image']; ?>" alt="" class="w-100" style='height:300px;object-fit:cover;'>
                        </div>
                    </div>
                    <div class="col-9">
                        <table class="table">
                            <tr>
                                <th>Title</th>
                                <td><?= $data['title']; ?></td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td><?= $data['cat_title']; ?></td>
                            </tr>
                            <tr>
                                <th>Number of pages</th>
                                <td><?= $data['no_of_page']; ?></td>
                            </tr>
                            <tr>
                                <th>Author</th>
                                <td><?= $data['author']; ?></td>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <td><?= $data['isbn']; ?></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <th class="d-flex align-items-center">
                                    <h2 class="text-danger h1">Rs.<?= $data['discount_price'];  ?></h2>
                                    <del>
                                        <h3 class="text-secondary h6 ">Rs.<?= $data['price'];  ?></h3>
                                    </del>

                                </th>
                            </tr>
                        </table>
                        <div class="d-flex gap-2">
                            <a href="" class="btn btn-success btn-lg">Buy now</a>
                            <a href="cart.php?book_id=<?= $data['id'];?>&atc=true" class="btn btn-warning btn-lg">Add to cart</a>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="card">
                        <div class="card-header">
                            <h5>Description</h5>
                        </div>
                        <div class="card-body">
                            <p><?= $data['description']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 my-4">
                        <h2>Related books</h2>
                    </div>
                    <?php
                    
                    $q = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id where id <> '$book_id'");

                    $count = mysqli_num_rows($q);
                    if($count < 1){
                        echo "<h1 class='display-3'>Not found any book</h1>";
                    }


                    while ($data = mysqli_fetch_array($q)):
                    ?>
                        <div class="col-2">
                            <div class="card">
                                <img src="<?= "images/".$data['cover_image']; ?>" alt="" class="w-100" style = 'height:150px;object-fit:cover;'>
                                <div class="card-body">
                                    <h2 class="h6 text-truncate small" title="<?= $data['title']; ?>"> <?= $data['title']; ?></h2>
                                    <a href="view_book.php?book_id=<?= $data['id']; ?>" class="btn btn-info btn-sm">View</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>


            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>