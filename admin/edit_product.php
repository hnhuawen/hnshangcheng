<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// 获取商品ID
$id = $_GET['id'];

// 获取商品信息
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // 更新商品
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $stock, $id]);

    header("Location: admin_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>编辑商品</title>
    <link rel="stylesheet" href="../admin_styles.css"> <!-- 确保样式文件路径正确 -->
</head>
<body>
    <div class="admin-dashboard">
        <h1>编辑商品</h1>
        <div class="admin-nav">
            <a href="admin_products.php">返回商品管理</a>
            <a href="logout.php">退出</a>
        </div>
        <div class="admin-content">
            <form method="POST">
                <label for="name">商品名称</label>
                <input type="text" name="name" value="<?= $product['name'] ?>" required>

                <label for="description">商品描述</label>
                <textarea name="description" required><?= $product['description'] ?></textarea>

                <label for="price">价格</label>
                <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required>

                <label for="stock">库存</label>
                <input type="number" name="stock" value="<?= $product['stock'] ?>" required>

                <button type="submit">保存更改</button>
            </form>
        </div>
    </div>
</body>
</html>