<?php

    require("config.php");
    require("includes/Header.php");
    session_start();

    $header = new Header("homepage","homepage.css");
    $header->output();
?>

<body>

    <?php include "includes/navbar.php"; ?>

    <div class="ui grid">
        <div class="eleven wide column">

            <section class="posts">
                <h2>Recent posts</h2>
                <div class="ui container">
                    <div id="content">
                        <?php 
                        require_once "./lib/nusoap.php";
                        $client = new nusoap_client("http://localhost/mo-blog-2/server/posts_server.php?wsdl");

                        $response = $client->call('getPosts',array(""));

                        if(empty($response)){
                            echo "NO posts available.";
                        }else{
                            
                            // Load XML file
                            $xml = new DOMDocument;
                            $xml->loadXML($response);
                            
                            // Load XSL file
                            $xsl = new DOMDocument;
                            $xsl->load('./xslt/homepage.xsl');
                            
                            // Configure the transformer
                            $proc = new XSLTProcessor();
                            
                            // Attach the xsl rules
                            $proc->importStyleSheet($xsl);
                            
                            echo $proc->transformToXML($xml);
                        }
                        
                    ?>
                    </div>
                </div>
            </section>
        </div>

</body>

</html>