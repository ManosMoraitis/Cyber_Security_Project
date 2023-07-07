<?php
$servername = "localhost";
$username = "bookstore";
$password = "test123";
$dbname = "thelastchapter";
session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    header("Location: ../register.php?error=connection");
};

// Check if the form has been submitted
if (isset($_POST['submit']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    // Get the form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);
    //create a prepared statement
    $stmt1 = mysqli_prepare($conn, "SELECT * FROM users WHERE userName=?");
    //bind the parameter to the prepared statement
    mysqli_stmt_bind_param($stmt1, "s", $username);  
    //execute the prepared statement
    mysqli_stmt_execute($stmt1);
    //store the result
    mysqli_stmt_store_result($stmt1);
    if(mysqli_stmt_num_rows($stmt1) > 0){
        header("Location: ../register.php?error=userexists");
    };
    // Validate the form data
    if ($username == "" || $email == "" || $password == "" || $password_confirm == "") {
        header("Location: ../register.php?error=emptyfields");
    } else if ($password != $password_confirm) {
        header("Location: ../register.php?error=notsamepass");
    } else {


        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars || strlen($password) >= 20) {
            header("Location: ../register.php?error=passnotsatisfied");
        };
        if (strlen($username) < 4 || strlen($username) >= 12) {
            header("Location: ../register.php?error=userbad");
        };
        
        if ($_POST['type'] == 'buyer') {
            $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
            $address = mysqli_real_escape_string($conn, $_POST['address']);
            if ($firstname == "" || $lastname == "" || $address == "" || strlen($firstname) > 20 || strlen($lastname) > 20 || strlen($address) < 20 ) {
                header("Location: ../register.php?error=checkinputs");
            }
            $type = 1;
        } else if ($_POST['type'] == 'seller') {
            $firstname = "NULL";
            $lastname = "NULL";
            $address = "NULL";
            $type = 2;
        }
        // Hash the password for security
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        //prepared statement and execution
        $stmt = $conn->prepare("INSERT INTO users (userFirst, userLast, userName, userEmail, userPassword, userAddress, userType) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssssi', $firstname, $lastname, $username, $email, $password_hash, $address, $type);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header("Location: ../index.php");
    } 
} else {
    header("Location: ../index.php?error=badrequest");
};
?>