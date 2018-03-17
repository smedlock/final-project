<?php
/**
 * Created by PhpStorm.
 * User: RMartin
 * Date: 3/17/2018
 * Time: 2:09 PM
 */
require_once ('../model/db-functions.php');
include_once ('../classes/user.php');
include_once ('../classes/premium.php');

// Make sure a user is logged in
if ($_SESSION['active'])
{
    $dbh = connect();

    $member = $_SESSION['member'];
    $username = $member->getUsername();

    // First, make sure the user to be removed is in the list
    $remove = findUser($_POST['user']);

    // If the result is in the database
    if(!empty($remove))
    {
        // Check that the member and the removed user are the same
        if($username == $remove['username'])
        {
            removeUser($username);
            logout();
        }
    }
    echo $username;
}



