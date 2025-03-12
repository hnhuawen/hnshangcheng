<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// 获取订单ID
$id = $_GET['id'];

// 获取订单信息
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

// 获取订单项
$stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->execute([$id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>订单详情</title>
    <link rel="stylesheet" href="../admin_styles.css"> <!-- 确保样式文件路径正确 -->
</head>
<body>
    <div class="admin-dashboard">
        <h1>订单详情</h1>
        <div class="admin-nav">
            <a href="admin_orders.php">返回订单管理</a>
            <a href="logout.php">退出</a>
        </div>
        <div class="admin-content">
            <h2>订单信息</h2>
            <p>订单ID: <?= $order['id'] ?></p>
            <p>用户ID: <?= $order['user_id'] ?></p>
            <p>总金额: ¥<?= $order['total_amount'] ?></p>
            <p>状态: <?= $order['status'] ?></p>

            <h2>订单项</h2>
            <table>
                <thead>
                    <tr>
                        <th>商品ID</th>
                        <th>数量</th>
                        <th>价格</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['product_id'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>¥<?= $item['price'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>