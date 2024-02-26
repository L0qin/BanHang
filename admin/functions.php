<?php
function countProducts($pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM product");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function countOrders($pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM orders");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

function countUsers($pdo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}



