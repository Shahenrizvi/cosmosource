<?php
session_start();
include('../includes/db.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    // Check if the user is an admin with hardcoded credentials
    if ($email === 'vishwacosmoadmin@gmail.com' && $password === '1234') {
        $_SESSION['user'] = 'Vishwa Cosmo Admin';
        $_SESSION['role'] = 'admin';
        $_SESSION['login_attempts'] = 0;
        header("Location: ../admin/dashboard.php");
        exit;
    }

    // Query the users table for the user with the provided email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();  // Fetch user data as associative array

        // Check if the user's account is approved
        if ($user['registration_status'] === 'approved') {
            // Validate the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id']; // Store the user ID in session

                // Store vendor ID if the role is vendor
                if ($user['role'] === 'vendor') {
                    $_SESSION['vendor_id'] = $user['id']; // Store vendor ID in session
                    header("Location: ../vendor/vendor_dash.php");  // Redirect to vendor dashboard
                    exit;
                }

                // Redirect based on the user's role
                if ($_SESSION['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                    exit;
                } else {
                    header("Location: ../products/index.php");
                    exit;
                }
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "Your account is not approved yet. Please wait for admin approval.";
        }
    } else {
        $error = "No user found with this email address.";
    }

    $_SESSION['login_attempts']++;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex-shrink-0 flex items-center">
                    <a href="index.php" class="text-gray-800 text-2xl font-bold flex items-center">Cosmo Source</a>
                </div>
                <div class="hidden md:flex space-x-4 items-center">
                    <a href="userlogin.php" class="text-gray-800 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium">Log In</a>
                    <a href="register.php" class="text-gray-800 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium">Sign Up</a>
                </div>

                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-button" class="text-gray-800 hover:text-purple-600 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden hidden bg-white">
            <a href="userlogin.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 hover:text-purple-600">Log In</a>
            <a href="register.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 hover:text-purple-600">Sign Up</a>
        </div>
    </nav>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="max-w-lg w-full bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-4xl font-bold text-center mb-6">Log In</h1>
            <?php if (isset($error)): ?>
                <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" class="w-full p-3 rounded-md bg-gray-200 focus:ring-2 focus:ring-purple-500 outline-none" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" class="w-full p-3 rounded-md bg-gray-200 focus:ring-2 focus:ring-purple-500 outline-none" required>
                </div>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <button type="submit" class="w-full bg-[#636AE8] hover:bg-[#4C5BD4] text-white p-3 rounded-md font-semibold transition">Sign In</button>
            </form>
            <div class="mt-4 text-center">
                <a href="register.php" class="text-purple-700 hover:text-purple-900">Don't have an account? Sign Up</a>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
