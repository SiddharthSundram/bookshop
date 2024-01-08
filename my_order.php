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
    <?php include_once('header.php'); ?>


    <div class="container p-5">
        <div class="row ">
            <?php
                // calling orders and order items here
                $user_id = $getUser['user_id'];
                $order = mysqli_query($connect, "SELECT * FROM orders LEFT JOIN coupon ON orders.coupon_id=coupon.c_id WHERE user_id='$user_id' AND is_ordered='1'");
                $count_myOrder = mysqli_num_rows($order);
            ?>

            <div class="col-12">
                <h1>My Order (<?= $count_myOrder; ?>)</h1>

                <div class="row">
                    <?php
                    while ($myOrder = mysqli_fetch_array($order)) :

                    ?>
                        <div class="col-12 mb-2">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <span>Order Id: <?= $myOrder['order_id']; ?> </span>

                                    <?= ($myOrder['coupon_id']) ? "<span>Couopn : " . $myOrder['coupon_code'] . "</span>" : NULL; ?>

                                </div>
                                <div class="card-body ">
                                    <!-- Items -->
                                    <?php
                                    if ($count_myOrder > 0) :
                                        $myOrderId =  $myOrder['order_id'];
                                        // getting order items
                                        $myOrderItems = mysqli_query($connect, "SELECT * from order_items JOIN books ON order_items.book_id= books.id where order_id='$myOrderId' ");
                                        $count_order_items = mysqli_num_rows($myOrderItems);
                                        $total_amount = 0;
                                        $total_discounted_amount = 0;

                                        while ($myItems = mysqli_fetch_array($myOrderItems)) :

                                            $price = $myItems['qty'] * $myItems['price'];
                                            $discount_price = $myItems['qty'] * $myItems['discount_price'];

                                    ?>

                                            <div class="row  border mb-3 ">
                                                <div class="col-1">
                                                    <img src="images/<?= $myItems['cover_image']; ?>" class="w-100" alt="">
                                                </div>
                                                <div class="col-10">
                                                    <h2 class="h6 text-truncate"><?= $myItems['title']; ?></h2>
                                                    <h4>Price :
                                                        <span class="text-success">Rs.<?= $myItems['discount_price']; ?></span>
                                                        <del class="text-muted small">Rs.<?= $myItems['price']; ?></del>
                                                    </h4>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex">
                                                            <span class="btn btn-lg">Qty: <?= $myItems['qty']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php

                                            $total_amount += $price;
                                            $total_discounted_amount += $discount_price;

                                        endwhile;
                                        $amount_before_tax = $total_amount - $total_discounted_amount;
                                        $tax = $total_discounted_amount * 0.18;
                                        $coupon_amount = $myOrder['coupon_amount'];

                                        $total_payable_amount = $total_discounted_amount + $tax;

                                        if ($myOrder['coupon_id']) {
                                            $total_payable_amount = $total_payable_amount - $coupon_amount;
                                        } else {
                                            $total_payable_amount;
                                        }
                                    endif; ?>
                                    <!-- end items -->
                                </div>
                                <div class="card-footer">
                                    <h6 class="text-danger">Total Amount : Rs.<?= $total_payable_amount; ?></h6>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>


</body>

</html>