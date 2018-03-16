<?php
/**
 * Created by PhpStorm.
 * User: Scott
 * Date: 3/12/2018
 * Time: 7:40 PM
 */

require_once ('../model/db-functions.php');
include_once('../classes/user.php');
include_once('../classes/premium.php');
session_start();

//print_r($_SESSION);

$snakeLength = $_POST['snakelength'];
$cellsTraveled = $_POST['cellsTraveled'];
$foodEaten = $_POST['foodEaten'];

// If there is a logged in user, check high score to update
if ($_SESSION['member']) {
    $dbh = connect();

    $member = $_SESSION['member'];


    if ($member instanceof Premium) {

        $user = findUser($member->getUsername());

        $username = $user['username'];
        $oldScore = $user['highscore'];
        $oldCellsTraveled = $user['cellsTraveled'];
        $oldTotalSnake = $user['totalsnake'];

        updateTravelAndTotal($username, $oldCellsTraveled + $cellsTraveled, $oldTotalSnake + $foodEaten);

        if ($snakeLength > $oldScore) {
            updateUserScore($username, $snakeLength);
        }

    }
}
echo 'snake length: ' . $snakeLength . "\n";
echo 'cells traveled: ' . $cellsTraveled . "\n";
echo 'food eaten: ' . $foodEaten;