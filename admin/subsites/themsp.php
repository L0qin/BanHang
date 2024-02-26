<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productStocks = $_POST['productStocks'];
    $productReview = $_POST['productReview'];
    $categoryId = $_POST['category'];
    $manufacturerId = $_POST['manufacturer'];
    $productDescription = $_POST['productDescription'];

    if (isset($_FILES['productImage'])) {
        $fileName = uniqid() . '_'. $_FILES['productImage']['name'];
        $fileTmp = $_FILES['productImage']['tmp_name'];
        $uploadsDirectory ='../../img/'; 

        if (!move_uploaded_file($fileTmp, $uploadsDirectory .  $fileName)) {
            header("Location: ../sanpham.php?stat=loi");
            exit();
        } 
    }

    $sql = "INSERT INTO product (name, price, stocks, review, manufacturer_id, categories_id, image, description) 
            VALUES (:name, :price, :stocks, :review, :manufacturer_id, :categories_id, :image, :description)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':name', $productName);
    $stmt->bindParam(':price', $productPrice);
    $stmt->bindParam(':stocks', $productStocks);
    $stmt->bindParam(':review', $productReview);
    $stmt->bindParam(':manufacturer_id', $manufacturerId);
    $stmt->bindParam(':categories_id', $categoryId);
    $stmt->bindParam(':image', $fileName);
    $stmt->bindParam(':description', $productDescription);

    try {
        $stmt->execute();

        if ($stmt) {
            header("Location: ../sanpham.php?stat=thanhcong");
            exit();
        } else {
            header("Location: ../sanpham.php?stat=loi");
            exit();
        }
    } catch (\Throwable $th) {
        header("Location: ../sanpham.php?stat=loi");
        exit();
    } 
} else {
    header("Location: ../sanpham.php?stat=loi");
    exit();
}
?>
