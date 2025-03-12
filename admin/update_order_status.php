<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// 获取订单ID和新状态
$id = $_GET['id'];
$status = $_GET['status'];

// 更新订单状态
$stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->execute([$status, $id]);

header("Location: admin_orders.php");
exit();
?>