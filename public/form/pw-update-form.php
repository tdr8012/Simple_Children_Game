<?php
session_start();
$error_message = isset($_GET['error_message']) ? $_GET['error_message'] : '';

// Output the error message if it's not empty
if (!empty($error_message)) {
    echo "<div class='error-message'></div>";}
    $success_message = isset($_GET['success_message']) ? $_GET['success_message'] : '';

// Output the error message if it's not empty
if (!empty($success_message)) {
    echo "<div class='success'></div>";}

include('../template/footer.php') ;
// if (isset($_SESSION['success_message'])) {
//     $success_message = $_SESSION['success_message'];
//     // Display success message or handle it as needed
//     echo $success_message;
//     // Clear the success message from the session
//     unset($_SESSION['success_message']);
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
    
    <div class="container padding-top">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="flash-info">
                    <!-- Display any flash messages here -->
                </div>
                <div class="wrapper">
                    <form method="POST" action="../../src/features/pw-update.php" >
                        <div class="form-group">
                            <label for="username">Enter your username</label>
                            <input type="text" class="form-control"  id="exampleInputEmail1" placeholder="Username" name="username" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Enter new password</label>
                            <input type="password" class="form-control"  id="exampleInputPassword1" placeholder="Password" name="password">
                        </div>
                        <button type="submit" class="btn btn-default" name="login">Submit</button>
                    </form>
                </div>
                <div id="display-success">
                    <!-- Display any error messages here -->
                    <?php if (isset($error_message)) { echo $error_message; }
                        if (isset($_SESSION['success_message'])) {
                            $success_message = $_SESSION['success_message'];
                            // Display success message or handle it as needed
                            echo $success_message;
                            // Clear the success message from the session
                            unset($_SESSION['success_message']);
                            echo "<a href='signin-form.php'>Go for login</a>";
                        }
                    ?>
                    
                </div>
                <div class="success">
                <!--Display error -->
                
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="../assets/js/menu.js"></script>
</body>
</html>
