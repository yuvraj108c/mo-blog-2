<?php
require("../classes/Account.php");
require("../classes/Constants.php");

session_start();

if(isset($_POST['loginBtn'])){
    $username = $_POST['username'];
    $password =  $_POST['password'];

    $account = new Account();

    if(!$account->validateUserLogin($username,$password)){
        header("Location: " . Constants::$root_client . "login.php?err=1");
    }else{
        $_SESSION['userLoggedIn'] = $username;
        header("Location: " . Constants::$root_client ."dashboard.php");
    }
} 