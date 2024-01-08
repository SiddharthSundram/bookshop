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
    <?php include_once('header.php');


    // calling orders and order items here
    $user_id = $getUser['user_id'];
    $order = mysqli_query($connect, "SELECT * FROM orders LEFT JOIN coupon ON orders.coupon_id= coupon.c_id WHERE user_id='$user_id' AND is_ordered='0'");
    $myOrder = mysqli_fetch_array($order);
    $count_myOrder = mysqli_num_rows($order);


    ?>


    <div class="container p-5">
        <div class="row ">
            <?php
            if ($count_myOrder > 0) :
                $myOrderId =  $myOrder['order_id'];
                // getting order items
                $myOrderItems = mysqli_query($connect, "SELECT * from order_items JOIN books ON order_items.book_id= books.id where order_id='$myOrderId' ");
                $count_order_items = mysqli_num_rows($myOrderItems);

                if ($count_order_items) :

            ?>

                    <div class="col-9">
                        <h1>My Cart (<?= $count_order_items ?>)</h1>

                        <div class="row">
                            <?php
                            $total_amount = 0;
                            $total_discounted_amount = 0;

                            while ($order_item = mysqli_fetch_array($myOrderItems)) :

                                $price = $order_item['qty'] * $order_item['price'];
                                $discount_price = $order_item['qty'] * $order_item['discount_price'];

                            ?>
                                <div class="col-12 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">

                                                    <img src="images/<?= $order_item['cover_image']; ?>" class="w-100" alt="">

                                                </div>
                                                <div class="col-10">
                                                    <h2 class="h6 text-truncate"><?= $order_item['title']; ?></h2>
                                                    <h4>Price :
                                                        <span class="text-success">Rs.<?= $order_item['discount_price']; ?></span>
                                                        <del class="text-muted small">Rs.<?= $order_item['price']; ?></del>
                                                    </h4>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex">
                                                            <a href="cart.php?book_id=<?= $order_item['id']; ?>&dfc=true" class="btn btn-danger btn-lg">-</a>
                                                            <span class="btn btn-lg"><?= $order_item['qty']; ?></span>
                                                            <a href="cart.php?book_id=<?= $order_item['id']; ?>&atc=true" class="btn btn-success btn-lg">+</a>
                                                        </div>

                                                        <a href="cart.php?delete_item=<?= $order_item['oi_id']; ?>" class="btn btn-dark btn-lg ">Delete</a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $total_amount += $price;
                                $total_discounted_amount += $discount_price;

                            endwhile; ?>
                        </div>

                    </div>

                    <div class="col-3">
                        <h2>Price Break :</h2>
                        <div class="list-group">
                            <span class="list-group-item list-group-item-action bg-white d-flex justify-content-between ">
                                <span>Total Amount</span>
                                <span><?= $total_amount ?></span>
                            </span>
                            <span class="list-group-item list-group-item-action bg-success d-flex justify-content-between text-white">
                                <span>Total Discount</span>
                                <span><?= $amount_before_tax = $total_amount - $total_discounted_amount; ?></span>
                            </span>
                            <span class="list-group-item list-group-item-action bg-whote d-flex justify-content-between ">
                                <span>Total TAX (GST)</span>
                                <span><?= $tax = $total_discounted_amount * 0.18; ?></span>
                            </span>


                            <?php
                            if ($myOrder['coupon_id']) :
                            ?>
                                <span class="list-group-item list-group-item-action bg-warning text-dark">
                                    <div class="d-flex justify-content-between">
                                            <span>Coupon Discount</span>
                                            <span><?= $coupon_amount = $myOrder['coupon_amount']; ?></span>
                                    </div>
                                    <div class=" d-flex  gap-4 bg-white align-items-center rounded px-3">
                                        <small class="fw-bolder">Coupon Applied -  <?=  $myOrder['coupon_code']; ?> </small>
                                        <a href="cart.php?remove_coupon=<?= $myOrder['order_id']; ?>" class="text-decoration-none text-danger">X</a>
                                    </div>
                                </span>


                            <?php endif; ?>


                            <span class="list-group-item list-group-item-action bg-danger d-flex justify-content-between text-white">
                                <span>Payable Amount</span>
                                <span>
                                    <?php
                                     $total_payable_amount = $total_discounted_amount + $tax;
                                     
                                     if($myOrder['coupon_id']){
                                        echo $total_payable_amount - $coupon_amount;
                                     }
                                     else{
                                        echo $total_payable_amount;
                                     }
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div class="d-flex mt-5 justify-content-between ">
                            <a href="" class="btn btn-dark btn-lg">Go back</a>
                            <a href="checkout.php" class="btn btn-primary btn-lg">Checkout</a>  
                        </div>

                        <?php
                            if (!$myOrder['coupon_id']) :
                        ?>

                            <div class="mb-3">
                                <form action="" method="post" class="d-flex mt-5">
                                    <input type="text" placeholder="Enter coupon code" name="code" class="form-control">
                                    <input type="submit" class="btn btn-dark" value="Apply" name="apply">
                                </form>
                            </div>
                        <?php endif; ?>

                    </div>

                <?php endif; else : ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2>Sorry your cart is Empty...</h2>
                            <a href="index.php" class="btn btn-dark">Shop Now</a>
                        </div>
                    </div>
                </div>

            <?php     endif;  ?>
        </div>
    </div>


