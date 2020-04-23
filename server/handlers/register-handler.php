<?php
    require("../classes/Account.php");
    require("../classes/Constants.php");

    session_start();
    
    if(isset($_POST['registerBtn'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pwd1 =  $_POST['pwd1'];
        $pwd2 =  $_POST['pwd2'];
        $captcha=$_POST['g-recaptcha-response'];

        if($captcha){
        
            $privatekey = "6LeKFY4UAAAAACm-gpvwPuvzbMoZ3ktLm8fVNnVy";
            $ip = $_SERVER['REMOTE_ADDR'];
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($privatekey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);
            
            if($responseKeys["success"]) {

                if($pwd1 !== $pwd2){
                    header("Location: " . Constants::$root_client . "register.php?err=1&email=".$email."&username=".$username);
                }else{
                    
                    $account = new Account();
                    
                    if(!$account->registerUser($username,$email,$pwd1)){
                        $error = $account->getErrors()[0];
                        
                        if($error == Constants::$usernameTaken){
                            header("Location: " . Constants::$root_client . "register.php?err=2&email=".$email."&username=".$username );
                        }elseif($error == Constants::$emailTaken){
                            header("Location: " . Constants::$root_client . "register.php?err=3&email=".$email."&username=".$username);
                        }
                    }else{
                        $_SESSION['userLoggedIn'] = $username;
                        header("Location: " . Constants::$root_client ."dashboard.php");
                    }
                }
            } 
        }else{
            header("Location: " . Constants::$root_client . "register.php?err=4&email=".$email."&username=".$username);
        }
    }
?>