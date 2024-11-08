<?php
# Runs when users click the sign up button
if (isset($_POST['signup'])){
    require_once 'signup.php';
    $signup = new signup();
    $signup->setEmail($_POST['email']);
    $signup->setUsername($_POST['username']);
    $signup->setPassword($_POST['password']);
    
    $signup->insertCredentials()
}
