<?php
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vs</title>
</head>
<body>
        <li><a href="index.php">الرئيسية</a></li>
        <li><a href="">اكتشف المناطق السياحية</a></li>
        <li><a href="">الأنشطة والفعاليات</a></li>
        <li><a href="Shop.php">المتجر</a></li>
        <!-- إخفاء أزرار الدخول والتسجيل إذا كان المستخدم مسجلاً -->
        <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a class="loginbtn" href="login.php">الدخول</a></li>
            <li><a class="loginbtn" href="signup.php">التسجيل</a></li>
        <?php else: ?>
            <!-- عرض زر تسجيل الخروج إذا كان المستخدم مسجلاً -->
            <li>
                <form method="POST" action="logout.php" style="display:inline;">
                    <button type="submit" class="btn btn-danger">تسجيل الخروج</button>
                </form>
            </li>
        <?php endif; ?>
</body>
</html>


<?php

