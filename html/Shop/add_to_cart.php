<?php
session_start();
require_once "config.php";
connect::setConnection();
$connection = connect::getConnection();

$user_id = $_SESSION['user_id'] ?? null; // التحقق من معرف المستخدم

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
    $product_id = $_POST['product_id']; // معرف المنتج
    $quantity = $_POST['quantity']; // الكمية المطلوبة

    if ($user_id) {
        // التعامل مع المستخدم المسجل
        $query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->execute([$user_id, $product_id]);
        $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingProduct) {
            // إذا كان المنتج موجودًا، قم بزيادة الكمية
            $newQuantity = $existingProduct['quantity'] + $quantity;
            $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([$newQuantity, $user_id, $product_id]);
        } else {
            // إذا لم يكن موجودًا، أضفه
            $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($query);
            $stmt->execute([$user_id, $product_id, $quantity]);
        }

        // حساب العدد الإجمالي للمنتجات في السلة
        $query = "SELECT SUM(quantity) AS cart_count FROM cart WHERE user_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->execute([$user_id]);
        $cartCount = $stmt->fetch(PDO::FETCH_ASSOC)['cart_count'];
    } else {
        // التعامل مع المستخدم الضيف
        $_SESSION['cart'] = $_SESSION['cart'] ?? [];

        if (isset($_SESSION['cart'][$product_id])) {
            // زيادة الكمية في السلة
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            // إضافة المنتج لأول مرة
            $_SESSION['cart'][$product_id] = [
                'quantity' => $quantity
            ];
        }

        // حساب العدد الإجمالي للمنتجات في السلة للمستخدم الضيف
        $cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
    }

    // إرسال العدد الجديد كـ JSON
    echo json_encode(['cartCount' => $cartCount, 'message' => 'تمت إضافة المنتج إلى السلة بنجاح.']);
} else {
    echo json_encode(['error' => 'حدث خطأ، يرجى المحاولة مرة أخرى.']);
}
?>