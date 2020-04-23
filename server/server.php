<?php
require("classes/Constants.php");
require("classes/Post.php");

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
}