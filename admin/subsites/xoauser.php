<?php
require_once "../config.php";

if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];

        $sql = "DELETE FROM user WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header("Location: ../nguoidung.php?stat=thanhcong");
            exit();
        } else {
            header("Location: ../nguoidung.php?stat=loi");
            exit();
        }
    } catch (\Throwable $th) {
        header("Location: ../nguoidung.php?stat=loi");
        exit();
    }
} else {
    header("Location: ../nguoidung.php?stat=loi");
    exit();
}
?>
