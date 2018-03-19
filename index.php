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

$f3->route('GET /', function($f3){
    $premiumScores = getPremiumScores();
    $highscores = getHighscores();

    $f3->set('premiumScores', $premiumScores);
    $f3->set('highscores', $highscores);

    $active = $_SESSION['active'];
    $f3->set('loggedin', $active);

    $template = new Template();
    echo $template->render('views/home.html');
});

$f3->route('GET /admin', function($f3){
    $active = $_SESSION['active'];
    $f3->set('loggedin', $active);

    $users = getUsers();
    $f3->set('users', $users);
    $template = new Template();
    echo $template->render('views/admin-table.html');
});

$f3->route('GET|POST /register', function($f3){
    $active = $_SESSION['active'];
    $f3->set('loggedin', $active);

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
        $f3->set('premium', $premium);

        if($success == 1)
        {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // create member object
            if($premium)
            {
                $member = new Premium_User($username, $hashed_password, $bio);
            }
            else
            {
                $member = new User($username, $hashed_password, $bio);
            }

            $_SESSION['member'] = $member;


           $f3->reroute("./profile");
        }
    }

    $active = $_SESSION['active'];
    $f3->set('loggedin', $active);

   $template = new Template();
   echo $template->render('views/register.html');
});

$f3->route('GET|POST /profile', function($f3)
{
    $active = $_SESSION['active'];
    $f3->set('loggedin', $active);

    $member = $_SESSION['member'];
    $username = $member->getUsername();
    $password = $member->getPassword();
    $bio = $member->getBiography();
    $highscore = $member->getHighscore();

    if($member instanceof Premium_User)
    {
        addUser(1, $username, $password, $bio);
        $f3->set('totalSnake', $member->getTotalSnake());
    }
    else
    {
        addUser(0, $username, $password, $bio);
    }

    // Set for templating
    $f3->set('member', $member);
    $f3->set('username', $username);
    $f3->set('bio', $bio);
    $f3->set('highscore', $highscore);

    $active = $_SESSION['active'];
    $f3->set('loggedin', $active);

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