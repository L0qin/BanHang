<?php
require_once "../config.php";

if (isset($_GET['id_donhang'])) {
    try {
        $id_donhang = $_GET['id_donhang'];

        $sqlDeleteDetails = "DELETE FROM order_details WHERE orders_id = :id_donhang";
        $stmtDetails = $pdo->prepare($sqlDeleteDetails);
        $stmtDetails->bindParam(':id_donhang', $id_donhang);
        $stmtDetails->execute();

        $sqlDeleteOrder = "DELETE FROM orders WHERE id = :id_donhang";
        $stmtOrder = $pdo->prepare($sqlDeleteOrder);
        $stmtOrder->bindParam(':id_donhang', $id_donhang);

        if ($stmtOrder->execute()) {
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
} else {
    header("Location: ../donhang.php?stat=loi");
    exit();
}
?>
