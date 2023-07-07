<?php
session_start();
$token = $_SESSION['csrf_token'];
if (isset($_SESSION['username']) && $_SESSION['type'] == "Customers") {
    echo 'Correct'; }
else {
    header("Location: ../index.php");
    } ?>
<?php
  if (isset($_GET['order']) && $_GET['order'] == "success") {
    echo '<div class="alert alert-success alert-dismissible" id="success-alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <center> You have successfully placed your order!</center>
    </div>';
};
if (isset($_GET['order']) && $_GET['order'] == "fail") {
  echo '<div class="alert alert-warning alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <center>Order not placed successfully.</center>
</div>';
};

$conn = mysqli_connect('localhost', 'bookstore', 'test123', 'thelastchapter');
echo '<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="../includes/jquery.js"></script>
        <script src="../includes/bootstrap.min.js"></script>
        <script>
        function logout(){
        // send a post request to the logout.php script
        fetch("../includes/logout.php", {
        method: "post",
        credentials: "same-origin"
    })
    .then(response => {
        // handle the response
        if(response.ok){
            // redirect the user to the login page or show a message
            window.location.href = "../index.php";
        }
    })
    .catch(error => {
        console.log(error);
    });
}
</script>
        </head>
        <body style="background-color: #333;color:white;">';

// Get the products from the database
$query = "SELECT * FROM products WHERE productApproved = 1";
$result = mysqli_query($conn, $query);
// Display the products in a table
echo "<a href='../includes/logout.php'><span class='glyphicon glyphicon-log-out pull-right'>Logout</span></a> <div class='container'><table class='table'>
<thead><tr>
                 <th>Product</th><th>Seller</th><th>Price</th><th>Buy</th></tr>";

while ($row = mysqli_fetch_array($result)) {
  echo "<tbody><tr>";
  echo "<td>" . $row['productName'] . "</td>";
  echo "<td>" . $row['productSeller'] . "</td>";
  echo "<td>" . $row['productPrice'] . "</td>";
  echo "<td><form method='post' action='../includes/buysys.php'>";
  echo '<input type="hidden" name="csrf_token" value="'.$token.'">';
  echo "<input type='hidden' name='idProduct' value='" . $row['idProduct'] . "'>";
  echo "<select style='color:black;' name='ammount'>";
  echo "<option value='1'>1</option>";
  echo "<option value='2'>2</option>";
  echo "<option value='3'>3</option>";
  echo "<option value='4'>4</option>";
  echo "<option value='5'>5</option>";
  echo "</select>";
  echo '<input type="submit" name="submit" value="Buy" style="color:black;">';
  echo "</form></td>";
  echo "</tr>";
}
echo "</tbody></div></table>";


// Close the database connection
mysqli_close($conn);

?>