<?php
require_once 'config.php';
session_start();
// session_destroy();

if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

if (isset($_SESSION['admin'])) {
  $admin_email = $_SESSION['admin'];

  $sql = "SELECT * FROM user 
  WHERE user.email = :admin_email";

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':admin_email', $admin_email);
  $stmt->execute();

  $admin = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$admin) {
    die('Bạn không có quyền truy cập admin.');
  }
  
  $admin_email = $admin['email']; 
  $admin_fullname = $admin['fullname'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản Trị Bán Hàng</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Quản Trị Bán Hàng</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-user"></i> <?php echo isset($admin_email) ? $admin_email : ''; ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-3">
        <div class="list-group">
        <a href="<?php echo BASE_URL; ?>admin/index.php" class="list-group-item list-group-item-action">Trang Chủ</a>
        <a href="<?php echo BASE_URL; ?>admin/sanpham.php" class="list-group-item list-group-item-action">Sản phẩm</a>
        <a href="<?php echo BASE_URL; ?>admin/donhang.php" class="list-group-item list-group-item-action">Đơn hàng</a>
        <a href="<?php echo BASE_URL; ?>admin/nguoidung.php" class="list-group-item list-group-item-action">Quản trị Người dùng</a>
        </div>
      </div>
