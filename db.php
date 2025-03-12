<?php
$host = 'localhost';
$dbname = 'mall.huawen';
$username = 'mall.huawen';
$password = 'AWezmYaHYSKbp3PA';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}
?>