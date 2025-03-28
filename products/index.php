<?php
include('../includes/db.php');

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cosmo sorce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white p-4 flex justify-between items-center shadow-md">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-800">Cosmo Source</h1>
        </div>
        <div class="flex space-x-4">
            <a href="../auth/userlogin.php" onclick="return confirmLogout();" class="text-purple-700 hover:text-purple-900">Log out</a>
        </div>
    </nav>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you would like to logout?");
        }
    </script>

    <main class="p-8">
        <h2 class="text-3xl font-bold mb-4 text-center text-gray-800">Browse Through Products</h2>
        <?php if ($result->num_rows > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 overflow-y-scroll h-[80vh]">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                        <div class="h-48 w-full bg-gray-200 rounded-md mb-4 flex items-center justify-center">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="h-full w-full object-cover rounded-md">
                            <?php else: ?>
                                <span class="text-gray-400 text-sm">Image Not Available</span>
                            <?php endif; ?>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="text-gray-600"><strong>Price:</strong> $<?= htmlspecialchars($product['price']) ?></p>
                        <p class="text-gray-500 mt-2 text-sm"><?= htmlspecialchars($product['description']) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No products available.</p>
        <?php endif; ?>
    </main>

</body>
</html>
