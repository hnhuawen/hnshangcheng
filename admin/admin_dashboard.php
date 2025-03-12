<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员后台</title>
    <link rel="stylesheet" href="../admin_styles.css"> <!-- 确保样式文件路径正确 -->
</head>
<body>
    <div class="admin-container">
        <!-- 左侧导航栏 -->
        <div class="admin-sidebar">
            <h1>管理员后台</h1>
            <ul>
                <li><a href="admin_dashboard.php">仪表盘</a></li>
                <li><a href="admin_products.php">商品管理</a></li>
                <li><a href="admin_orders.php">订单管理</a></li>
                <li><a href="admin_users.php">用户管理</a></li>
                <li><a href="logout.php">退出</a></li>
            </ul>
        </div>

        <!-- 右侧内容区域 -->
        <div class="admin-content">
            <h2>仪表盘</h2>
            <p>欢迎回来，<?= $_SESSION['admin']['username'] ?>！</p>
            <div class="stats">
                <div class="stat-card">
                    <h3>商品总数</h3>
                    <p><?= $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn(); ?></p>
                </div>
                <div class="stat-card">
                    <h3>订单总数</h3>
                    <p><?= $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(); ?></p>
                </div>
                <div class="stat-card">
                    <h3>用户总数</h3>
                    <p><?= $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>