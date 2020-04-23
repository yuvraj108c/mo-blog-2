<?php 
    require '../lib/nusoap.php';
    
    function load(){

        //return ("testing service");
        $posts = array();
        $xml = simplexml_load_file('data/posts.xml') or die ("Error:Cannot create object");
       /* 
        foreach ($xml ->children() as $x){
        
            $id = $x -> id;
            $title = $x -> title;
            $cat = $x -> category;
            $auth = $x -> author;
            
            ${$id} = array("title"=>(string)$title,
                            "category"=>(string)$cat,
                            "author"=>(string)$auth);

            array_push($posts,${$id});
            
        }  
        return join($posts);
        */
        return $xml;
    };

    $server = new nusoap_server();

    $server -> configureWSDL("posts","urn:posts");


    $server -> register("load",array(),array("return"=>"xsd:xml"));

    $server -> service(file_get_contents("php://input"));


?>
