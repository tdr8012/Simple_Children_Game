<?php   
    function check_login($con){
        if(isset($_SESSION['user_id'])){
            $id = $_SESSION['user_id'];
            $query = "select * from users where user_id = '$id' limit 1";

            $result = mysqli_query($con,$query);
            if($result && mysqli_num_rows($result) > 0){
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }
        header("Location: login.php");
        die;

    }

    function random_num($length) {
        $text = "";
        if($length < 5) {
            $length = 5;
        }
    
        $len = rand(4, $length);
    
        for ($i=0; $i < $len; $i++) { 
            $text .= rand(0,9);
        }
    
        return $text;
    }

    function passwordsMatch($password, $confirmPassword) {
        return $password === $confirmPassword;
    }

    function isPasswordStrong($password) {
        if (strlen($password) < 6) {
            return "Password must be at least 6 characters long.";
        }
        if (!preg_match('@[A-Z]@', $password)) {
            return "Password must include at least one uppercase letter.";
        }
        if (!preg_match('@[^\w]@', $password)) {
            return "Password must contain at least one special character.";
        }
        return "";
    }