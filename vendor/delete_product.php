<?php
session_start();
include('../includes/db.php');


if (!isset($_SESSION['vendor_id'])) {
    die("You must be logged in as a vendor to delete a product.");
}

$vendor_id = $_SESSION['vendor_id']; 


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND vendor_id = ?");
    $stmt->bind_param("ii", $product_id, $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $delete_stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $delete_stmt->bind_param("i", $product_id);
        $delete_stmt->execute();

        if ($delete_stmt->affected_rows > 0) {
            header("Location: vendor_dash.php");
            exit;
        }
    }
}


header("Location: vendor_dash.php");
exit;
?>
