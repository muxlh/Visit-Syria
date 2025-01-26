<?php
session_start();

// حذف جميع بيانات الجلسة
session_unset();

// تدمير الجلسة
session_destroy();

// إعادة توجيه المستخدم إلى الصفحة الرئيسية
header("Location: index.php");
exit();
?>
