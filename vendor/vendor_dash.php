<?php
session_start();
include('../includes/db.php');

// Check if vendor is logged in
if (!isset($_SESSION['vendor_id'])) {
    die("You must be logged in as a vendor to view this page.");
}

$vendor_id = $_SESSION['vendor_id'];  // Get vendor_id from session

// Fetch vendor name from the database using registration_status
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
    <title>Vendor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-800">Cosmo Source</h1>
        </div>
        <div>
            <a href="../auth/userlogin.php" onclick="return confirmLogout();" class="text-red-500 hover:text-red-700 px-3 py-2">Logout</a>
        </div>
    </nav>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you would like to logout?");
        }
    </script>

    <div class="flex min-h-screen">
        <aside class="w-1/4 bg-white p-4 min-h-screen shadow-md">
            <div class="flex flex-col items-center">
                <div class="bg-gray-200 rounded-full h-32 w-32 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a4 4 0 00-4 4v4a4 4 0 004 4h0a4 4 0 004-4V6a4 4 0 00-4-4zm0 16c-2.5 0-4.5 1.5-4.5 3.5S9.5 23 12 23s4.5-1.5 4.5-3.5S14.5 18 12 18z"></path></svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-700"><?= htmlspecialchars($vendor_name) ?></h2>
                <span class="bg-blue-500 text-white px-8 py-1 rounded-full text-sm">Vendor</span>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="w-3/4 p-8">
            <h3 class="text-3xl font-semibold text-gray-800 mb-6">My Products</h3>

            <!-- Add Product Button -->
            <a href="add_product.php" class="bg-blue-500 hover:bg-blue-700 text-white px-6 py-3 rounded-md mb-6 inline-block shadow-md hover:shadow-lg transition-all">Add Product</a>

            <!-- Vendor's Product Listing -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h4 class="text-xl font-semibold text-gray-800 mb-6">Your Products</h4>

                <?php
                // Fetch products associated with this vendor
                $stmt = $conn->prepare("SELECT * FROM products WHERE vendor_id = ?");
                $stmt->bind_param("i", $vendor_id);
                $stmt->execute();
                $products = $stmt->get_result();

                if ($products->num_rows > 0):
                ?>
                    <table class="min-w-full table-auto bg-white text-gray-800 rounded-md shadow-md">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-4 text-left font-semibold">Product ID</th>
                                <th class="p-4 text-left font-semibold">Product Name</th>
                                <th class="p-4 text-left font-semibold">Price</th>
                                <th class="p-4 text-left font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = $products->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4"><?= $product['id'] ?></td>
                                    <td class="p-4"><?= htmlspecialchars($product['name']) ?></td>
                                    <td class="p-4"><?= htmlspecialchars($product['price']) ?></td>
                                    <td class="p-4">
                                        <!-- Edit Button -->
                                        <a href="edit_product.php?id=<?= $product['id'] ?>" 
                                        class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2 rounded-md inline-block transition duration-300 ease-in-out transform hover:scale-105">
                                        Edit
                                        </a>
                                        |
                                        <!-- Delete Button -->
                                        <a href="delete_product.php?id=<?= $product['id'] ?>" 
                                        class="text-white bg-red-500 hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 px-4 py-2 rounded-md inline-block transition duration-300 ease-in-out transform hover:scale-105"
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-500">You have not added any products yet.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

</body>
</html>
