<?php
require_once './CommonInterface.php';

class DatabaseInterface
{
    const debug = true;

    public function __construct()
    {
        $this->MySQLdb = new PDO("mysql:host=127.0.0.1:8111;dbname=bank", "root", "");
        $this->MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function GetMySQLdb()
    {
        return $this->MySQLdb;
    }

    /*
     * CheckErrors - if debug mode is set we will output the error in the response, if the debug is off we will be redirected to 404.php
     */
    public function CheckErrors($e,$pass = false)
    {
        if ($pass == true) return true;

        if (self::debug){
            die($e->getMessage());
        }
        else
        {
            // return error if there is something strange in the database
            return_error(":)");
        }
    }

    public function Register($username, $password)
    {
        try
        {
            # Check if the username or email is taken
            $cursor = $this->MySQLdb->prepare("SELECT username FROM credentials WHERE username=:username");
            $cursor->execute( array(":username"=>$username) );
        }
        catch(PDOException $e) {
            $this->CheckErrors($e);
        }
        /* New User */
        if(!($cursor->rowCount())){
            $accountManager = $this->CreateAccount($username);
            try
            {
                if(!$accountManager){
                    return array("success"=>false,"data"=>"Error. We can't create your account\nPlease contact support");
                }
                else{
                    $cursor = $this->MySQLdb->prepare("INSERT INTO credentials (username, passhash,accountID) value (:username,:passhash,:accountID)");
                    $cursor->execute(array(":passhash"=>md5($password), ":username"=>$username, ":accountID"=>$accountManager));
                    $cursor = $this->MySQLdb->prepare("INSERT INTO totalmoney (accountID) value (:accountID)");
                    $cursor->execute(array(":accountID"=>$accountManager));
                    return array("success"=>true,"data"=>"You have registered successfuly!\n Your account number is: ".$accountManager);
                    $this->CalcTotal($username,0);
                }
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
        }
        /* Already exists */
        else
        {
            return array("success"=>false,"data"=>"username already exists in the system<br>");
        }
    }

    public function Login($username, $password)
    {
        try
        {
            $cursor = $this->MySQLdb->prepare("SELECT * FROM credentials WHERE username='".$username."' AND passhash='".md5($password)."'");
            $cursor->execute();
        }
        catch(PDOException $e) {
            $this->CheckErrors($e);
        }

        if(!$cursor->rowCount())
        {
            return array("success"=>false,"data"=>"Wrong Username/Password!<br>");
        }
        else
        {
            $cursor->setFetchMode(PDO::FETCH_ASSOC);
            return array("success"=>true,"data"=>$cursor->fetch());
        }
    }
    private function CreateAccount($username){
        $currentid = mt_rand(1,999999999);
        $currentTime = time();
        $maybeBusy = FALSE;
        do {
            $currentaccount = str_repeat("0",9-strlen(strval($currentid))).strval($currentid);
            try{
                $cursor = $this->MySQLdb->prepare("SELECT accountID FROM credentials WHERE accountID=:currentaccount");
                $cursor->execute(array(":currentaccount"=>$currentaccount));
                if(time()-$currentTime>3){
                    $maybeBusy = TRUE;
                    break;
                }
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
                break;
            }
            $currentid = mt_rand(1,1000000000);
        }
        while($cursor->rowCount());
        if(!$maybeBusy){
            return $currentid;
        }
        return FALSE;
    }
    public function UpdateProfile($username, $currentPass, $nextPass){
        try{
            $cursor = $this->MySQLdb->prepare("SELECT username FROM credentials WHERE username=:username AND passhash=:passhash");
            $cursor->execute(array(":username"=>$username, ":passhash"=>md5($currentPass)));
            if ($currentPass == $nextPass){
                return array("success"=>false,"data"=>"Old and new passwords are equal!");
            }
            if(!$cursor->rowCount()){
                return array("success"=>false,"data"=>"Password is not correct!");
            }
            else{
                $cursor = $this->MySQLdb->prepare("UPDATE credentials SET passhash = :passhash WHERE username=:username;");
                $cursor->execute(array(":username"=>$username,":passhash"=>md5($nextPass)));
                unset($_SESSION["user"],$_SESSION["userid"]);
                return array("success"=>true,"data"=>"Your account have successfuly updated!");
            }
        }
        catch(PDOException $e){
            $this->CheckErrors($e);
        }
    }
    private  function CalcTotal($username, $difference){
        if ($difference != 0){
            try{
                $cursor = $this->MySQLdb->prepare("SELECT total FROM totalmoney WHERE username=:username");
                $cursor->execute(array(":username"=>$username));
                $total = $cursor->Fetch();
                $total += $difference;
                $cursor = $this->MySQLdb->prepare("UPDATE totalmoney SET total=:total WHERE accountID=:accountID");
                $cursor->execute(array(":username"=>$username,":total"=>$total));
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
        }
    }
}