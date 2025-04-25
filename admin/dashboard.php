<?php
session_start();
include('../includes/db.php');
$pending_result = $conn->query("SELECT * FROM users WHERE registration_status = 'pending'");
$approved_result = $conn->query("SELECT * FROM users WHERE registration_status = 'approved'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <h2 class="text-lg font-bold mt-10">Vishwa De Silva</h2>
                <span class="bg-blue-500 text-white px-8 py-1 rounded-full text-sm">Admin</span>
            </div>
        </aside>

        <main class="w-3/4 p-8">
            <h3 class="text-2xl font-semibold mb-4">New Registrations</h3>
            <?php if ($pending_result->num_rows > 0): ?>
                <table class="table-auto w-full bg-white text-gray-800 rounded-md shadow-md">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">ID</th>
                            <th class="p-4">Full Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Registration Status</th>
                            <th class="p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $pending_result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="p-4"><?= $user['id'] ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="p-4 text-yellow-500 font-semibold">Pending</td>
                                <td class="p-4">
                                    <a href="approve_user.php?id=<?= $user['id'] ?>" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">Approve</a>
                                    <a href="reject_user.php?id=<?= $user['id'] ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Reject</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-500">No pending registrations.</p>
            <?php endif; ?>

            <h3 class="text-2xl font-semibold mt-6 mb-4">Active Users (Approved)</h3>
            <?php if ($approved_result->num_rows > 0): ?>
                <table class="table-auto w-full bg-white text-gray-800 rounded-md shadow-md">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4">ID</th>
                            <th class="p-4">Full Name</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Registration Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $approved_result->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="p-4"><?= $user['id'] ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="p-4"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="p-4">
                                    <span class="bg-green-200 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-500">No approved users.</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
