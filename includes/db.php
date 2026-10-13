<?php
// إعدادات الاتصال الصحيحة المتوافقة مع كود الـ API الخاص بك (MySQLi)
$host = 'localhost';  // تم التعديل: من $db_host إلى $host
$user = 'root';       // تم التعديل: من $db_user إلى $user
$pass = '';           // تم التعديل: من $db_pass إلى $pass
$dbname = 'lapstore'; // تم التعديل: من $db_name إلى $dbname


// $host = 'sql101.infinityfree.com'; 
// $user = 'if0_42285753'; 
// $pass = '91uAtw2P5zaom'; 
// $dbname = 'if0_42285753_lapstore'; 

// إنشاء الاتصال باستخدام MySQLi
$conn = new mysqli($host, $user, $pass, $dbname);

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    // إذا فشل الاتصال، نقوم بإنشاء متغير الفولباك وإظهار رسالة تفصيلية للمطور
    $db_fallback = true;
    
    echo json_encode([
        "success" => false, 
        "message" => "فشل الاتصال بقاعدة البيانات: " . $conn->connect_error
    ]);
    exit;
}

// ضبط الترميز ليدعم اللغة العربية بشكل سليم
$conn->set_charset("utf8mb4");

// تفعيل الطلبات
$orders_enabled = true;
?>