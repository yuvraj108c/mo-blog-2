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
        } 
    break;
}