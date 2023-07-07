<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['type'] == "Customers") {
// Connect to the MySQL database
$conn = mysqli_connect('localhost', 'bookstore', 'test123', 'thelastchapter');

// Check if the form has been submitted
if (isset($_POST['submit']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
  // Get the form data
  $customerName = mysqli_real_escape_string($conn, $_SESSION['username']);
  $idProduct = mysqli_real_escape_string($conn, $_POST['idProduct']);
  $ammount = mysqli_real_escape_string($conn, $_POST['ammount']);
  $address = mysqli_real_escape_string($conn, $_SESSION['address']);

  // Insert the order into the database
  $query = "INSERT INTO orders (idProduct, customernameOrder, ammountOrder, customerAddress) VALUES ('$idProduct', '$customerName', '$ammount', '$address')";
  mysqli_query($conn, $query);
  mysqli_close($conn); 
  header("Location: ../shop.php?order=success");} 
  else {
    header("Location: ../shop.php?order=fail");
  }
}
else {
    header("Location: ../index.php"); }
?>