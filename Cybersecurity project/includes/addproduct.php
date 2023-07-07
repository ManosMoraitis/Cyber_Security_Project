<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['type'] == "Sellers") {
// Connect to the MySQL database
$conn = mysqli_connect('localhost', 'bookstore', 'test123', 'thelastchapter');

// Check if the form has been submitted
if (isset($_POST['submit']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
  // Get the form data
  $productSeller = mysqli_real_escape_string($conn, $_SESSION['username']);
  $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
  $productName = mysqli_real_escape_string($conn, $_POST['productName']);

  // Insert the order into the database
  $query = "INSERT INTO products (productName, productSeller, productPrice, productApproved) VALUES ('$productName', '$productSeller', '$productPrice', false)";
  mysqli_query($conn, $query);
  mysqli_close($conn); 
  header("Location: ../seller.php?add=success");
} 
  else {
    header("Location: ../seller.php?add=fail");
  }
}
else {
    header("Location: ../index.php"); }
?>