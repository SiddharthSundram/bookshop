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
    <title>Insert Books | Admin | Bookshop</title>
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
                    <div class="col-12 d-flex justify-content-between ">
                        <h2 class="text-white">Insert Books </h2>
                        <a href="mannage_books.php" class="btn btn-light ">Go Back</a>
                    </div>
                </div>
                <div class="row">
                <div class="card">
                <div class="card-header">
                    <h5>Insert Book Details</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                   <div class="row">
                   <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                    </div>
                   <div class="mb-3 col-6">
                            <label for="author">Author</label>
                            <input type="text" name="author" id="author" class="form-control">
                        </div>
                     <div class="mb-3 col-6">
                            <label for="no_of_page">No_of_page</label>
                            <input type="text" name="no_of_page" id="no_of_page" class="form-control">
                        </div>
                   </div>
                    
                    <div class="row">
                        
                    <div class="mb-3 col">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" class="form-control">
                        </div>

                        <div class="mb-3 col">
                            <label for="discount_price">Discount_price</label>
                            <input type="text" name="discount_price" id="discount_price" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                    <div class="mb-3 col">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="science">Category Here</option>
                                
                                <!-- Add more categories as needed -->
                                <?php
                                $query =mysqli_query($connect,"select *from categories");
                                while($row = mysqli_fetch_array($query)){
                                    $cat_id =$row['cat_id'];
                                    $cat_title =$row['cat_title'];
                                    echo "<option value ='$cat_id'>$cat_title</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3 col">
                            <label for="nos">Qty</label>
                            <input type="text" name="nos" id="nos" class="form-control">
                        </div>
                        <div class="mb-3 col">
                            <label for="cover_image">Cover_image</label>
                            <input type="file" name="cover_image" id="cover_image" class="form-control">
                        </div>
                        </div>
                        <div class="mb-3">
                            <label for="isbn">isbn</label>
                            <input type="text" name="isbn" id="isbn" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="description">description</label>
                            <textarea rows ="4" type="text" name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="create_book" class="btn btn-success w-100" value="Insert Book">
                        </div>
                        <!-- Add more fields for book details here -->
                    </form>

                    
                    <?php
                        if(isset($_POST['create_book'])){
                            $title = $_POST['title'];
                            $author = $_POST['author'];
                            $isbn = $_POST['isbn'];
                            $description = $_POST['description'];
                            $price = $_POST['price'];
                            $discount_price = $_POST['discount_price'];
                            $category = $_POST['category'];
                            $qty = $_POST['nos'];
                            $no_of_page = $_POST['no_of_page'];

                            // Image handling
                            $cover_image = $_FILES['cover_image']['name'];
                            $tmp_cover_image = $_FILES['cover_image']['tmp_name'];
                            move_uploaded_file($tmp_cover_image, "../images/$cover_image");

                            $query = mysqli_query($connect, "INSERT INTO books (title, author, isbn, description, price, discount_price, category, nos, no_of_page, cover_image) VALUES ('$title', '$author', '$isbn', '$description', '$price', '$discount_price', '$category', '$qty', '$no_of_page', '$cover_image')");

                            if($query){
                                echo "<script>window.open('mannage_books.php','_self')</script>"; // Added the closing parenthesis for window.open
                            } else {
                                echo "<script>alert('Failed')</script>";
                            }
                        }
                    ?>

                </div>
            </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>