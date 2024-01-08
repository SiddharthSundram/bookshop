<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <!-- Add Bootstrap CSS link -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* Custom CSS for the header */
        .header {
            background-color: black;
            padding: 12px 10px;
            color: antiquewhite;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            font-size: 30px;
        }

        .links a {
            text-decoration: none;
            color: #E1D9D1;
            margin-right: 15px; /* Add margin to space out the links */
        }
    </style>
</head>
<body>
    <div class="header bg-danger">
        <h2>Bookshop.com</h2>
        <!-- Bootstrap Navbar for the links -->
        <nav class="navbar navbar-expand-lg navbar-dark ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            


            <div class="collapse navbar-collapse " id="navbarNav">

                <form action="index.php" class="d-flex gap-1 me-5">
                    <input type="search" name="search" class="form-control" placeholder="Enter any book title">
                    <input type="submit" name="find" class="btn btn-dark">
                </form>
                
                <ul class="navbar-nav ms-5">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php">Home</a>
                    </li>
                    <?php   

                        if(isset($_SESSION['account'])):

                        $email = $_SESSION['account'];
                        $getUser = mysqli_query($connect,"SELECT * FROM accounts WHERE email='$email'");

                        $getUser = mysqli_fetch_array($getUser);
 
                        
                    ?>
                    <li class="nav-item">
                        <a class="nav-link text-white text-capitalize" href="my_order.php"><?= $getUser['name']; ?></a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="cart.php">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-linkbtn btn btn-dark ms-3  text-white" href="logout.php">logout</a>
                        </li>
                    <?php  else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="register.php">Create an Account</a>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Add Bootstrap JS and jQuery links -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>