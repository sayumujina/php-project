<?php
require_once 'dbConnect.php';

class signup{
    
private $id;
private $email;
private $username;
private $password;
protected $dbcnx;

// Construct the user credentials field
public function __construct($id = 0, $email = "", $username = "", $password = ""){
    $this->id = $id;
    $this->email = $email; 
    $this->username = $username; 
    $this->password = $password;

    $this->dbcnx = new PDO(DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS.[PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
}

// Setters
public function setId($id){
    $this->id = $id;
}
// Check if the email is valid
public function setEmail($email){
    if (strpos($email, '@') > -1){
        $this->email = $email;
    }
    else{
        echo "Invalid email address";
    }
}

public function setUsername($username){
    $this->username = $username;
}

// Getters
public function getId(){
    return $this->id;
}

public function getEmail(){
    return $this->email;
}


public function getUsername(){
    return $this->username;
}
public function setPassword($password){
    $this->password = $password;
}
public function getPassword(){
    return $this->password;
}
public function insertCredentials(){
    try{
        $stm = $this->dbcnx->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $stm->execute([$this->email, $this->username, md5($this->password)]);
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }
}
}
