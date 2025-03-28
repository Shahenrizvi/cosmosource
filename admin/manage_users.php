<?php
session_start();

include('../includes/db.php');

$stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE role != 'admin'");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="bg-gray-800 p-4 flex justify-between items-center">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold">Cosmo Source</h1>
        </div>
        <a href="dashboard.php" class="text-gray-300 hover:text-white px-3 py-2">Back to Dashboard</a>
    </nav>


    <div class="flex">
        <aside class="w-1/4 bg-gray-800 p-4 min-h-screen">
            <div class="flex flex-col items-center">
                <div class="bg-gray-700 rounded-full h-24 w-24 flex items-center justify-center">

                </div>
                <h2 class="text-lg font-bold mt-10">Vishwa De Silva</h2>
                <span class="bg-blue-500 text-white px-8 py-1 rounded-full text-sm">Admin</span>
            </div>
        </aside>


        <main class="w-3/4 p-8">
            <h2 class="text-3xl font-bold mb-4 text-center">Manage Users</h2>
            <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
                <input type="text" placeholder="Search user" class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white mb-4 focus:ring-2 focus:ring-blue-500">
                <table class="table-auto w-full text-left bg-gray-800 text-white rounded-lg">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="p-4">ID</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Role</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-700">
                                <td class="p-4"><?= htmlspecialchars($row['id']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($row['username']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($row['email']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($row['role']) ?></td>
                                <td class="p-4">
                                    <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="text-red-400 hover:text-red-600">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
