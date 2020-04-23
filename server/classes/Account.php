<?php
class Account
{
    private $errorArray;
    public function __construct()
    {
        $this->errorArray = array();
    }
    public function validateUserLogin($username, $password)
    {
        $isValid = false;
        $usersXML = simplexml_load_file(Constants::$usersXmlPath);

        foreach($usersXML as $user){
            if($user->username == $username && strtolower($user->password) == strtolower(md5($password))){
                $isValid = true;
                break;
            }
        }

        if(!$isValid){
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }else{
            return true;
        }
    }

    public function registerUser($username,$email,$password){
        $users = simplexml_load_file(Constants::$usersXmlPath);

        foreach($users as $user){
            if(strtolower($user->username) == strtolower($username)){
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
            if(strtolower($user->email) == strtolower($email)){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }

        if(sizeof($this->errorArray) == 0){
            // Update xml file
            $doc = new DOMDocument();
            $doc->load(Constants::$usersXmlPath);
            
            $userElem = $doc->createElement("user");
            $idAttr = $doc->createAttribute("id");
            $idAttr->value = sizeof($doc->getElementsByTagName("user")) + 1;
            
            $userElem->appendChild($idAttr);
            $usernameElem = $doc->createElement("username", $username);
            $emailElem = $doc->createElement("email", $email);
            $passwordElem = $doc->createElement("password", strtolower(md5($password)));
            
            $userElem->appendChild($usernameElem);
            $userElem->appendChild($emailElem);
            $userElem->appendChild($passwordElem);

            $doc->getElementsByTagName("users")[0]->appendChild($userElem);

            if (!$doc->schemaValidate(Constants::$usersXsdPath)) {
                // Invalid xml
                array_push($this->errorArray, Constants::$invalidXmlFile);
                return false;
            }else{
                // Save file
                $doc->save(Constants::$usersXmlPath);
                return true;
            }
        }
    }

    public function getErrors()
    {
        return $this->errorArray;
    }
}