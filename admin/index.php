<?php
require_once "includes/header.php";
require_once "functions.php";

$countProducts = countProducts($pdo);
$countOrders = countOrders($pdo);
$countUsers = countUsers($pdo);
?>

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ -->
<div class="col-md-9">
  <div class="container-fluid">
    <h2>Dashboard</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Số lượng sản phẩm</h5>
            <p class="card-text"><?php echo $countProducts; ?></p>
            <a href="sanpham.php" class="btn btn-primary">Quản lý sản phẩm</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Số lượng đơn hàng</h5>
            <p class="card-text"><?php echo $countOrders; ?></p>
            <a href="donhang.php" class="btn btn-primary">Quản lý đơn hàng</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Người dùng</h5>
            <p class="card-text"><?php echo $countUsers; ?></p>
            <a href="nguoidung.php" class="btn btn-primary">Quản trị Người dùng</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ -->

<?php require_once "includes/footer.php" ?>