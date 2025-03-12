<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// 获取订单列表
$orders = $pdo->query("SELECT * FROM orders")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>订单管理</title>
    <link rel="stylesheet" href="../admin_styles.css"> <!-- 确保样式文件路径正确 -->
</head>
<body>
    <div class="admin-dashboard">
        <h1>订单管理</h1>
        <div class="admin-nav">
            <a href="admin_dashboard.php">返回后台</a>
            <a href="logout.php">退出</a>
        </div>
        <div class="admin-content">
            <h2>订单列表</h2>
            <table>
                <thead>
                    <tr>
                        <th>订单ID</th>
                        <th>用户ID</th>
                        <th>总金额</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= $order['user_id'] ?></td>
                            <td>¥<?= $order['total_amount'] ?></td>
                            <td><?= $order['status'] ?></td>
                            <td>
                                <a href="view_order.php?id=<?= $order['id'] ?>">查看</a>
                                <a href="update_order_status.php?id=<?= $order['id'] ?>">更新状态</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>