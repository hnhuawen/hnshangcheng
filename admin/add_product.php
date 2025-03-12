<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// 获取商品列表
$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品管理</title>
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
            <h2>商品管理</h2>
            <a href="add_product.php" class="add-button">添加商品</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>价格</th>
                        <th>库存</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= $product['title'] ?></td>
                            <td>¥<?= $product['price'] ?></td>
                            <td><?= $product['stock'] ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= $product['id'] ?>">编辑</a>
                                <a href="delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('确定删除吗？')">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>