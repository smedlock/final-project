<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 3/12/2018
 * Time: 7:40 PM
 */

require_once ('../model/db-functions.php');
include_once('../classes/user.php');
session_start();

//print_r($_SESSION);

$snakeLength = $_POST['snakelength'];

// If there is a logged in user, check high score to update
if ($_SESSION['member']) {
    $dbh = connect();

    $member = unserialize($_SESSION['member']);
    $username = $member->getUsername();
    $oldScore = findUser($username)['longsnake'];

    if ($snakeLength > $oldScore) {
        updateUserScore($username, $snakeLength);

        echo 'UPDATED';
    } else {
        echo 'NOT UPDATED';
    }

}

echo $snakeLength;