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

// instantiate the active and admin values to false for navbar

// Initial set to the hive


$f3->route('GET /', function($f3){
    $premiumScores = getPremiumScores();
    $highscores = getHighscores();

    $f3->set('premiumScores', $premiumScores);
    $f3->set('highscores', $highscores);

    $active = $_SESSION['active'];
    $f3->set('loggedin', $active);

    //print_r($premiumScores);
    //print_r($highscores);

    $template = new Template();
    echo $template->render('views/home.html');
});

$f3->route('GET /admin', function(){

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


           $f3->reroute("./profile");
        }
    }
   $template = new Template();
   echo $template->render('views/register.html');
});

$f3->route('GET|POST /profile', function($f3) {

   $member = $_SESSION['member'];
   $username = $member->getUsername();
   $password = $member->getPassword();
   $bio = $member->getBiography();
   $highscore = $member->getHighscore();

    if($member instanceof Premium)
    {
        $success = addUser(1, $username, $password, $bio);
        $f3->set('totalSnake', $member->getTotalSnake());
    }
    else
    {
        $success = addUser(0, $username, $password, $bio);
    }

    // Set for templating
    $f3->set('member', $member);
    $f3->set('username', $username);
    $f3->set('bio', $bio);
    $f3->set('highscore', $highscore);

    print_r($member);
    $template = new Template();
    echo $template->render('views/profile.html');
});

$f3->route('GET|POST /login', function($f3){
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $success = login($username, $password);

        if(!empty($success))
        {
            $_SESSION['member'] = $success;
            $_SESSION['active'] = true;
            $f3->set('active', $_SESSION['active']);

            $f3->reroute('/');
        }
        else
        {
            $_SESSION['active'] = false;
        }
    }
    $template = new Template();
    echo $template->render('views/login.html');
});

$f3->route("GET /logout", function($f3){
   logout();
   $_SESSION['active'] = false;
   $_SESSION['admin'] = false;

   $f3->set('active', $_SESSION['active']);
   $f3->reroute('/');
});

$f3->run();