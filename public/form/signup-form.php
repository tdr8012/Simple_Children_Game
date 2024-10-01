<?php
$error_message = isset($_GET['error_message']) ? $_GET['error_message'] : '';

// Output the error message if it's not empty
if (!empty($error_message)) {
    echo "<div class='error-message'></div>";}
include('../template/footer.php') 

?>
<!-- Your HTML form code goes here -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/main.css">
    <script type = "text/javascript" src = "/WebServerProject_Winter2024/public/assets/js/signup-onkeyup/fname-ajax.js"></script>
    <script type = "text/javascript" src = "/WebServerProject_Winter2024/public/assets/js/signup-onkeyup/lname-ajax.js"></script>
    <script type = "text/javascript" src = "/WebServerProject_Winter2024/public/assets/js/signup-onkeyup/uname-ajax.js"></script>
    <script type = "text/javascript" src = "/WebServerProject_Winter2024/public/assets/js/signup-onkeyup/pcode1-ajax.js"></script>
    <script type = "text/javascript" src = "/WebServerProject_Winter2024/public/assets/js/signup-onkeyup/pcode2-ajax.js"></script>
</head>
<body>
    <div class="menu-btn">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </div>
    <div class="menu">
        <div id="menu-wrap">
            <nav>
                <ul>
                    <li><a href="game-form.php">HOME</a></li>  
                    <li><a href="signin-form.php">LOGIN</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="container padding-top">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="flash-info">
                    <!-- Display any flash messages here -->
                </div>
                <div class="wrapper">
                <form method="post" action="../../src/features/signupT.php">

                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName"
                            required onkeyup="validateFirstName()">
                            <p><span class="" id=fnameHint></span></p>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lastName"
                            required onkeyup="validateLastName()">
                            <p><span id="lnameHint"></span></p>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                            required onkeyup="validateUserName()">
                            <p><span id=usernameHint></span></p>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password"
                            required onkeyup="validatePcode1()">
                            <p><span id="pcode1Hint"></span></p>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" name="confirmPassword"
                            required onkeyup="validatePcode2()">
                            <p><span id="pcode2Hint"></span></p>
                        </div>
                        <button type="submit" class="btn btn-default" name="register">Register</button>
                    </form>
                </div>
                <div class="display-error">
                    <!-- Display any error messages here -->
                  
                    <?php echo $error_message?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="../assets/js/menu.js"></script>
</body>
<footer>
    <?php /// footernavigator();?>
</footer>
</html>
