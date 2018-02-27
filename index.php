<?php

error_reporting(E_ALL);
require_once('vendor/autoload.php');
require_once 'model/db-functions.php';

session_start();

$f3 = Base::instance();
$f3->set('DEBUG', 3);

$dbh = connect();

$f3->route('GET /', function(){
    $template = new Template();
    echo $template->render('views/home.html');
});

$f3->route('GET|POST /register', function($f3){
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
       // $confirm = $_POST['confirmPass'];
        $bio = $_POST['bio'];
       // $premium = isset($_POST['premium']);

        // Set templating variables
        //$f3->set('username', $username);
        //$f3->set('bio', $bio);

        //$success = addUser($username, $password, $bio);

        //echo $success;

    }
   $template = new Template();
   echo $template->render('views/register.html');
});

$f3->run();