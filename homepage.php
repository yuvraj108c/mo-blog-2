<?php

    require("includes/Header.php");
    session_start();

    $header = new Header("homepage","homepage.css");
    $header->output();
?>

<body>

    <?php include "includes/navbar.php"; ?>
    
    <h1>Home</h1>
    <?php 
        require_once "./lib/nusoap.php";
        $client = new nusoap_client("http://localhost/mo-blog-2/server/postsServer.php?wsdl",true);

        $error = $client->getError();
    
        if ($error){
            echo "<h2>Constructor error</h2><pre>" . $error ."</pre>";
        }

        $result = $client->call('load',array()); 

        if ($client->fault){
            echo"<h2>Fault</h2><pre>";
            print_r($result);
            echo"</pre>";
        }
        
        else{
            $error = $client->getError(); 
            if ($error){
                echo "<h2>Error</h2><pre>" . $error . "</pre>";
            }
            else{
                echo "<h2>Books</h2><pre>"; 
               ///////////////////////////////////////
               /*
                                $xml = new DOMDocument;
                                $xml = $result;
                                //print_r ($xml);
                                // Load XSL file
                                $xsl = new DOMDocument;
                                $xsl->load('xslt/homepage.xsl');
                                
                                // Configure the transformer
                                $proc = new XSLTProcessor();
                                
                                // Attach the xsl rules
                                $proc->importStyleSheet($xsl);
                                
                                echo $proc->transformToXML($result);
                                */
               ///////////////////////////////////////

               var_dump ($result);
                echo"</pre>";
            }
        }
    
    ?>
    



</body>

</html>