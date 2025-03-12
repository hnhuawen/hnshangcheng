<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// 获取用户ID
$id = $_GET['id'];

// 获取用户信息
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户详情</title>
    <link rel="stylesheet" href="../admin_styles.css"> <!-- 确保样式文件路径正确 -->
</head>
<body>
    <div class="admin-dashboard">
        <h1>用户详情</h1>
        <div class="admin-nav">
            <a href="admin_users.php">返回用户管理</a>
            <a href="logout.php">退出</a>
        </div>
        <div class="admin-content">
            <p>用户ID: <?= $user['id'] ?></p>
            <p>用户名: <?= $user['username'] ?></p>
            <p>邮箱: <?= $user['email'] ?></p>
            <p>余额: ¥<?= $user['balance'] ?></p>
        </div>
    </div>
</body>
</html>