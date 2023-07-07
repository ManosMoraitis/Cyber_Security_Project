<?php
$servername = "localhost";
$username = "bookstore";
$password = "test123";
$dbname = "thelastchapter";
session_start();
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    header("Location: ../admin.php?error=connection");
};
if (isset($_POST['submit']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    $idorders = mysqli_real_escape_string($mysqli, $_POST['idOrders']);
    $stmt = $mysqli->prepare("DELETE from orders WHERE idOrders = ?");
    $stmt->bind_param("i", $idorders);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();
    header("Location: ../admin.php");
} else {
    header("Location: ../admin.php");
}
?>