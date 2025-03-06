<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = trim($_POST['role'] ?? '');
    $frequent_routes = isset($_POST['frequent_routes']) ? json_encode($_POST['frequent_routes']) : null;
    $emergency_contact = trim($_POST['emergency_contact'] ?? '');
    $sacco_id = isset($_POST['sacco_id']) ? intval($_POST['sacco_id']) : null;

    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password) || empty($role)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch();
            if ($result) {
                $error = "Email already registered.";
            } else {
                $passwordHash = password_hash($password, PASSWORD_BCRYPT);

                $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password_hash, role) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $phone, $passwordHash, $role]);

                if ($stmt->rowCount() > 0) {
                    $userId = $pdo->lastInsertId();

                    if ($role === 'passenger') {
                        $stmt = $pdo->prepare("INSERT INTO passengers (user_id, phone, frequent_routes, emergency_contact, created_at) VALUES (?, ?, ?, ?, NOW())");
                        $stmt->execute([$userId, $phone, $frequent_routes, $emergency_contact]);

                        if ($stmt->rowCount() > 0) {
                            header('Location: login.php');
                            exit;
                        } else {
                            $error = "Failed to create passenger record.";
                        }
                    } elseif ($role === 'sacco_admin') {
                        if (is_null($sacco_id)) {
                            $error = "SACCO must be selected.";
                        } else {
                            $stmt = $pdo->prepare("UPDATE users SET sacco_id = ? WHERE id = ?");
                            $stmt->execute([$sacco_id, $userId]);

                            if ($stmt->rowCount() > 0) {
                                header('Location: login.php');
                                exit;
                            } else {
                                $error = "Failed to associate user with SACCO.";
                            }
                        }
                    } else {
                        header('Location: login.php');
                        exit;
                    }
                } else {
                    $error = "Registration failed. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}

try {
    $stmt = $pdo->query("SELECT id, name FROM sacco_cooperatives");
    $saccos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../output.css">
    <link rel="stylesheet" href="../src/custom.css">
   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const passengerFields = document.getElementById('passenger-fields');
            const saccoAdminFields = document.getElementById('sacco-admin-fields');

            roleSelect.addEventListener('change', function() {
                if (this.value === 'passenger') {
                    passengerFields.style.display = 'block';
                    saccoAdminFields.style.display = 'none';
                } else if (this.value === 'sacco_admin') {
                    passengerFields.style.display = 'none';
                    saccoAdminFields.style.display = 'block';
                } else {
                    passengerFields.style.display = 'none';
                    saccoAdminFields.style.display = 'none';
                }
            });

            if (roleSelect.value !== 'passenger' && roleSelect.value !== 'sacco_admin') {
                passengerFields.style.display = 'none';
                saccoAdminFields.style.display = 'none';
            }
        });
    </script>
</head>
<body>
    <div class="bg-gray-50 font-['cascadia','lora']">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-md w-full">
                <div class="p-8 rounded-2xl bg-white shadow">
                    <h2 class="text-gray-800 text-center text-2xl font-bold">Register</h2>
                    <?php if (isset($error)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    <form action="register.php" method="POST" class="mt-8 space-y-4">
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Name</label>
                            <input name="name" type="text" required class="w-full border border-gray-300 px-4 py-3 rounded-md" placeholder="Enter name" />
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Email</label>
                            <input name="email" type="email" required class="w-full border border-gray-300 px-4 py-3 rounded-md" placeholder="Enter email" />
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Phone</label>
                            <input name="phone" type="tel" required class="w-full border border-gray-300 px-4 py-3 rounded-md" placeholder="Enter phone number" />
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Password</label>
                            <input name="password" type="password" required class="w-full border border-gray-300 px-4 py-3 rounded-md" placeholder="Enter password" />
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Confirm Password</label>
                            <input name="confirm_password" type="password" required class="w-full border border-gray-300 px-4 py-3 rounded-md" placeholder="Confirm password" />
                        </div>
                        <div>
                            <label class="text-gray-800 text-sm mb-2 block">Role</label>
                            <select id="role" name="role" required class="w-full border border-gray-300 px-4 py-3 rounded-md">
                                <option value="">Select Role</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="sacco_admin">SACCO Admin</option>
                                <option value="passenger">Passenger</option>
                            </select>
                        </div>
                        <div id="passenger-fields" class="space-y-4">
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">Frequent Routes</label>
                                <input name="frequent_routes[]" type="text" class="w-full border border-gray-300 px-4 py-3 rounded-md" placeholder="Enter frequent routes (sagana, nyeri)" />
                            </div>
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">Emergency Contact</label>
                                <input name="emergency_contact" type="tel" class="w-full border border-gray-300 px-4 py-3 rounded-md" placeholder="Enter emergency contact number" />
                            </div>
                        </div>
                        <div id="sacco-admin-fields" class="space-y-4">
                            <div>
                                <label class="text-gray-800 text-sm mb-2 block">Select SACCO</label>
                                <select name="sacco_id" required class="w-full border border-gray-300 px-4 py-3 rounded-md">
                                    <option value="">Select SACCO</option>
                                    <?php foreach ($saccos as $sacco): ?>
                                        <option value="<?php echo htmlspecialchars($sacco['id']); ?>"><?php echo htmlspecialchars($sacco['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mt-8">
                            <button type="submit" class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 cursor-pointer hover:bg-blue-700">
                                Register
                            </button>
                        </div>
                        <p class="text-gray-800 text-sm mt-8 text-center">
                            Already have an account? <a href="login.php" class="text-blue-600 hover:underline ml-1 font-semibold">Login here</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>