<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
$db = new Db();

if (isset($_GET)) {
    $orderId = $_GET['id'];

    $sql = 'UPDATE orders set status = "2" where id =:id';
    $arr = array(':id' => $orderId);

    $result = $db->update($sql, $arr);

    echo '<h1>Huỷ đơn đặt hàng thành công</h1>';
    echo '<a href="history.php">Nhấp vào đây để quay lại</a>';
}
