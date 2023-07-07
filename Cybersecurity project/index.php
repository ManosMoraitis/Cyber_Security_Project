<?php
session_start();
if (!isset($_POST['csrf_token'])) {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
}
if (isset($_GET['login']) && $_GET['login'] == "wrongcombo") {
    echo '<div class="alert alert-warning alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <center><strong>Warning!</strong> Wrong Username / Password combination.</center>
  </div>';
};
if (isset($_GET['login']) && $_GET['login'] == "notapproved") {
  echo '<div class="alert alert-warning alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <center>Please wait for an Administrator to approve your membership.</center>
</div>';
};
if (isset($_GET['logout']) && $_GET['logout'] == "success") {
    echo '<div class="alert alert-success alert-dismissible" id="success-alert">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <center> You have successfully logged out of your account!</center>
    </div>';
};
if (isset($_SESSION['username']) && $_SESSION['type'] == "Customers") {
    header("Location: ../shop.php"); 
} else if (isset($_SESSION['username']) && $_SESSION['type'] == "Sellers") {
    header("Location: ../seller.php");
} else if (isset($_SESSION['username']) && $_SESSION['type'] == "Admins") {
    header("Location: ../admin.php");
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../includes/jquery.js"></script>
    <script src="../includes/bootstrap.min.js"></script>
    <link rel="icon" href="resources/favicon.ico">
    <style type="text/css">
        .login-form {
            width: 340px;
            margin: 50px auto;
        }

        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
            border-radius: 25px;
        }

        .login-form h2 {
            margin: 0 0 15px;
        }

        .form-control,
        .btn {
            min-height: 38px;
            border-radius: 2px;
        }

        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body style="background-color: #333;">
    <div class="login-form">
        <form action="includes/loginsys.php" method="POST">
            <h2 class="text-center">Log in</h2>
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required="required">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="required">
            </div>
            <?php echo '<input type="hidden" name="csrf_token" value="'.$token.'">'; ?>
            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Log in</button>
            </div>
            <p class="text-center"><a href="register.php" style="color: rgb(16, 233, 45);"><b>Register An
                        Account</b></a></p>
        </form>

    </div>
</body>

</html>