<?php
session_start();
include('../includes/db.php');

// Check if vendor is logged in
if (!isset($_SESSION['vendor_id'])) {
    die("You must be logged in as a vendor to view this page.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and assign input values
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $vendor_id = $_SESSION['vendor_id'] ?? null;

    // Validate basic input (optional but recommended)
    if (empty($name) || empty($price) || empty($vendor_id)) {
        $error = "Please fill out all required fields.";
    } else {
        // Prepare and execute the insert query
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, vendor_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $price, $description, $vendor_id);

        if ($stmt->execute()) {
            $success = "Product added successfully!";
        } else {
            $error = "Error adding product: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->  <nav class="bg-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-800">Cosmo Source</h1>
        </div>
        <div>
            <a href="vendor_dash.php" class="text-blue-500 hover:text-blue-600 px-3 py-2">Back to Dashboard</a>
            <a href="../auth/userlogin.php" onclick="return confirmLogout();" class="text-red-400 hover:text-red-600 px-3 py-2">Logout</a>
        </div>
    </nav>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you would like to logout?");
        }
    </script>

    <div class="flex justify-center p-8">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-3/4 md:w-1/2 lg:w-1/3">
            <h2 class="text-2xl font-semibold text-center mb-6">Add New Product</h2>
            
            <?php if (isset($success)): ?>
                <p class="text-green-500 mb-4"><?= $success ?></p>
            <?php elseif (isset($error)): ?>
                <p class="text-red-500 mb-4"><?= $error ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="name" name="name" class="w-full p-3 mt-1 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="text" id="price" name="price" class="w-full p-3 mt-1 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full p-3 mt-1 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none" required></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white p-3 rounded-md">Add Product</button>
            </form>
        </div>
    </div>

</body>
</html>
