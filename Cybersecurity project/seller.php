<?php
session_start();
$token = $_SESSION['csrf_token'];
if (isset($_SESSION['username']) && $_SESSION['type'] == "Sellers") {
    echo 'Correct'; }
else {
    header("Location: ../index.php");
    }
echo '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="../includes/jquery.js"></script>
        <script src="../includes/bootstrap.min.js"></script>
        
        
<link rel="stylesheet" type="text/css" href="../css/seller.css">
</head>
<body style="background-color: #333;color:white;">
<a href="../includes/logout.php"><span class="glyphicon glyphicon-log-out pull-right">Logout</span></a>
<br>
<center>
<div style="background-color: #F2F2F2; padding: 20px; border-radius: 10px; width: 30%">
  <form action="../includes/addproduct.php" method="post">
    <div style="margin-bottom: 20px;">
      <label for="input1" style="display: block; color: #333; font-size: 16px; font-weight: bold;">Book Name:</label>
      <input type="text" id="input1" name="productName" style="color: black;width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #CCC;">
    </div>
    <div style="margin-bottom: 20px;">
      <label for="input2" style="display: block; color: #333; font-size: 16px; font-weight: bold;">Price:</label>
      <input type="text" id="input2" name="productPrice" style="color: black;width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #CCC;">
    </div>
    '; echo '<input type="hidden" name="csrf_token" value="'.$token.'">'; echo '
    <button type="submit" name="submit" style="background-color: #333; color: #FFF; padding: 10px 20px; border-radius: 5px; border: none; font-size: 16px;">Add Book</button>
  </form>
</div>
</center>

'; 
echo '<br><br><center><h2>Orders of ' . $_SESSION['username'] .'</h2></center> ';
$conn = mysqli_connect('localhost', 'bookstore', 'test123', 'thelastchapter');


// Get the orders from the database
$sellerName = mysqli_real_escape_string($conn, $_SESSION['username']);
//create a prepared statement
$stmt = mysqli_prepare($conn, "SELECT products.productSeller, products.productPrice, products.productName, orders.* FROM products INNER JOIN orders ON orders.idProduct = products.idProduct WHERE productSeller=?;");

//bind the parameter to the prepared statement
mysqli_stmt_bind_param($stmt, "s", $sellerName);
//execute the prepared statement
mysqli_stmt_execute($stmt);

//store the result
mysqli_stmt_bind_result($stmt, $productSeller, $productPrice, $productName, $idOrder,  $idProduct, $customerName, $ammountOrder, $customerAddress);
// Display the products in a table
echo '<div class="container"><table class="table">
<thead><tr>
                 <th>ProductName</th><th>Quantity</th><th>Price</th><th>Customer Name</th><th>Customer Address</th></tr></thead>';

while (mysqli_stmt_fetch($stmt)) {
  echo "<tbody><tr>";
  echo "<td>" . $productName . "</td>";
  echo "<td>" . $ammountOrder . "</td>";
  echo "<td>" . $productPrice . "</td>";
  echo "<td>" . $customerName . "</td>";
  echo "<td>" . $customerAddress . "</td>";
  echo "</tr>";
  
}
echo "</tbody></table></div></body>";?>