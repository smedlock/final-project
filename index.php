<?php

error_reporting(E_ALL);
require_once('vendor/autoload.php');
require_once 'model/db-functions.php';



$f3 = Base::instance();
session_start();
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

        // create member object
        $member = new User($username, $password, $bio);
        $_SESSION['member'] = $member;

        echo $f3->get('member');

        $f3->reroute("./results");
    }
   $template = new Template();
   echo $template->render('views/register.html');
});

$f3->route('GET|POST /results', function($f3) {
 /*  $username = $_SESSION['username'];
   $password = $_SESSION['password'];
   $bio = $_SESSION['bio'];
   $member = $f3->get('member'); */

   echo $_SESSION['member'];

   //$success = addUser($username, $password, $bio);

   //print_r($success);


});

$f3->run();