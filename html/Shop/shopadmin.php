<?php
require_once 'config.php';

try {
    connect::setConnection();
    $pdo = connect::getConnection();
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// جلب الأقسام من قاعدة البيانات
try {
    $sql = "SELECT * FROM categories ORDER BY name";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    die("فشل في جلب الأقسام: " . $e->getMessage());
}

// معالجة إضافة قسم جديد
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    try {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $category_name]);
        echo "<script>alert('تم إضافة القسم بنجاح');</script>";
        header("Refresh:0");
    } catch (PDOException $e) {
        echo "<script>alert('حدث خطأ أثناء إضافة القسم: " . $e->getMessage() . "');</script>";
    }
}

// معالجة حذف قسم
if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];

    try {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $category_id]);
        echo "<script>alert('تم حذف القسم بنجاح');</script>";
        header("Location: " . $_SERVER['PHP_SELF']); // إعادة التوجيه
        exit; // تأكد من إنهاء السكربت بعد إعادة التوجيه
    } catch (PDOException $e) {
        echo "<script>alert('حدث خطأ أثناء حذف القسم: " . $e->getMessage() . "');</script>";
    }
}


// معالجة إضافة منتج
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $NAME = $_POST['name'];
    $PRICE = $_POST['price'];
    $CATEGORY_ID = $_POST['category_id'];
    $IMAGE = $_FILES['image'];

    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_up = 'images/' . $image_name;

    // جلب اسم القسم بناءً على category_id
    $sql = "SELECT name FROM categories WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $CATEGORY_ID]);
    $category_data = $stmt->fetch();

    if ($category_data) {
        $CATEGORY_NAME = $category_data['name']; // اسم القسم
    } else {
        echo "<script>alert('القسم غير موجود');</script>";
        return;
    }

    // رفع الصورة وإدخال المنتج
    if (move_uploaded_file($image_tmp_name, $image_up)) {
        $sql = "INSERT INTO products (name, price, category_id, category, image) VALUES (:name, :price, :category_id, :category, :image)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $NAME,
            'price' => $PRICE,
            'category_id' => $CATEGORY_ID,
            'category' => $CATEGORY_NAME, // إضافة اسم القسم هنا
            'image' => $image_up
        ]);
        echo "<script>alert('تم إضافة المنتج بنجاح');</script>";
        header("Refresh:0");
    } else {
        echo "<script>alert('حدث خطأ أثناء رفع الصورة');</script>";
    }
}

// معالجة حذف المنتج
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    echo "<script>alert('تم حذف المنتج بنجاح');</script>";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit; // إنهاء السكربت بعد إعادة التوجيه
}

// جلب المنتجات من قاعدة البيانات
$sql = "SELECT products.*, categories.name AS category_name 
        FROM products 
        JOIN categories ON products.category_id = categories.id
        ORDER BY categories.name";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();

$grouped_products = [];
foreach ($products as $product) {
    $grouped_products[$product['category_name']][] = $product;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المنتجات والأقسام</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">إدارة الأقسام</h2>
    <form method="POST">
        <div class="form-group">
            <label>اسم القسم:</label>
            <input type="text" name="category_name" class="form-control" required>
        </div>
        <button type="submit" name="add_category" class="btn btn-success">إضافة قسم</button>
    </form>

    <h3 class="mt-4">الأقسام الحالية:</h3>
    <ul class="list-group">
        <?php foreach ($categories as $category): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <?= $category['name']; ?>
                <a href="?delete_category=<?= $category['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا القسم؟');">حذف</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2 class="text-center mt-5">إضافة منتج جديد</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>اسم المنتج:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>السعر:</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label>القسم:</label>
            <select name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id']; ?>"><?= $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>صورة المنتج:</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" name="add_product" class="btn btn-primary">إضافة المنتج</button>
    </form>

    <h2 class="text-center mt-5">منتجاتنا</h2>
    <?php foreach ($grouped_products as $category_name => $productsInCategory): ?>
        <h3 class="text-center mt-4"><?= $category_name; ?></h3>
        <div class="row justify-content-center">
            <?php foreach ($productsInCategory as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="<?= $product['image']; ?>" class="card-img-top product-img" alt="<?= $product['name']; ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $product['name']; ?></h5>
                            <p class="card-text">السعر: <?= $product['price']; ?> ل.س</p>
                            <a href="?delete=<?= $product['id']; ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا المنتج؟');">حذف</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
