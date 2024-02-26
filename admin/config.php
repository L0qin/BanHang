<?php
$configDB = array();

$configDB["host"]      = "localhost";
$configDB["database"]  = "project_php";
$configDB["username"]  = "root";
$configDB["password"]  = "";

define("HOST", "localhost");
define("DB_NAME", "project_php");
define("DB_USER", "root");
define("DB_PASS", "");

define('ROOT', dirname(dirname(__FILE__)));

define("BASE_URL", "http://" . $_SERVER['SERVER_NAME'] . "/shopping/"); 

try {
    $pdo = new PDO("mysql:host=" . $configDB['host'] . ";dbname=" . $configDB['database'] . ";charset=utf8", $configDB['username'], $configDB['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Không thể kết nối cơ sở dữ liệu: " . $e->getMessage());
}
