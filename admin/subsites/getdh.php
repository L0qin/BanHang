<?php
require_once "../config.php";

if (isset($_GET['id_donhang'])) {
    $id_donhang = $_GET['id_donhang'];

    $sqlOrderInfo = "SELECT orders.*, user.fullname
                     FROM orders
                     INNER JOIN user ON orders.user_id = user.id 
                     WHERE orders.id = :id_donhang";

    $stmtOrderInfo = $pdo->prepare($sqlOrderInfo);
    $stmtOrderInfo->bindParam(':id_donhang', $id_donhang);

    if ($stmtOrderInfo->execute()) {
        $orderInfo = $stmtOrderInfo->fetch(PDO::FETCH_ASSOC);

        $sqlProductDetails = "SELECT product.name, order_details.count 
                              FROM order_details
                              INNER JOIN product ON order_details.product_id = product.id
                              WHERE order_details.orders_id = :order_id";

        $stmtProductDetails = $pdo->prepare($sqlProductDetails);
        $stmtProductDetails->bindParam(':order_id', $id_donhang);

        if ($stmtProductDetails->execute()) {
            $productDetails = $stmtProductDetails->fetchAll(PDO::FETCH_ASSOC);

            if ($orderInfo && $productDetails) {
                $combinedResult = [
                    'order_info' => $orderInfo,
                    'product_details' => $productDetails
                ];

                header('Content-Type: application/json');
                echo json_encode($combinedResult);
            } else {
                echo "Không tìm thấy thông tin đơn hàng hoặc sản phẩm";
            }
        } else {
            echo "Lỗi khi truy vấn thông tin sản phẩm";
        }
    } else {
        echo "Lỗi khi truy vấn thông tin đơn hàng";
    }
} else {
    header("Location: ../donhang.php?stat=loi");
    exit();
}
?>
