<?php include_once('connect.php');

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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php
    include_once('header.php');

    // calling orders and order items here
    $user_id = $getUser['user_id'];
    $order = mysqli_query($connect, "SELECT * FROM orders LEFT JOIN coupon ON orders.coupon_id = coupon.c_id WHERE user_id='$user_id' AND is_ordered='0'");
    $myOrder = mysqli_fetch_array($order);
    $count_myOrder = mysqli_num_rows($order);

    ?>

    <div class="container p-5">
        <div class="row">
            <div class="col-7 mx-auto ">
                <div class="card bg-success text-white">
                   <div class="card-body">
                            <img width="50 " class="mb-3" height="50" src="https://img.icons8.com/ios-filled/50/FFFFFF/checked--v1.png" alt="checked--v1"/>
                            <h1>WOW! Order Placed Successfully</h1>
                            <p>Click here to see <a href="my_order.php" class="text-white">My Order</a> page to know more details</p>
                            
                            <div class="d-flex justify-content-end">
                                <a href="my_order.php" class="btn btn-light">My Order</a>
                            </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
