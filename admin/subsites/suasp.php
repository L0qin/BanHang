<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_sanpham = $_POST['editProductId'];
    $tensp = $_POST['editProductName'];
    $price = $_POST['editProductPrice'];
    $stock = $_POST['editProductStocks'];
    $description = $_POST['editProductDescription'];
    $review = $_POST['editProductReview'];
    $category = $_POST['editCategory'];
    $manufacturer = $_POST['editManufacturer'];

    // Check if a new image is uploaded
    if ($_FILES['editProductImage']['error'] === 0) {
        $file = $_FILES['editProductImage'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png');

        if (in_array($fileExt, $allowedExtensions)) {
            $newFileName = uniqid('', true) . "." . $fileExt;
            $fileDestination = "../../img/" . $newFileName;
            move_uploaded_file($fileTmpName, $fileDestination);
        } else {
            header("Location: ../sanpham.php?stat=loi");
            exit();
        }
    } else {
        $sql = "SELECT image FROM product WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_sanpham]);
        $existingImage = $stmt->fetchColumn();
        $fileDestination = $existingImage;
    }

    $sql = "UPDATE product SET name=?, price=?, stocks=?, review=?, manufacturer_id=?, categories_id=?, image=?, description=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tensp, $price, $stock, $review, $manufacturer, $category, $newFileName, $description, $id_sanpham]);

    if ($stmt) {
        header("Location: ../sanpham.php?stat=thanhcong");
        exit();
    } else {
        header("Location: ../sanpham.php?stat=loi");
        exit();
    }
}
?>
