<?php
require "config/config.php";
require ROOT . "/include/function.php";
spl_autoload_register("loadClass");
session_start();

$db = new Db();


$sql = 'SELECT * FROM product where 1 or id = :id ';
// exit;


$id = '8';

$arr = array(":id" => $id);

$results = $db->select($sql, $arr);

foreach($results as $result){

    echo $result["id"];
    echo $result["name"];
    echo "<br>";

}


var_dump($result);
exit;
