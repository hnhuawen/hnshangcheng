<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];

        $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $stmt->execute([$username, $email, $user['id']]);
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;
        $success = "个人信息更新成功";
    } elseif (isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];

        if (password_verify($current_password, $user['password'])) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$new_password_hash, $user['id']]);
            $success = "密码更新成功";
        } else {
            $error = "当前密码错误";
        }
    } elseif (isset($_FILES['avatar'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
            $stmt->execute([$target_file, $user['id']]);
            $_SESSION['user']['avatar'] = $target_file;
            $success = "头像上传成功";
        } else {
            $error = "头像上传失败";
        }
    }
}

$orders = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
$orders->execute([$user['id']]);
$orders = $orders->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人中心</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- 导航栏 -->
    <div class="nav-container">
        <div class="nav-left">
            <a href="/" class="nav-home">首页</a>
            <a href="fenlei.php" class="nav-category">全部分类</a>
        </div>
        <div class="nav-right">
            <a href="profile.php" class="nav-login">个人中心</a>
            <a href="logout.php" class="nav-cart">退出</a>
        </div>
    </div>
    
    <!-- 首页logo栏 -->
    <div class="service-bar">
        <a href="/">
        <img src="images/logo.png" alt="品牌logo" class="service-logo">
        </a>
        <div class="service-items">
            <span>正品保障</span>
            <span>满99包邮</span>
        </div>
    </div>

    <!-- 个人中心 -->
    <div class="profile-container">
        <div class="profile-sidebar">
            <h2>个人中心</h2>
            <ul>
                <li><a href="profile.php">个人信息</a></li>
                <li><a href="orders.php">我的订单</a></li>
                <li><a href="wallet.php">钱包管理</a></li>
                <li><a href="logout.php">退出</a></li>
            </ul>
        </div>
        <div class="profile-content">
            <h2>个人信息</h2>
            <?php if (isset($success)): ?>
                <p class="success"><?= $success ?></p>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <label for="username">用户名</label>
                <input type="text" name="username" value="<?= $user['username'] ?>" required>
                <label for="email">邮箱</label>
                <input type="email" name="email" value="<?= $user['email'] ?>" required>
                <button type="submit" name="update_profile">更新个人信息</button>
            </form>

            <h2>修改密码</h2>
            <form method="POST">
                <label for="current_password">当前密码</label>
                <input type="password" name="current_password" required>
                <label for="new_password">新密码</label>
                <input type="password" name="new_password" required>
                <button type="submit" name="update_password">修改密码</button>
            </form>

            <h2>上传头像</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="avatar" required>
                <button type="submit">上传头像</button>
            </form>
        </div>
    </div>

    <!-- 底部信息 -->
    <footer>
        <div class="footer-links">
            <a href="#" target="_blank">购物指南</a>
            <a href="#" target="_blank">售后服务</a>
            <a href="#" target="_blank">服务支持</a>
            <a href="#" target="_blank">关于我们</a>
        </div>
        <div class="footer-bottom">
            <div class="footer-qr-codes">
                <div>
                    <img src="images/wechat-service.png" alt="微信客服二维码">
                    <div>微信客服</div>
                </div>
                <div>
                    <img src="images/wechat-official.png" alt="微信公众号二维码">
                    <div>微信公众号</div>
                </div>
            </div>
            <div class="footer-friendship-links">友情链接：
                <a href="https://www.hys.wang" target="_blank">华医生</a>
                <a href="https://www.hnlanshu.com" target="_blank">懒鼠AI</a>
                <a href="https://www.hwevtol.com" target="_blank">华文智造</a>
            </div>
        </div>
        <div class="footer-copyright">
            <p>Copyright © 2025 <a href="https://www.hnhuawen.com" target="_blank">海南华文技术有限公司</a> 版权所有 <a href="https://beian.miit.gov.cn" target="_blank">ICP备案：琼ICP备2024046510号</a> <a href="https://www.beian.gov.cn" target="_blank">公安联网备案：琼公安备2024046511号</a></p>
        </div>
    </footer>
</body>
</html>