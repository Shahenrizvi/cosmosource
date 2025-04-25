<?php
include('../includes/db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = (int) $_GET['id'];
    $stmt = $conn->prepare("UPDATE users SET registration_status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=UserApproved");
        exit;
    } else {
        echo "Error approving user: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
} else {
    echo "Invalid user ID.";
}

?>
