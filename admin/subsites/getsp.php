<?php
// Connect to the database
require_once "../config.php";

if (isset($_GET['id_sanpham'])) {
    $id_sanpham = $_GET['id_sanpham'];

    $sql = "SELECT p.id, p.name, p.price, p.stocks, p.review, p.manufacturer_id, p.categories_id, p.image, p.description,
            m.name AS manufacturer_name, c.name AS category_name
            FROM product AS p
            LEFT JOIN manufacturer AS m ON p.manufacturer_id = m.id
            LEFT JOIN categories AS c ON p.categories_id = c.id
            WHERE p.id = :id_sanpham";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_sanpham', $id_sanpham);

    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            echo "Không tìm thấy sản phẩm";
        }
    } else {
        header("Location: ../sanpham.php?stat=loi");
        exit();
    }
} else {
    header("Location: ../sanpham.php?stat=loi");
    exit();
}
?>
