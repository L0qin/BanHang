<?php
require_once '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_donhang = $_POST['id_donhang']; 
    $so_luong = $_POST['so_luong']; // If needed
    $tong_tien = $_POST['tong_tien'];
    $status = $_POST['status'];

    $sql = "UPDATE orders 
            SET total = :total, status = :status
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id_donhang);
    $stmt->bindParam(':total', $tong_tien);
    $stmt->bindParam(':status', $status);

    try {
        $stmt->execute();

        if ($stmt) {
            header("Location: ../donhang.php?stat=thanhcong");
            exit();
        } else {
            header("Location: ../donhang.php?stat=loi");
            exit();
        }
    } catch (\Throwable $th) {
        header("Location: ../donhang.php?stat=loi");
        exit();
    }
}
?>
