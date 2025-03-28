<?php
session_start();
include('../includes/db.php');


if (!isset($_SESSION['vendor_id'])) {
    die("You must be logged in as a vendor to view this page.");
}

$vendor_id = $_SESSION['vendor_id'];  
$product_id = $_GET['id']; 


$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND vendor_id = ?");
$stmt->bind_param("ii", $product_id, $vendor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Product not found or you don't have permission to edit this product.");
}

$product = $result->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $update_stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
    $update_stmt->bind_param("sssi", $name, $price, $description, $product_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Product updated successfully'); window.location.href='vendor_dash.php';</script>";
    } else {
        echo "<script>alert('Error updating product');</script>";
    }
}

$vendor_id = $_SESSION['vendor_id'];  


$stmt = $conn->prepare("SELECT username FROM users WHERE id = ? AND registration_status = 'approved'");
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Vendor not found or not approved.");
}

$vendor = $result->fetch_assoc();
$vendor_name = $vendor['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-800">Cosmo Source</h1>
        </div>
        <div>
            <a href="../auth/userlogin.php" onclick="return confirmLogout();" class="text-red-400 hover:text-red-600 px-3 py-2">Logout</a>
        </div>
    </nav>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you would like to logout?");
        }
    </script>

    <div class="flex">
        <aside class="w-1/4 bg-white p-4 min-h-screen shadow-md">
            <div class="flex flex-col items-center">
                <div class="bg-gray-200 rounded-full h-32 w-32 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a4 4 0 00-4 4v4a4 4 0 004 4h0a4 4 0 004-4V6a4 4 0 00-4-4zm0 16c-2.5 0-4.5 1.5-4.5 3.5S9.5 23 12 23s4.5-1.5 4.5-3.5S14.5 18 12 18z"></path></svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-700"><?= htmlspecialchars($vendor_name) ?></h2>
                <span class="bg-blue-500 text-white px-8 py-1 rounded-full text-sm">Vendor</span>
            </div>
        </aside>



        <main class="w-3/4 p-8">
            <h3 class="text-2xl font-semibold mb-4">Edit Product</h3>

            <form action="edit_product.php?id=<?= $product['id'] ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold">Product Name</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-sm font-semibold">Price</label>
                    <input type="text" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-semibold">Description</label>
                    <textarea id="description" name="description" required class="w-full p-3 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-3 rounded-md">Update Product</button>
                    <a href="vendor_dash.php" class="text-red-500 hover:text-red-600">Cancel</a>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
