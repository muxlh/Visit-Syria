<?php
session_start();
require_once "config.php";

// الاتصال بقاعدة البيانات باستخدام PDO
connect::setConnection();
$connection = connect::getConnection();

// تهيئة مصفوفة الفئات
$categories = [];

// الاستعلام لجلب المنتجات وترتيبها حسب فئة `category`
$query = "SELECT * FROM products ORDER BY category";
$stmt = $connection->prepare($query);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// إذا كانت قاعدة البيانات قد أرجعت نتائج، قم بترتيبها حسب الفئة
if ($products) {
    foreach ($products as $product) {
        $categories[$product['category']][] = $product;
    }
}

// حساب عدد المنتجات في السلة
$cartCount = 0;

if (isset($_SESSION['user_id'])) {
    // إذا كان المستخدم مسجلاً، استخدم قاعدة البيانات لحساب عدد العناصر في السلة
    $userId = $_SESSION['user_id'];
    
    // استعلام لجلب إجمالي الكميات في سلة المستخدم باستخدام PDO
    $query = "SELECT SUM(quantity) AS total_quantity FROM CART WHERE user_id = :user_id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // جلب النتيجة
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $cartCount = $row['total_quantity'];
    }
} else {
    // إذا كان المستخدم ضيفًا، احسب عدد العناصر المخزنة في الجلسة
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $details) {
            $cartCount += $details['quantity'];
        }
    }
}
?>


<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Syria Shop</title>
    <link rel="stylesheet" href="css/ShopStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div id="message" class="message" style="display: none;"></div>
<header class="header">
    <a href="Shop.php"><img src="images/logo.png" class="logo"></a>
    <div class="menu-toggle" onclick="toggleMenu()"> القائمة☰</div>
    <ul class="header-buttons">
        <li><a href="index.php">الرئيسية</a></li>
        <li><a href="#">اكتشف المناطق السياحية</a></li>
        <li><a href="#">الأنشطة والفعاليات</a></li>
        <li><a href="Shop.php">المتجر</a></li>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a class="loginbtn" href="login.php">الدخول</a></li>
            <li><a class="loginbtn" href="signup.php">التسجيل</a></li>
        <?php else: ?>
            <li>
                <form method="POST" action="logout.php" style="display:inline;">
                    <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
                </form>
            </li>
        <?php endif; ?>
    </ul>
    <a href="cart.php">
        <span class="cart-count"><?= $cartCount ?></span>
        <img class="cart-button" src="images/cart.png" alt="Cart">
    </a>
</header>
