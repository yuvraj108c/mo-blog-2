<?php
require("../classes/Account.php");
require("../classes/Constants.php");


if(isset($_POST['loginBtn'])){
    $username = $_POST['username'];
    $password =  $_POST['password'];
    $captcha=$_POST['g-recaptcha-response'];

    if($captcha){
        
        $privatekey = "6LeKFY4UAAAAACm-gpvwPuvzbMoZ3ktLm8fVNnVy";
        $ip = $_SERVER['REMOTE_ADDR'];
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($privatekey) .  '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response,true);
        
        if($responseKeys["success"]) {

            $account = new Account();

            if(!$account->validateUserLogin($username,$password)){
                header("Location: " . Constants::$root_client . "login.php?err=1");
            }else{
                echo "True";        
            }
        } 
    }else{
        header("Location: " . Constants::$root_client . "login.php?err=2");
    }
}