<?php

    require("includes/Header.php");
    require "config.php";

    session_start();

    $header = new Header("dashboard","dashboard.css");
    $header->output();
?>

<body>
    <?php include "includes/navbar.php"; ?>

    <section class="posts">
        <div class="ui container">

            <?php 

             $myPosts = file_get_contents(SERVER_URL."/server/posts/user/".$_SESSION["userLoggedIn"]);
            //   header("Location: ".SERVER_URL."/server/posts/user/".$_SESSION["userLoggedIn"]);
            
            if(!$myPosts){
                echo "Create a post to get started!";
            }else{
                // Load XML file
                $xml = new DOMDocument;
                $xml->loadXML($myPosts);

                // Load XSL file
                $xsl = new DOMDocument;
                $xsl->load('./xslt/dashboard.xslt');
                
                // Configure the transformer
                $proc = new XSLTProcessor();
                
                // Attach the xsl rules
                $proc->importStyleSheet($xsl);
                echo $proc->transformToXML($xml);
            }
        ?>

        </div>
    </section>
</body>

</html>