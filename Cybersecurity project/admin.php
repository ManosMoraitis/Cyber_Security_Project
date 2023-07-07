<?php
session_start();
$token = $_SESSION['csrf_token'];
if (isset($_SESSION['username']) && $_SESSION['type'] == "Admins") {
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
        </head>
        <body style="background-color: #333;color:white;">

<a href="../includes/logout.php"><span class="glyphicon glyphicon-log-out pull-right">Logout</span></a>
</head><br><br><center><h2>All Orders</h2></center> <body style="background-color: #333;color:white;">';

$conn = mysqli_connect('localhost', 'bookstore', 'test123', 'thelastchapter');


// Get the orders from the database
$query = "SELECT products.productSeller, products.productPrice, products.productName, orders.* FROM products INNER JOIN orders ON orders.idProduct = products.idProduct;";
$result = mysqli_query($conn, $query);
// Display the products in a table
echo '<div class="container"><table class="table">
<thead><tr>
                 <th>ProductName</th><th>Quantity</th><th>Price</th><th>Customer Name</th><th>Customer Address</th><th>Action</th></tr>';

while ($row = mysqli_fetch_array($result)) {
  echo "<tbody><tr>";
  echo "<td>" . $row['productName'] . "</td>";
  echo "<td>" . $row['ammountOrder'] . "</td>";
  echo "<td>" . $row['productPrice'] . "</td>";
  echo "<td>" . $row['customernameOrder'] . "</td>";
  echo "<td>" . $row['customerAddress'] . "</td>";
  echo "<td><form method='post' action='../includes/deleteorder.php'>";
  echo "<input type='hidden' name='idOrders' value='" . $row['idOrders'] . "'>";
  echo '<input type="hidden" name="csrf_token" value="'.$token.'">';
  echo '<input type="submit" name="submit" value="Delete" style="color:black;">';
  echo "</form></td>";
  echo "</tr>";
  
}
echo "</tbody></div></table>

<br><br><center><h2>All Books</h2></center>";
$query1 = "SELECT * FROM products;";
$result1 = mysqli_query($conn, $query1);
echo '<div class="container"><table class="table">
<thead><tr>
                 <th>ProductName</th><th>Product Seller</th><th>Price</th><th>Approved Status</th><th>Action</th></tr>';

while ($row = mysqli_fetch_array($result1)) {
  echo "<tbody><tr>";
  echo "<td>" . $row['productName'] . "</td>";
  echo "<td>" . $row['productSeller'] . "</td>";
  echo "<td>" . $row['productPrice'] . "</td>";
  if ($row['productApproved']) {
    echo "<td>Yes</td>";
    echo "<td></td>";
  } else {
    echo "<td>No</td>";
    echo "<td><form method='post' action='../includes/approveproduct.php'>";
    echo "<input type='hidden' name='idProduct' value='" . $row['idProduct'] . "'>";
    echo '<input type="submit" name="submit" value="Approve" style="color:black;">';
    echo '<input type="hidden" name="csrf_token" value="'.$token.'">';
    echo "</form></td>";
  }
  echo "</tr>";
  
}


echo "</tbody></div></table></body>";
    
?>