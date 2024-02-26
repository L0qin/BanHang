<?php
require_once "../config.php";

if (isset($_GET['id_sanpham'])) {
    try {
        $id_sanpham = $_GET['id_sanpham'];

        $sql = "DELETE FROM product WHERE id = :id_sanpham";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_sanpham', $id_sanpham);

        if ($stmt->execute()) {
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
