<?php include_once('connect.php'); ?>

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
            <div class="col-4 mx-auto ">
                <div class="card ">
                    <div class="card-header">
                        <h3 class="fw-bold">Choose Payment Method</h3>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="" class="list-group-item list-group-item-action disabled">Wallet</a>
                            <a href="" class="list-group-item list-group-item-action disabled">Payments</a>
                            <a href="make_payment.php?type=cod" class="list-group-item list-group-item-action fw-bold">Cash On Delivery (COD) </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>


<?php

if(isset($_GET['type'])){
    $type =$_GET['type'];

    if($type == "cod"){
        // update order record
        if($myOrder['address_id'] != NULL){
            $order_id = $myOrder['order_id'];
            $query = mysqli_query($connect,"UPDATE orders set is_ordered='1' where user_id='$user_id' and order_id='$order_id'");
            echo "<script>window.open('order_done.php','_self')</script>";
        }
        else{
            echo "<script>alert('please select address first')</script>";
            echo "<script>window.open('checkout.php','_self')</script>";
        }
    }
}