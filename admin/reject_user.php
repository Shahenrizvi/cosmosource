<?php
include('../includes/db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("UPDATE users SET registration_status = 'rejected' WHERE id = $id");
    header('Location: dashboard.php'); 
}
?>
