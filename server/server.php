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
            }
        }
    break;
}