</body>

</html>


<?php
    // add to cart
    if (isset($_GET['book_id']) && isset($_GET['atc'])) {

        // check user login or not
        if (!isset($_SESSION['account'])) {
            echo "<script>window.open('login.php','_self')</script>";
        }

        // if login

        $book_id = $_GET['book_id'];
        $user_id = $getUser['user_id'];

        // check order is already exist or not
        $check_order = mysqli_query($connect, "SELECT * from orders where user_id='$user_id' and is_ordered='0'");
        $count_check_order = mysqli_num_rows($check_order);

        if ($count_check_order < 1) {
            // not exist prev order that's why we need to create a new order in the order table
            $create_order = mysqli_query($connect, "INSERT into orders (user_id) value ('$user_id')");
            $created_order_id = mysqli_insert_id($connect);

            // inserting new order item 
            $create_order_item = mysqli_query($connect, "INSERT into order_items (order_id,book_id) value('$created_order_id','$book_id')");
        } else {
            // already exist order work
            $current_order = mysqli_fetch_array($check_order);
            $current_order_id = $current_order['order_id'];

            // checking order item id already exist or not
            $check_order_item = mysqli_query($connect, "SELECT * from order_items where (order_id='$current_order_id' and book_id='$book_id') ");

            $current_order_item = mysqli_fetch_array($check_order_item);
            $count_current_order_item = mysqli_num_rows($check_order_item);

            if ($count_current_order_item > 0) {
                // only need to update qty of items in order items table
                $current_order_item_id = $current_order_item['oi_id'];
                $query_for_qty_update = mysqli_query($connect, "UPDATE order_items set qty=qty+1 where oi_id='$current_order_item_id'");
            } else {
                $create_order_item = mysqli_query($connect, "INSERT into order_items (order_id,book_id) value('$current_order_id','$book_id')");
            }
        }

        // refresh page
        echo "<script>window.open('cart.php','_self')</script>";
    }


    // delete from cart
    if (isset($_GET['book_id']) && isset($_GET['dfc'])) {

        // check user login or not
        if (!isset($_SESSION['account'])) {
            echo "<script>window.open('login.php','_self')</script>";
        }

        // if login

        $book_id = $_GET['book_id'];
        $user_id = $getUser['user_id'];

        // check order is already exist or not
        $check_order = mysqli_query($connect, "SELECT * from orders where user_id='$user_id' and is_ordered='0'");
        $count_check_order = mysqli_num_rows($check_order);

        // already exist order work
        $current_order = mysqli_fetch_array($check_order);
        $current_order_id = $current_order['order_id'];

        // checking order item id already exist or not
        $check_order_item = mysqli_query($connect, "SELECT * from order_items where (order_id='$current_order_id' and book_id='$book_id')");

        $current_order_item = mysqli_fetch_array($check_order_item);
        $count_current_order_item = mysqli_num_rows($check_order_item);

        if ($count_current_order_item > 0) {
            // only need to update qty of items in order items table
            $current_order_item_id = $current_order_item['oi_id'];

            $qty = $current_order_item['qty'];
            if ($qty <= 1) {
                $delete_query_for_order_item = mysqli_query($connect, "DELETE from order_items  where oi_id='$current_order_item_id'");
            } else {
                $query_for_qty_update = mysqli_query($connect, "UPDATE order_items set qty=qty-1 where oi_id='$current_order_item_id'");
            }
        }


        // refresh page
        echo "<script>window.open('cart.php','_self')</script>";
    }

        if (isset($_POST['apply'])) {
            $code = $_POST['code'];

            $callingCoupon = mysqli_query($connect, "SELECT * from coupon where coupon_code='$code'");
            $getCoupon = mysqli_fetch_array($callingCoupon);
            $countCoupon = mysqli_num_rows($callingCoupon);


            if($countCoupon > 0){
                //updating coupon id in order recoard
                $coupon_id = $getCoupon['c_id'];   
                $updateOrder = mysqli_query($connect, "UPDATE orders SET coupon_id='$coupon_id' where order_id='$myOrderId'");
                echo "<script>window.open('cart.php','_self')</script>";

            }
            else{
                echo "<script>alert('invalid coupon code')</script>";
            }
        }

        // delete item directly
        if(isset($_GET['delete_item'])){
            $item_id = $_GET['delete_item'];

            $querryForDeleteItem = mysqli_query($connect,"DELETE FROM order_items WHERE oi_id='$item_id'");


            if($querryForDeleteItem){
                echo "<script>window.open('cart.php','_self')</script>";

            }
            else{
                echo "<script>alert('failed to delete')</script>";
            }
        }
        
        
        // remove coupon directly
        if(isset($_GET['remove_coupon'])){
            $id = $_GET['remove_coupon'];

            $querryForRemoveCoupon = mysqli_query($connect,"UPDATE orders SET coupon_id='NULL' WHERE order_id='$id'");


            if($querryForRemoveCoupon){
                echo "<script>window.open('cart.php','_self')</script>";
            }
            else{
                echo "<script>alert('failed to delete')</script>";
            }
        }
    

?>