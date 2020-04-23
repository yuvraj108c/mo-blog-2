<?php
require("classes/Constants.php");
require("classes/Post.php");
require("classes/Account.php");

session_start();

$method = $_SERVER['REQUEST_METHOD'];
$controller = $_GET["controller"];

switch ($controller) {

    case 'posts':
        $POST = new Post();
        if(isset($_GET["action"])){
            if($method == "GET"){
                if($_GET["action"] == "user"){

                    $myPosts = $POST->getPostsByUsername($_GET["data"]);
                    echo $myPosts;

                }elseif($_GET["action"] == "id"){
                    $post = $POST->getPostById($_GET["data"]);
                    echo $post;
                }
            }
            }elseif ($method == "POST"){
                $type=$_POST["type"];

                if($type == "update"){

                    $id=$_POST["save"];
                    $title = $_POST['title'];
                    $descri = $_POST['descri'];
                    $cat =  $_POST['cat'];
                    $imgURL =  $_POST['imgURL'];
                    
                    $POST->updatePost($id,$title,$descri,$cat,$imgURL);
                    header("Location: " . Constants::$root_client ."dashboard.php");
                    
                }elseif($type == "delete"){
                    
                    $id=$_POST["save"];
                    $POST->deletePost($id);
                    header("Location: " . Constants::$root_client ."dashboard.php");

                }elseif($type == "create"){
                    
                    $username=$_SESSION["userLoggedIn"];
                    $title = $_POST['title'];
                    $descri = $_POST['descri'];
                    $cat =  $_POST['cat'];
                    $imgURL =  $_POST['imgURL'];
        
                    $POST->createPost($title,$descri,$cat,$imgURL,$username);
                    
                    header("Location: " . Constants::$root_client ."dashboard.php");
                }
        }
        break;

    case "user":
        if($method == "POST"){
            if($_POST["type"] == "login"){

                $username = $_POST['username'];
                $password =  $_POST['password'];
            
                $account = new Account();
            
                if(!$account->validateUserLogin($username,$password)){
                    header("Location: " . Constants::$root_client . "login.php?err=1");
                }else{
                    $_SESSION['userLoggedIn'] = $username;
                    header("Location: " . Constants::$root_client ."dashboard.php");
                }
            }elseif($_POST["type"] == "logout"){

                unset($_SESSION['userLoggedIn']);
                header("Location: " . Constants::$root_client ."login.php");
                
            }elseif($_POST["type"] == "register"){
                
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
        }
    break;
}