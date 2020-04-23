<?php

require '../lib/nusoap.php';

class Post{
    public function getPostsByUsername($username){
        $userPosts = array();
        $postsXML = simplexml_load_file(Constants::$postsXmlPath);
        $hasPosts = false;
        $xml = new SimpleXMLElement("<posts/>");

        foreach($postsXML as $post){
            if(strtolower($post->author) == strtolower($username)){
                $hasPosts = true;

                $p = $xml->addChild("post");
                $p->addChild("id", $post->id);
                $p->addChild("title", $post->title);
                $p->addChild("description", $post->description);
                $p->addChild("category", $post->category);
                $p->addChild("imageUrl", $post->imageUrl);
                $p->addChild("author", $post->author);
                $p->addChild("createdOn", $post->createdOn);
            }
        }

        if($hasPosts){
            return $xml->asXML();
        }else{
            return false;
        }
    }

    public function getPostById($id){
        $postsXML = simplexml_load_file(Constants::$postsXmlPath);

        foreach($postsXML as $post){
            if($post->id == $id){
                return $post->asXML();
            }
        }
    }

    public function getPostsByCategoryAndSaveToFile($c){
        $postsXML = simplexml_load_file(Constants::$root .Constants::$postsXmlPath);
        $xml = new SimpleXMLElement("<posts/>");

        foreach($postsXML as $post){
            if(strtolower($post->category) == strtolower($c)){
                $hasPosts = true;

                $p = $xml->addChild("post");
                $p->addChild("id", $post->id);
                $p->addChild("title", $post->title);
                $p->addChild("description", $post->description);
                $p->addChild("category", $post->category);
                $p->addChild("imageUrl", $post->imageUrl);
                $p->addChild("author", $post->author);
                $p->addChild("createdOn", $post->createdOn);
            }
        }
        // Save to temp file
        $xml->asXML("temp.xml");
    }

    public function getPostCategories(){
        $categories = array();
        $postsXML = simplexml_load_file(Constants::$postsXmlPath);
        foreach($postsXML as $post){
            $c = $post->category->__toString();
            if(!in_array($c,$categories)){
                array_push($categories,$c);
            }
        }
        return $categories;
    }

    public function createPost($title,$descri,$cat,$imgUrl,$username){

        $wsdl = "https://www.dataaccess.com/webservicesserver/TextCasing.wso?WSDL"; 
            
        $client = new nusoap_client($wsdl, 'wsdl'); 

        $error = $client->getError();
        
        if ($error){
            echo "<h2>Constructor error</h2><pre>" . $error ."</pre>";
        }

        //soap service for title of post
        $param = array('sText'=>$title, 'sToken'=>" ");
    
        $result = $client->call('TitleCaseWordsWithToken',$param);
        
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
                $title = $result["TitleCaseWordsWithTokenResult"];
            }
        }

        // soap service for category of post
        
        $param1 = array('sText'=>$cat, 'sToken'=>" ");
    
        $result1 = $client->call('TitleCaseWordsWithToken',$param1);
        
        if ($client->fault){
            echo"<h2>Fault</h2><pre>";
            print_r($result1);
            echo"</pre>";
        }
        
        else{
            $error = $client->getError(); 
                if ($error){
                    echo "<h2>Error</h2><pre>" . $error . "</pre>";
            }
            else{
                $cat = $result1["TitleCaseWordsWithTokenResult"];
            }
        }


        // Update xml file
        $doc = new DOMDocument();
        $doc->load(Constants::$postsXmlPath);
        
        $postElem = $doc->createElement("post");
        $countPosts = sizeof($doc->getElementsByTagName("post"));
        $lastPost = $doc->getElementsByTagName("post")[$countPosts-1];
        
        $idElem = $doc->createElement("id", $lastPost->getElementsByTagName("id")[0]->nodeValue + 1);
        $titleElem = $doc->createElement("title", $title);
        $descriElem = $doc->createElement("description", $descri);
        $catElem = $doc->createElement("category", $cat);
        $urlElem = $doc->createElement("imageUrl", $imgUrl);
        $createByElem = $doc->createElement("author",$username);
        $createOnElem = $doc->createElement("createdOn",date("Y-m-d"));
        
        $postElem->appendChild($idElem);
        $postElem->appendChild($titleElem);
        $postElem->appendChild($descriElem);
        $postElem->appendChild($catElem);
        $postElem->appendChild($urlElem);
        $postElem->appendChild($createByElem);
        $postElem->appendChild($createOnElem);

        $doc->getElementsByTagName("posts")[0]->appendChild($postElem);

        if (!$doc->schemaValidate(Constants::$postsXsdPath)) {
            // Invalid xml
            array_push($this->errorArray, Constants::$invalidXmlFile);
            return false;
        }else{
            // Save file
            $doc->save(Constants::$postsXmlPath);
            return true; 
        }
    }

    public function updatePost($id,$title,$descri,$cat,$imgURL){
        $postsXML = simplexml_load_file(Constants::$postsXmlPath);

        foreach($postsXML as $p){
            if($p->id == $id){
                $p->title=$title;
                $p->description=$descri;
                $p->category=$cat;
                $p->imageUrl=$imgURL;
            }
        }
        $postsXML->asXML(Constants::$postsXmlPath);
    }
    
    public function deletePost($id){
        $postsXML = simplexml_load_file(Constants::$postsXmlPath);
        $count=0;

        foreach($postsXML as $p){
            if($p->id == $id){
                unset($postsXML->post[$count]);
            }
            $count++;
        }

        $postsXML->asXML(Constants::$postsXmlPath);
    }
}