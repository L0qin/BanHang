<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
session_start();

$obj = new Product();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#">My Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">

                    <li class="nav-item"><a class="nav-link active " aria-current="page" href="index.php">Home</a></li>

                    <?php
                    if (empty($_SESSION['user'])) {
                    ?>

                        <li class='nav-item dropdown'>
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo "Account" ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                                <li class="nav-item"><a class="nav-link" href="registration.php">Register</a></li>
                            </ul>
                        </li>
                    <?php
                    } else {
                        $db = new db();
                        $sql = "SELECT * from user where email= :email";
                        $arr = array(':email' => $_SESSION['user']);
                        $user = $db->select($sql, $arr)[0]; ?>
                        <li class='nav-item dropdown'>
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $user['fullname'] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="history.php">History shopping</a></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>

                    <?php
                    }
                    ?>

                </ul>

                <a href="cart.php" class="btn btn-outline-dark d-flex align-items-center text-decoration-none">
                    <i class="bi-cart-fill me-1"></i>
                    Giỏ hàng
                    <span class="badge bg-dark text-white ms-1 rounded-pill">
                        <?php
                        // $count = isset($_SESSION['product_id']) ? count($_SESSION['product_id']) : 0;
                        $count = isset($_SESSION['product_id']) ? count($_SESSION['product_id']) : 0;
                               echo $count;
                         if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            if (isset($_GET['add_to_cart'])) {
                                header("Location: index.php");
                            }
                        }
                        ?>
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <!-- ============================ Header ============================-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">MY PHP WEBSITE</h1>
            </div>
        </div>
    </header>




    <!-- ============================ Section ============================-->
    <section class="py-5">
        <form action="" method="get">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 align-items-end">

                    <div class="col-md-3 mb-3">
                        <label for="categoryFilter" class="form-label">Category</label>
                        <select class="form-select" id="categoryFilter" name="cat">
                            <option value='all' selected>Tất cả</option>
                            <?php
                            $obj->getAllCategoriesForFiltering();
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="manufacturerFilter" class="form-label">Nhà sản xuất</label>
                        <select class="form-select" id="manufacturerFilter" name="man">
                            <option value='all' selected>Tất cả</option>
                            <?php
                            $obj->getAllManufacturers();
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                        </div>
                    </div>
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            $manId = $_GET['man'] ?? null;
                            $catId = $_GET['cat'] ?? null;

                            if ($manId === 'all') {
                                $manId = null;
                            }
                            if ($catId === 'all') {
                                $catId = null;
                            }

                            if ($manId === null && $catId === null) {
                                $obj->getRand();
                            } else {
                                $obj->getFilter($manId, $catId);
                            }
                        } else {
                            $obj->getRand();
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </section>




    <!-- ============================ Footer ============================ -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; -> You copy, right? No, I don't</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (isset($_GET['add_to_cart'])) {

        $product_id = $_GET['product_id'];

        if (isset($_SESSION)) {
            if (!isset($_SESSION['product_id'])) {

                $_SESSION['product_id'][] = $product_id;
            } else {

                if (!in_array($product_id, $_SESSION['product_id'])) {
                    $_SESSION['product_id'][] = $product_id;
                }
            }
        } else {

            $_SESSION['product_id'][] = $product_id;
        }
    }
}
?>

</html>