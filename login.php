<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error = "用户名或密码错误";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>华文商城-登录</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- 头部 -->
    <div class="nav-container">
        <div class="nav-left">
            <a href="/" class="nav-home">首页</a>
            <a href="fenlei.php" class="nav-category">全部分类</a>
        </div>
        <div class="nav-right">
            <a href="login.php" class="nav-login">登录</a>
            <a href="register.php" class="nav-cart">注册</a>
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

    <!-- 登录窗口 -->
    <div class="login-container">
        <div class="login-box">
            <h2>用户登录</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="请输入用户名" required>
                <input type="password" name="password" placeholder="请输入密码" required>
                <button type="submit">登录</button>
            </form>
            <div style="display: flex; justify-content: space-between;">
                <a href="#" class="forgot-password">忘记密码？</a>
                <a href="register.php" class="register-link">注册账户</a>
            </div>
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