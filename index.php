<?php

// Turn on error reporting & include required files
error_reporting(E_ALL);
require_once ('vendor/autoload.php');
require_once ('model/db-functions.php');
require_once ('model/login.php');
include ('model/validate.php');

// Instantiate base, set debug and start session
$f3 = Base::instance();
session_start();
$f3->set('DEBUG', 3);

// Open database connection
$dbh = connect();

$f3->route('GET /', function(){
    echo $_SESSION['member'];
    $template = new Template();
    echo $template->render('views/home.html');
});

$f3->route('GET|POST /register', function($f3){
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm = $_POST['confirmPass'];
        $bio = $_POST['bio'];
        $premium = isset($_POST['premium']);

       // validate username & password
        $errors = validate($username, $password, $confirm);
        $success = (sizeof($errors) == 0);

        // Set values to hive for templating
        $f3->set('username', $username);
        $f3->set('bio', $bio);
        echo $success;
        print_r($errors);

        if($success == 1)
        {
            // create member object
            if($premium)
            {
                $member = new Premium($username, $password, $bio);
            }
            else
            {
                $member = new User($username, $password, $bio);
            }

            $_SESSION['member'] = $member;


           $f3->reroute("./results");
        }
    }
   $template = new Template();
   echo $template->render('views/register.html');
});

$f3->route('GET|POST /results', function() {

   $member = $_SESSION['member'];
   $username = $member->getUsername();
   $password = $member->getPassword();
   $bio = $member->getBiography();

    if($member instanceof Premium)
    {
        $success = addUser(1, $username, $password, $bio);
    }
    else
    {
        $success = addUser(0, $username, $password, $bio);
    }


   print_r($member);
});

$f3->route('GET|POST /login', function(){
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $success = login($username, $password);

        if(empty($success))
        {

        }
        else
        {
            $_SESSION['member'] = $success;
        }

    }
    $template = new Template();
    echo $template->render('views/login.html');
});

$f3->run();