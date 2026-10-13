<?php
// API for NexTech Admin Dashboard
require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/json; charset=utf-8');

// For parsing JSON requests or form-data
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = [];
}
if (empty($input) && !empty($_POST)) {
    $input = $_POST;
}
$action = $_GET['action'] ?? ($input['action'] ?? '');

function uploadAndCompressImage($fileInputName, $uploadDir = 'uploads/') {
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return ["success" => false];
    }

    $fileTmpPath = $_FILES[$fileInputName]['tmp_name'];
    $fileName = $_FILES[$fileInputName]['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($fileExtension, $allowedExtensions)) return ["success" => false, "message" => "صيغة غير مدعومة"];

    // تحقق حقيقي من نوع الملف (مش بس من الامتداد) لمنع رفع ملفات ضارة باسم صورة
    $realMime = mime_content_type($fileTmpPath);
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($realMime, $allowedMimes)) return ["success" => false, "message" => "الملف المرفوع ليس صورة صالحة"];

    // ------------------------------------------------------------------
    // Fallback: لو مكتبة GD مش متاحة على السيرفر (شائع في بعض الاستضافات
    // المجانية)، بنرفع الصورة كما هي بدون ضغط أو تصغير بدل ما نوقف العملية.
    // ------------------------------------------------------------------
    if (!extension_loaded('gd')) {
        $newFileName = uniqid('product_', true) . '.' . $fileExtension;
        $destination = $uploadDir . $newFileName;
        if (move_uploaded_file($fileTmpPath, $destination)) {
            return ["success" => true, "path" => $destination];
        }
        return ["success" => false, "message" => "فشل رفع الصورة"];
    }

    $newFileName = uniqid('product_', true) . '.webp';
    $destination = $uploadDir . $newFileName;

    $sourceImage = null;
    if ($fileExtension === 'jpeg' || $fileExtension === 'jpg') $sourceImage = imagecreatefromjpeg($fileTmpPath);
    elseif ($fileExtension === 'png') $sourceImage = imagecreatefrompng($fileTmpPath);
    elseif ($fileExtension === 'webp') $sourceImage = imagecreatefromwebp($fileTmpPath);

    if (!$sourceImage) return ["success" => false, "message" => "تعذر معالجة الصورة"];

    $originalWidth = imagesx($sourceImage);
    $originalHeight = imagesy($sourceImage);
    $maxWidth = 800; $maxHeight = 800;
    $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
    $newWidth = ($originalWidth > $maxWidth || $originalHeight > $maxHeight) ? (int) round($originalWidth * $ratio) : $originalWidth;
    $newHeight = ($originalWidth > $maxWidth || $originalHeight > $maxHeight) ? (int) round($originalHeight * $ratio) : $originalHeight;

    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
    if ($fileExtension === 'png' || $fileExtension === 'webp') {
        imagealphablending($resizedImage, false);
        imagesavealpha($resizedImage, true);
        $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
        imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);
    }
    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
    imagewebp($resizedImage, $destination, 80);
    imagedestroy($sourceImage);
    imagedestroy($resizedImage);
    return ["success" => true, "path" => $destination];
}

$response = ['success' => false, 'message' => 'Invalid action'];

if (!empty($db_fallback)) {
    echo json_encode(['success' => false, 'message' => 'فشل الاتصال بقاعدة البيانات. يعمل النظام في وضع محدود.']);
    exit;
}

