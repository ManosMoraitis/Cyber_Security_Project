<?php 
session_start();
$token = $_SESSION['csrf_token'];
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
                .form-control, .btn {
                    min-height: 38px;
                    border-radius: 2px;
                }
                .btn {        
                    font-size: 15px;
                    font-weight: bold;
                }
            </style>
            
<script>
function disableTextboxes() {
var select = document.getElementById("select");
var firstname = document.getElementById("firstname");
var lastname = document.getElementById("lastname");
var address = document.getElementById("address");
    if(select.value === "seller"){
        firstname.disabled = true;
        lastname.disabled = true;
        address.disabled = true;
        lastname.style.display = "none";
        firstname.style.display = "none";
        address.style.display = "none";
        <?php echo "test"; ?>
    }else{
        firstname.disabled = false;
        lastname.disabled = false;
        address.disabled = false;
        lastname.style.display = "block";
        firstname.style.display = "block";
        address.style.display = "block";
    }};
    
</script>

        </head>

<body style="background-color: #333;">
            <div class="login-form">
                            <form action="includes/registersys.php" method="POST">
                                <h2 class="text-center">Register</h2>       
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                                </div>
                                <div class="form-group">
                                    <input id="firstname" type="text" name="firstname" class="form-control" placeholder="First Name" required="required">
                                </div>
                                <div class="form-group">
                                    <input id="lastname" type="text" name="lastname" class="form-control" placeholder="Last Name" required="required">
                                </div>
                                <?php echo '<input type="hidden" name="csrf_token" value="'.$token.'">'; ?>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="E-mail" required="required">
                                </div>
                                <div class="form-group">
                                    <input id="address" type="text" name="address" class="form-control" placeholder="Address" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password_confirm" class="form-control" placeholder="Password Confirm" required="required">
                                </div>
                                <div class="form-group">
                                    <select id="select" class="form-control" name='type' onchange="disableTextboxes()">";
                                        <option value='buyer'>Buyer</option>";
                                        <option value='seller'>Seller</option>";
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
                                </div>
                            
                                     
                            </form>
                            
            </div>
</body>
</html>