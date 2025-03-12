<?php
session_start();
require __DIR__ . '/db.php'; // 确保路径正确

// 获取商品ID
$id = $_GET['id'];

// 查询商品信息
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("商品不存在");
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['title'] ?> - 商品详情</title>
    <link rel="stylesheet" href="styles.css"> <!-- 确保样式文件路径正确 -->
</head>
<body>
    <!-- 导航栏 -->
    <div class="nav-container">
        <div class="nav-left">
            <a href="/" class="nav-home">首页</a>
            <a href="fenlei.php" class="nav-category">全部分类</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="profile.php" class="nav-login">个人中心</a>
                <a href="logout.php" class="nav-cart">退出</a>
            <?php else: ?>
                <a href="login.php" class="nav-login">登录</a>
                <a href="register.php" class="nav-cart">注册</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- 商品详情 -->
    <div class="product-detail-container">
        <div class="product-images">
            <img src="/<?= $product['image'] ?>" alt="<?= $product['title'] ?>" class="main-image">
        </div>
        <div class="product-info">
            <h1><?= $product['title'] ?></h1>
            <p><?= $product['description'] ?></p>
            <div class="product-price">
                <span class="current-price">¥<?= $product['price'] ?></span>
            </div>
            <button class="buy-button">立即购买</button>
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