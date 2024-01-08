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
    <title>Mannage coupon | Admin | Bookshop</title>
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
                        <h2 class="text-white">Mannage coupon</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Insert coupon Details</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="coupon_code">Coupon title</label>
                                        <input type="text" name="coupon_code" placeholder="Enter code" id="coupon_code" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="coupon_amount">Coupon Amount</label>
                                        <input type="text" name="coupon_amount" placeholder="Enter coupon amount" id="coupon_amount" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" name="create_coupon" class="btn btn-primary w-100" value="Insert Coupon">
                                    </div>
                                    <!-- Add more fields for category details here -->
                                </form>
                                <?php
                                if (isset($_POST['create_coupon'])) {
                                    $coupon_code = $_POST['coupon_code'];
                                    $coupon_code_amount = $_POST['coupon_amount'];
                                    $query = mysqli_query($connect, "INSERT INTO coupon (coupon_code,coupon_amount) VALUES ('$coupon_code',$coupon_code_amount)");
                                    if ($query) {
                                        echo "<script>window.open('mannge_coupon.php','_self')</script>";  
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
                                    <th>code</th>
                                    <th>amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $callingCoupon = mysqli_query($connect, "SELECT * FROM coupon");
                                while ($data = mysqli_fetch_array($callingCoupon)) :
                                ?>

                                    <tr>
                                        <td><?= $data['c_id']  ?></td>
                                        <td><?= $data['coupon_code']  ?></td>
                                        <td><?= $data['coupon_amount']  ?></td>
                                        <td>
                                            <a href="mannage_coupon.php?coupon_id=<?= $data['c_id']; ?>" class="btn btn-danger">X</a>
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
    if(isset($_GET['coupon_id'])){
        $id = $_GET['coupon_id'];

        $query = mysqli_query($connect,"DELETE from coupon where coupon_id='$id'");

        if($query){
            echo "<script>window.open('mannage_coupon.php','_self')</script>";
        }
        else{
            echo "<script>alert('failed to delete')</script>";

        }
    }