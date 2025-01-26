<?php
session_start();

// التحقق مما إذا كان هناك مستخدم مسجل دخول بالفعل
if (isset($_SESSION['user_id'])) {
    // إذا كان المستخدم مسجل دخول، أظهر له رسالة وأعد توجيهه إلى الصفحة الرئيسية
    echo "<script>alert('أنت مسجل دخول بالفعل!'); window.location.href='index.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'config.php';
    connect::setConnection();
    $pdo = connect::getConnection();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user_id'] = $user['id'];

        // إذا كانت هناك عربة في الجلسة، دمجها مع عربة المستخدم في قاعدة البيانات
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $productId => $item) {
                $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
                $stmt->execute([$user['id'], $productId]);
                $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($cartItem) {
                    $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
                    $stmt->execute([$item['quantity'], $user['id'], $productId]);
                } else {
                    $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $stmt->execute([$user['id'], $productId, $item['quantity']]);
                }
            }
            // تنظيف عربة الضيف من الجلسة بعد الدمج
            unset($_SESSION['cart']);
        }
           // التحقق مما إذا كانت بيانات تسجيل الدخول خاصة بالمشرف
    if ($email === 'admin' && $password === 'admin') {
        echo "<script>alert('مرحبًا بك، مشرف النظام!'); window.location.href='shopadmin.php';</script>";
        exit();
    }
        echo "<script>alert('مرحبًا بك، " . htmlspecialchars($user['email']) . "!'); window.location.href='index.php';</script>";
        exit;
    } else {
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
<div class="container jumbotron">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h2 class="text-center">Login</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-info btn-lg">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
