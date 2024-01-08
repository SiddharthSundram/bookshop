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
        <div class="row ">
            <div class="col-8">
                <h1 class="text-success"><b>Checkout</b></h1>
                <div class="card">
                    <div class="card-header h3"><b>Add Address</b></div>
                    <div class="card-body">
                        <form action="" method="post" style="font-size: 18px;">
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="alt_name">Alternative Name</label>
                                    <input type="text" name="alt_name" id="alt_name" class="form-control" value="<?= $getUser['name']; ?>" required>
                                </div>
                                <div class="mb-3 col">
                                    <label for="alt_contact">Contact</label>
                                    <input type="tel" name="alt_contact" id="alt_contact" class="form-control" value="" placeholder="Enter alternative contact number" required>
                                </div>
                                <div class="mb-3 col">
                                    <label for="">Type</label>
                                    <select name="type" class="form-select" required>
                                        <option value="" disabled selected>Select Address Type</option>
                                        <option value="0">Home</option>
                                        <option value="1">Office</option>
                                        <option value="2">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="street">Street</label>
                                    <input type="text" name="street" id="street" class="form-control" value="" placeholder="Enter street address" required>
                                </div>
                                <div class="mb-3 col">
                                    <label for="area">Area/village</label>
                                    <input type="text" name="area" id="area" class="form-control" value="" placeholder="e.g Line Bazar" required>
                                </div>
                                <div class="mb-3 col">
                                    <label for="house_no">House holding no</label>
                                    <input type="text" name="house_no" id="house_no" class="form-control" placeholder="e.g 548B" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="landmark">Landmark</label>
                                    <input type="text" name="landmark" id="landmark" class="form-control" placeholder="e.g Near school...">
                                </div>
                                <div class="mb-3 col">
                                    <label for="city">City</label>
                                    <input type="text" name="city" id="city" class="form-control" placeholder="e.g Purnea" required>
                                </div>
                                <div class="mb-3 col">
                                    <label for="pincode">Pincode</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="e.g 854301" pattern="[0-9]{6}" required>
                                </div>
                                <div class="mb-3 col">
                                    <label for="state">State</label>
                                    <input type="text" name="state" id="state" class="form-control" placeholder="e.g Bihar" required>
                                </div>
                            </div>
                            <div class="row">
                                <input type="submit" class="btn btn-outline-primary w-100" name="save_address" value="Save Address">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <h2>Saved Address</h2>
                <form action="" method="post">
                    <div class="grid">
                        <?php
                        $callingSavedAddress = mysqli_query($connect, "select * from address where user_id ='$user_id'");
                        $count_address =mysqli_num_rows($callingSavedAddress);

                        if($count_address > 0):
                        while ($add = mysqli_fetch_array($callingSavedAddress)) :

                        ?>
                            <label class="card">
                                <input name="address_id" class="radio" type="radio" value="<?= $add['address_id'] ?>" checked>

                                <span class="plan-details">
                                    <span class="plan-type"><?= ($add['type'] == 0) ? "Home" : (($add['type'] == 1) ? "Office" : "Other"); ?></span>

                                    <span class="plan-cost"><?= $add['alt_name']; ?></span>
                                    <span><?= $add['house_no'] . " | " . $add['street'] . "-" .  $add['area'] . "<br> landmark: " . $add['landmark'] . "<br>" . $add['city'] . " ( " . $add['state'] . ")- " . $add['pincode']; ?></span>

                                    <a href="checkout.php?address_id=<?= $add['address_id']; ?>" class="badge bg-danger text-decoration-none ms-auto text-white ">Delete</a>
                                </span>
                            </label>


                        <?php endwhile; ?>
                    </div>
                    <div class="d-flex mt-5 justify-content-between ">
                        <a href="cart.php" class="btn btn-dark btn-lg">Go back</a>
                        <input type="submit" href="" class="btn btn-primary btn-lg" name="make_payment" value="Make Payment">
                    </div>
                </form>
                <?php else: ?>
                    <h2 class="text-muted">Empty saved address</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

<?php
if (isset($_POST['save_address'])) {
    $alt_name = $_POST['alt_name'];
    $alt_contact = $_POST['alt_contact'];
    $street = $_POST['street'];
    $area = $_POST['area'];
    $landmark = $_POST['landmark'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $pincode = $_POST['pincode'];
    $house_no = $_POST['house_no'];
    $type = $_POST['type'];
    $user_id = $getUser['user_id'];

    // Insert data into the address table
    $queryForInsertAddress = mysqli_query($connect, "insert into address (alt_name, alt_contact, street, area, landmark, city, state, pincode, house_no, user_id, type) value
     ('$alt_name', '$alt_contact', '$street', '$area', '$landmark', '$city', '$state', '$pincode', '$house_no','$user_id','$type')");

    if ($queryForInsertAddress) {
        echo "<script>window.open('checkout.php','_self')</script>";
    } else {
        echo "<script>alert ('failed to save address')</script>";
    }
}

// remove address directly
if (isset($_GET['address_id'])) {
    $id = $_GET['address_id'];
    $user_id = $getUser['user_id'];

    $querryForRemoveAddress = mysqli_query($connect, "DELETE from address where address_id='$id' and user_id='$user_id'");


    if ($querryForRemoveAddress) {
        echo "<script>window.open('checkout.php','_self')</script>";
    } else {
        echo "<script>alert('failed to delete')</script>";
    }
}


if(isset($_POST['make_payment'])){
    $address_id = $_POST['address_id'];
    $order_id = $myOrder['order_id'];

    // update this address in order record
    $queryForAddressUpdate = mysqli_query($connect,"UPDATE orders set address_id='$id' where user_id='$user_id' and order_id='$order_id'");

    if ($queryForAddressUpdate) {
        echo "<script>window.open('make_payment.php','_self')</script>";
    } else {
        echo "<script>alert('failed to delete')</script>";
    }
}