<?php
include('../includes/db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = (int) $_GET['id'];
    $stmt = $conn->prepare("UPDATE users SET registration_status = 'rejected' WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=UserRejected");
        exit;
    } else {
        echo "Error rejecting user: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    echo "Invalid user ID.";
}

?>
