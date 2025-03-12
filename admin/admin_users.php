<?php
session_start();
require __DIR__ . '/../db.php'; // 确保路径正确

// 检查管理员是否登录
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// 获取用户列表
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户管理</title>
    <link rel="stylesheet" href="../admin_styles.css"> <!-- 确保样式文件路径正确 -->
</head>
<body>
    <div class="admin-dashboard">
        <h1>用户管理</h1>
        <div class="admin-nav">
            <a href="admin_dashboard.php">返回后台</a>
            <a href="logout.php">退出</a>
        </div>
        <div class="admin-content">
            <h2>用户列表</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>邮箱</th>
                        <th>余额</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td>¥<?= $user['balance'] ?></td>
                            <td>
                                <a href="view_user.php?id=<?= $user['id'] ?>">查看</a>
                                <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('确定删除吗？')">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>