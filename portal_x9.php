<?php
session_start();

// Admin credentials (Hardcoded for security, prevents SQL injection)
// Username: admin
// Password: LapStore@Admin2024
$admin_username = 'admin';
$admin_password_hash = '$2y$10$j.FxBi4dxzeJFVeVefAD5eK1JmbZFPZE/w540XHPuayh5XdPLtQxO'; // generated via password_hash('LapStore@Admin2024', PASSWORD_DEFAULT);

// Logout handling
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: portal_x9.php");
    exit;
}

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Generate CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Brute-force protection
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Verify CSRF
    if (!hash_equals($_SESSION['csrf_token'], $csrf_token)) {
        $error_msg = "Invalid request token.";
    } elseif ($_SESSION['login_attempts'] >= 5) {
        $error_msg = "لقد تجاوزت الحد الأقصى لمحاولات تسجيل الدخول. يرجى المحاولة لاحقاً.";
    } else {
        if ($username === $admin_username && password_verify($password, $admin_password_hash)) {
            // Success
            session_regenerate_id(true); // Prevent session fixation
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['login_attempts'] = 0; // Reset
            header("Location: dashboard.php");
            exit;
        } else {
            $_SESSION['login_attempts']++;
            $error_msg = "اسم المستخدم أو كلمة المرور غير صحيحة.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Access Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #0A0F1D;
            color: #E2E8F0;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Grid Background -->
    <div class="absolute inset-0 z-0 opacity-10" style="background-image: linear-gradient(#2563EB 1px, transparent 1px), linear-gradient(90deg, #2563EB 1px, transparent 1px); background-size: 40px 40px; mask-image: radial-gradient(ellipse 70% 70% at 50% 50%, black 40%, transparent 100%);"></div>

    <div class="bg-[#141B2D] border border-slate-800 p-8 rounded-2xl shadow-2xl z-10 w-full max-w-md">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-white mb-2 tracking-wide">SECURE GATEWAY</h2>
            <p class="text-slate-500 text-sm">Restricted Area - Authorized Personnel Only</p>
        </div>

        <?php if ($error_msg): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm p-3 rounded-lg mb-6 text-center">
                <?php echo htmlspecialchars($error_msg); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 tracking-wider">USERNAME</label>
                    <input type="text" name="username" required class="w-full bg-[#0A0F1D] border border-slate-800 rounded-lg px-4 py-3 text-slate-200 outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" autocomplete="off" placeholder="Admin username">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-2 tracking-wider">PASSWORD</label>
                    <input type="password" name="password" required class="w-full bg-[#0A0F1D] border border-slate-800 rounded-lg px-4 py-3 text-slate-200 outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition" placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-lg transition-colors duration-300 mt-2 shadow-lg shadow-blue-600/20">
                    AUTHENTICATE
                </button>
            </div>
        </form>
    </div>
</body>
</html>
