<?php
session_start();
include('../includes/db.php');


if (!isset($_SESSION['vendor_id'])) {
    die("You must be logged in as a vendor to delete a product.");
}

$vendor_id = $_SESSION['vendor_id']; 


if (isset($_GET['id']) && isset($_SESSION['vendor_id'])) {
    $product_id = (int) $_GET['id'];
    $vendor_id = (int) $_SESSION['vendor_id'];

    // Step 1: Check if the product exists and belongs to the vendor
    $stmt = $conn->prepare("SELECT id FROM products WHERE id = ? AND vendor_id = ?");
    $stmt->bind_param("ii", $product_id, $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Step 2: Proceed to delete the product
        $delete_stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $delete_stmt->bind_param("i", $product_id);
        $delete_stmt->execute();

        if ($delete_stmt->affected_rows > 0) {
            header("Location: vendor_dash.php?deleted=1");
            exit;
        } else {
            // Optional: Handle failed deletion
            $error = "Failed to delete the product.";
        }

        $delete_stmt->close();
    } else {
        $error = "Product not found or access denied.";
    }

    $stmt->close();
} else {
    $error = "Invalid request.";
}



header("Location: vendor_dash.php");
exit;
?>
