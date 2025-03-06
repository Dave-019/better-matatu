<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        session_write_close();

        $role = strtolower(trim($user['role']));

        switch ($user['role']) {
            case 'passenger':
                header('Location: ../passanger/dashboard.php');
                break;
            case 'sacco_admin':
                header('Location: ../pages/sacco.php');
                break;
            case 'super_admin':
                header('Location: ../pages/driver.php');
                break;
            default:
                header('Location: login.php');
                break;
        }
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="../src/custom.css">
</head>
<body>
    <div class="bg-gray-50 font-['cascadia','lora']">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-md w-full">
                <div class="p-8 rounded-2xl bg-white shadow">
                    <h2 class="text-gray-800 text-center text-2xl font-bold">Sign in</h2>
                    <?php if (isset($error)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline"><?php echo htmlspecialchars($error); ?></span>
                        </div>
                    <?php endif; ?>
                    <form action="login.php" method="POST" class="mt-8 space-y-4">
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Email</label>
                            <div class="relative flex items-center">
                                <input name="email" type="email" required class="w-full text-gray-800 text-sm border border-gray-300 px-4 py-3 rounded-md outline-oklch-51" placeholder="Enter email" />
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <div class="relative flex items-center">
                                <input name="password" type="password" required class="w-full text-gray-800 text-sm border border-gray-300 px-4 py-3 rounded-md outline-oklch-51" placeholder="Enter password" />
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div></div>
                            <div class="text-sm">
                                <a href="javascript:void(0);" class="text-oklch-51 hover:underline font-semibold">
                                    Forgot your password?
                                </a>
                            </div>
                        </div>
                        <div class="!mt-8">
                            <button type="submit" class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-[#4f39f6] hover:cursor focus:outline-none">
                                Sign in
                            </button>
                        </div>
                        <p class="text-gray-800 text-sm !mt-8 text-center">Don't have an account? <a href="register.php" class="text-oklch-51 hover:underline ml-1 whitespace-nowrap font-semibold">Register here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
