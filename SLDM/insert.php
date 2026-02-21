<?php
include("db.php");


$product_id = $_GET['id'] ?? '';
$price      = $_GET['price'] ?? 0;
$quantity   = $_GET['qty'] ?? 0;   
$total      = $_GET['total'] ?? 0;
$user       = $_GET['user'] ?? '';
$contact    = $_GET['contact'] ?? '';


$total_cleaned = str_replace(',', '', $total);

if (!empty($product_id)) {
   
    $query = "INSERT INTO orders (stocks, total, user, contact) 
              VALUES ('$quantity', '$total_cleaned', '$user', '$contact')";

    if (mysqli_query($conn, $query)) {
        
        $update_stock = "UPDATE products SET stocks = stocks - $quantity WHERE id = $product_id";
        mysqli_query($conn, $update_stock);
        
        echo "<script>alert('Order Placed Successfully!'); window.location.href='Product.php';</script>";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    echo "Error: Missing Product ID.";
}
?>