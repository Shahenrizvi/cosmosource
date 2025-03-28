<?php
session_start();
include('../includes/db.php');



if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare and execute query to delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php");  // Redirect back to the admin dashboard after successful deletion
        exit;
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
}
?>