try {
    switch ($action) {
        case 'get_dashboard_data':
            // Get Products
            $products_res = $conn->query("SELECT id, name, category, brand, price, stock, description as `desc`, image FROM `products` ORDER BY id DESC");
            $products = [];
            if ($products_res) {
                while ($row = $products_res->fetch_assoc()) {
                    $products[] = $row;
                }
            }

            // Get Orders
            $orders_res = $conn->query("SELECT id, customer, phone, product, total, status FROM `orders` ORDER BY created_at DESC");
            $orders = [];
            if ($orders_res) {
                while ($row = $orders_res->fetch_assoc()) {
                    $orders[] = $row;
                }
            }

            // Get Stats
            $stats_res = $conn->query("SELECT SUM(total) as total_sales FROM `orders` WHERE status = 'مكتمل'");
            $total_sales = $stats_res ? ($stats_res->fetch_assoc()['total_sales'] ?? 0) : 0;

            $active_orders_res = $conn->query("SELECT COUNT(*) as active_count FROM `orders` WHERE status IN ('قيد التجهيز', 'قيد الانتظار')");
            $active_orders = $active_orders_res ? ($active_orders_res->fetch_assoc()['active_count'] ?? 0) : 0;

            // Monthly Sales Real Data
            $current_year = date('Y');
            $monthly_res = $conn->query("SELECT MONTH(created_at) as m, SUM(total) as s FROM `orders` WHERE YEAR(created_at) = $current_year AND status = 'مكتمل' GROUP BY m");
            $monthly_sales = array_fill(0, 12, 0);
            if ($monthly_res) {
                while ($row = $monthly_res->fetch_assoc()) {
                    $month_index = intval($row['m']) - 1;
                    $monthly_sales[$month_index] = floatval($row['s']);
                }
            }
            $response = [
                'success' => true,
                'products' => $products,
                'orders' => $orders,
                'stats' => [
                    'total_sales' => $total_sales,
                    'active_orders' => $active_orders,
                    'monthly_sales' => $monthly_sales
                ]
            ];
            break;

        case 'add_product':
            $name = trim($input['name'] ?? '');
            $category = trim($input['category'] ?? '');
            $brand = trim($input['brand'] ?? 'غير محدد');
            $price = isset($input['price']) && is_numeric($input['price']) ? floatval($input['price']) : null;
            $stock = isset($input['stock']) && is_numeric($input['stock']) ? intval($input['stock']) : null;
            $desc = trim($input['desc'] ?? '');
            $imagePath = '';

            if ($name === '' || $category === '' || $price === null || $stock === null) {
                $response = ['success' => false, 'message' => 'يرجى تعبئة كل الحقول المطلوبة بقيم صحيحة'];
                break;
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadRes = uploadAndCompressImage('image');
                if ($uploadRes['success']) {
                    $imagePath = $uploadRes['path'];
                } else {
                    $response = ['success' => false, 'message' => $uploadRes['message'] ?? 'فشل رفع الصورة'];
                    break;
                }
            }

            $stmt = $conn->prepare("INSERT INTO `products` (`name`, `category`, `brand`, `price`, `stock`, `description`, `image`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdiss", $name, $category, $brand, $price, $stock, $desc, $imagePath);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'تمت إضافة المنتج بنجاح!'];
            } else {
                $response = ['success' => false, 'message' => 'فشل في إضافة المنتج: ' . $stmt->error];
            }
            $stmt->close();
            break;

        case 'update_product':
            $id = intval($input['id'] ?? 0);
            $name = trim($input['name'] ?? '');
            $category = trim($input['category'] ?? '');
            $brand = trim($input['brand'] ?? 'غير محدد');
            $price = isset($input['price']) && is_numeric($input['price']) ? floatval($input['price']) : null;
            $stock = isset($input['stock']) && is_numeric($input['stock']) ? intval($input['stock']) : null;
            $desc = trim($input['desc'] ?? '');

            if ($id <= 0 || $name === '' || $category === '' || $price === null || $stock === null) {
                $response = ['success' => false, 'message' => 'يرجى تعبئة كل الحقول المطلوبة بقيم صحيحة'];
                break;
            }

            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadRes = uploadAndCompressImage('image');
                if ($uploadRes['success']) {
                    $imagePath = $uploadRes['path'];
                }
            }

            if ($imagePath !== null) {
                $stmt = $conn->prepare("UPDATE `products` SET `name`=?, `category`=?, `brand`=?, `price`=?, `stock`=?, `description`=?, `image`=? WHERE `id`=?");
                $stmt->bind_param("sssdissi", $name, $category, $brand, $price, $stock, $desc, $imagePath, $id);
            } else {
                // لو مفيش صورة جديدة، تُترك الصورة القديمة كما هي دون تعديل
                $stmt = $conn->prepare("UPDATE `products` SET `name`=?, `category`=?, `brand`=?, `price`=?, `stock`=?, `description`=? WHERE `id`=?");
                $stmt->bind_param("sssdisi", $name, $category, $brand, $price, $stock, $desc, $id);
            }

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'تم تحديث بيانات المنتج بنجاح!'];
            } else {
                $response = ['success' => false, 'message' => 'فشل في تحديث المنتج: ' . $stmt->error];
            }
            $stmt->close();
            break;

        case 'delete_product':
            $id = intval($input['id'] ?? 0);
            if ($id <= 0) {
                $response = ['success' => false, 'message' => 'معرف منتج غير صالح'];
                break;
            }
            $stmt = $conn->prepare("DELETE FROM `products` WHERE `id`=?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'تم حذف المنتج بنجاح!'];
            } else {
                $response = ['success' => false, 'message' => 'فشل في حذف المنتج'];
            }
            $stmt->close();
            break;

        case 'update_order_status':
            $id = trim($input['id'] ?? '');
            $status = trim($input['status'] ?? '');
            $allowedStatuses = ['قيد الانتظار', 'قيد التجهيز', 'تم الشحن', 'مكتمل', 'ملغي'];

            if ($id === '' || !in_array($status, $allowedStatuses, true)) {
                $response = ['success' => false, 'message' => 'بيانات غير صالحة'];
                break;
            }

            $stmt = $conn->prepare("UPDATE `orders` SET `status`=? WHERE `id`=?");
            $stmt->bind_param("ss", $status, $id);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'تم تحديث حالة الطلب بنجاح!'];
            } else {
                $response = ['success' => false, 'message' => 'فشل في تحديث حالة الطلب'];
            }
            $stmt->close();
            break;

        case 'delete_order':
            $id = trim($input['id'] ?? '');
            if ($id === '') {
                $response = ['success' => false, 'message' => 'معرف طلب غير صالح'];
                break;
            }
            $stmt = $conn->prepare("DELETE FROM `orders` WHERE `id`=?");
            $stmt->bind_param("s", $id);
            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'تم حذف الطلب بنجاح!'];
            } else {
                $response = ['success' => false, 'message' => 'فشل في حذف الطلب'];
            }
            $stmt->close();
            break;

        case 'create_order':
            global $orders_enabled;
            if (empty($orders_enabled)) {
                $response = ['success' => false, 'message' => 'عذراً، الطلبات مغلقة حالياً ولا يمكن استقبال طلبات جديدة.'];
                break;
            }

            $customer = trim($input['customer'] ?? '');
            $product_name = trim($input['product'] ?? '');
            $total = isset($input['total']) && is_numeric($input['total']) ? floatval($input['total']) : null;
            $phone = trim($input['phone'] ?? '');
            $address = trim($input['address'] ?? '');

            if ($customer === '' || $product_name === '' || $total === null) {
                $response = ['success' => false, 'message' => 'يرجى تعبئة بيانات الطلب بالكامل'];
                break;
            }

            if (!preg_match('/^01[0125][0-9]{8}$/', $phone)) {
                $response = ['success' => false, 'message' => 'يرجى إدخال رقم هاتف صحيح يتكون من 11 رقم (مثال: 01012345678)'];
                break;
            }

            $orderId = 'ORD-' . rand(10000, 99999);
            $status = 'قيد الانتظار';

            $stmt = $conn->prepare("INSERT INTO `orders` (`id`, `customer`, `phone`, `product`, `total`, `status`) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssds", $orderId, $customer, $phone, $product_name, $total, $status);

            if ($stmt->execute()) {
                $response = ['success' => true, 'message' => 'سيتم التواصل معك قريباً'];
            } else {
                $response = ['success' => false, 'message' => 'حدث خطأ أثناء تسجيل الطلب'];
            }
            $stmt->close();
            break;

        case 'get_store_products':
            $categories = isset($input['categories']) ? (is_array($input['categories']) ? $input['categories'] : array_filter(explode(',', $input['categories']))) : [];
            $brands = isset($input['brands']) ? (is_array($input['brands']) ? $input['brands'] : array_filter(explode(',', $input['brands']))) : [];
            $min_price = isset($input['min_price']) && $input['min_price'] !== '' ? floatval($input['min_price']) : 0;
            $max_price = isset($input['max_price']) && $input['max_price'] !== '' ? floatval($input['max_price']) : 9999999;
            $sort = $input['sort'] ?? 'newest';
            $page = max(1, intval($input['page'] ?? 1));
            $limit = max(1, min(100, intval($input['limit'] ?? 9))); // حد أقصى 100 عشان الحماية
            $offset = ($page - 1) * $limit;

            $where_clauses = ["price >= ?", "price <= ?"];
            $params = [$min_price, $max_price];
            $types = "dd";

            if (!empty($categories)) {
                $placeholders = implode(',', array_fill(0, count($categories), '?'));
                $where_clauses[] = "category IN ($placeholders)";
                foreach ($categories as $cat) {
                    $params[] = $cat;
                    $types .= "s";
                }
            }

            if (!empty($brands)) {
                $placeholders = implode(',', array_fill(0, count($brands), '?'));
                $where_clauses[] = "brand IN ($placeholders)";
                foreach ($brands as $brand) {
                    $params[] = $brand;
                    $types .= "s";
                }
            }

            $order_clause = "ORDER BY id DESC";
            if ($sort === 'price_asc') $order_clause = "ORDER BY price ASC";
            elseif ($sort === 'price_desc') $order_clause = "ORDER BY price DESC";
            elseif ($sort === 'most_sold') $order_clause = "ORDER BY id ASC";

            $where_sql = implode(' AND ', $where_clauses);

            // Count total for pagination
            $count_sql = "SELECT COUNT(*) as total FROM `products` WHERE $where_sql";
            $total_items = 0;
            $stmt_count = $conn->prepare($count_sql);
            if ($stmt_count) {
                $stmt_count->bind_param($types, ...$params);
                $stmt_count->execute();
                $total_items = $stmt_count->get_result()->fetch_assoc()['total'] ?? 0;
                $stmt_count->close();
            }

            // Fetch data
            $data_sql = "SELECT * FROM `products` WHERE $where_sql $order_clause LIMIT ? OFFSET ?";
            $store_products = [];
            $stmt_data = $conn->prepare($data_sql);
            if ($stmt_data) {
                $data_params = $params;
                $data_params[] = $limit;
                $data_params[] = $offset;
                $data_types = $types . "ii";
                $stmt_data->bind_param($data_types, ...$data_params);
                $stmt_data->execute();
                $res = $stmt_data->get_result();
                $while_counter = 0;
                while ($row = $res->fetch_assoc()) {
                    $store_products[] = $row;
                }
                $stmt_data->close();
            }

            $response = [
                'success' => true,
                'products' => $store_products,
                'total' => $total_items,
                'page' => $page,
                'limit' => $limit,
                'total_pages' => (int) ceil($total_items / $limit)
            ];
            break;
    }
} catch (Throwable $e) {
    // تعديل مخصص لعرض الخطأ الصريح ومنع تغطيته بجملة عامة
    $response = [
        'success' => false, 
        'message' => 'خطأ صريح في السيرفر: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ];
}

echo json_encode($response);
exit;