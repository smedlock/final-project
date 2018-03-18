<?php
/**
 * Created by PhpStorm.
 * User: RMartin
 * Date: 3/17/2018
 * Time: 2:09 PM
 */
require_once ('../model/db-functions.php');
require_once('../model/login.php');
include_once ('../classes/user.php');
include_once ('../classes/premium.php');
session_start();

// Make sure a user is logged in
if ($_SESSION['active'] == 1)
{
    $dbh = connect();

    $member = $_SESSION['member'];
    $username = $member->getUsername();

    // First, make sure the user to be removed is in the list
    $remove = $_POST['user'];

    // Check that the member logged in and the removed user are the same
    if($username == $remove)
    {
        logout();
        removeUser($username);
        echo "$username deleted!";
    }
    else
    {
        echo "You may only delete your own user profile.";
    }
}

