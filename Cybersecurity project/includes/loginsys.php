<?php
session_start();
if (isset($_SESSION["username"])) {
  if ($_SESSION["type"] = "Customers" ) {
    header("Location: ../shop.php"); 
  } else if ($_SESSION["type"] = "Sellers") {
    header("Location: ../seller.php");
  } else if ($_SESSION["type"] = "admin") {
    header("Location: ../admin.php");
  }
}
$servername = "localhost";
$user = "bookstore";
$pass = "test123";
$dbname = "thelastchapter";

// Create connection
$mysqli = new mysqli($servername, $user, $pass, $dbname);


  if ($mysqli) {
    // Check if the form was submitted
    
    if (isset($_POST["submit"]) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
      $stmt = $mysqli->prepare("SELECT * FROM users WHERE userName = ?");
      // Get the username and password from the form
      $username = mysqli_real_escape_string($mysqli, $_POST["username"]);
      $password = mysqli_real_escape_string($mysqli, $_POST["password"]);
      $stmt->bind_param("s", $username);
      $stmt->execute();
      // Fetch the result
      $result = $stmt->get_result();  
      // Check if a matching row was found
      if ($result->num_rows > 0) {
          $user = $result->fetch_assoc();
      // Verify the password using the bcrypt algorithm
      if (password_verify($password, $user['userPassword'])) {
      // Start a session and set a session variable to indicate that the user is logged in
      $_SESSION['username'] = $user['userName'];
      $_SESSION['email'] = $user['userEmail'];
      if ($user['userType'] == 1) {
        $_SESSION['type'] = "Customers";
        $_SESSION['first'] = $user["userFirst"];
        $_SESSION['last'] = $user["userLast"];
        $_SESSION['address'] = $user["userAddress"];
        header("Location: ../shop.php");
      } else if ($user['userType'] == 2) {
        $_SESSION['type'] = "Sellers";
        header("Location: ../seller.php");
      } else if ($user['userType'] == 3) {
        $_SESSION['type'] = "Admins";
        header("Location: ../admin.php");
      }
     } else { 
      // Return an error message
      header("Location: ../index.php?error=wrongcombo");
  }
} else {
  // Return an error message
  header("Location: ../index.php?error=wrongcombo");
}
    } else {
      header("Location: ../index.php?error=badrequest");
    } }
    $stmt->close();
    $mysqli->close();
    ?>

