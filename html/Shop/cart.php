<?php
require_once "header.php";
require_once "config.php";
connect::setConnection();
$connection = connect::getConnection();

$user_id = $_SESSION['user_id'] ?? null;
$cartItems = [];

// إذا كان المستخدم مسجلاً، جلب العربة من قاعدة البيانات
if ($user_id) {
    $query = "SELECT products.*, cart.quantity FROM products 
              JOIN cart ON products.id = cart.product_id 
              WHERE cart.user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->execute([$user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // إذا كان المستخدم ضيفًا، جلب المنتجات من الجلسة
    if (!empty($_SESSION['cart'])) {
        $productIds = array_keys($_SESSION['cart']);
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $query = "SELECT * FROM products WHERE id IN ($placeholders)";
        $stmt = $connection->prepare($query);
        $stmt->execute($productIds);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($products as $product) {
            $productId = $product['id'];
            // التأكد من وجود الكمية في الجلسة
            if (isset($_SESSION['cart'][$productId])) {
                $product['quantity'] = $_SESSION['cart'][$productId]['quantity'];
                $cartItems[] = $product;
            }
        }
    }
}

// حذف المنتج من العربة (سواء من قاعدة البيانات أو الجلسة)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $productId = $_POST['remove_product_id'];
    if ($user_id) {
        // إذا كان المستخدم مسجلاً، احذف المنتج من قاعدة البيانات
        $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->execute([$user_id, $productId]);
    } else {
        // إذا كان المستخدم ضيفًا، احذف المنتج من الجلسة
        unset($_SESSION['cart'][$productId]);
    }

    header("Location: cart.php");
    exit();
}

// تحديث الكمية
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($quantity <= 0) {
        // إذا كانت الكمية 0، حذف المنتج من السلة
        if ($user_id) {
            $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([$user_id, $productId]);
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    } else {
        if ($user_id) {
            // إذا كان المستخدم مسجلاً، تحديث الكمية في قاعدة البيانات
            $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $stmt = $connection->prepare($query);
            $stmt->execute([$quantity, $user_id, $productId]);
        } else {
            // إذا كان المستخدم ضيفًا، تحديث الكمية في الجلسة
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    }

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>عربتي</title>
    <!-- ربط بوتستراب -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .quantity-display {
            display: inline-block;
            width: 40px;
            text-align: center;
        }
        .quantity-input {
            display: none;
        }
        .header {
                position: unset;
        }
    </style>
</head>

<body>
    <div class="container pt-10">
        <h2 >عربتك</h2>
        <?php if (empty($cartItems)): ?>
            <p>عربتك فارغة!</p>
            <a href="shop.php"><img src="images/Empty_cart.png" alt="عربة فارغة"></a>
        <?php else: ?>
            <!-- جدول لعرض المنتجات في العربة -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الكمية</th>
                        <th>السعر الإجمالي</th>
                        <th>إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $totalAmount = 0; // إجمالي السعر
                        foreach ($cartItems as $item): 
                            $quantity = isset($_SESSION['cart'][$item['id']]) ? $_SESSION['cart'][$item['id']]['quantity'] : $item['quantity']; 
                            $price = $item['price'] ?? 0; // السعر من قاعدة البيانات
                            $totalPrice = $price * $quantity; // حساب السعر الإجمالي
                            $totalAmount += $totalPrice; // إضافة المبلغ الإجمالي
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td>
                            <!-- أزرار لزيادة أو تقليل الكمية -->
                            <form method="POST" action="cart.php" style="display:inline;">
                                <button type="submit" name="update_quantity" class="btn btn-warning" value="-1" onclick="this.form['quantity'].value=parseInt(this.form['quantity'].value)-1; if (this.form['quantity'].value <= 0) { this.form.submit(); }">-</button>
                                <div class="quantity-display" id="quantity-<?= $item['id']; ?>"><?= $quantity ?></div>
                                <button type="submit" name="update_quantity" class="btn btn-warning" value="1" onclick="this.form['quantity'].value=parseInt(this.form['quantity'].value)+1;"><?= "+" ?></button>
                                <input type="hidden" name="quantity" value="<?= $quantity ?>" class="quantity-input">
                                <input type="hidden" name="product_id" value="<?= $item['id']; ?>">
                            </form>
                        </td>
                        <td><?= htmlspecialchars($totalPrice); ?> ل.س</td>
                        <td>
                            <!-- نموذج لحذف المنتج من العربة -->
                            <form method="POST" action="cart.php" style="display:inline;">
                                <input type="hidden" name="remove_product_id" value="<?= $item['id']; ?>">
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- عرض إجمالي المبلغ -->
            <div class="d-flex justify-content-between">
                <h4>الإجمالي: <?= htmlspecialchars($totalAmount); ?> ل.س</h4>
            </div>

            <!-- زر "ادفع الآن" -->
            <div class="mt-3">
                <a href="#" class="btn btn-success btn-lg">ادفع الآن</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- ربط الجافا سكربت الخاص بـ بوتستراب -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
require_once "footer.php";
?>
</html>
