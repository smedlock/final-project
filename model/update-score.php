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
<<<<<<< HEAD
$cellsTraveled = $_POST['cellsTraveled'];
$foodEaten = $_POST['foodEaten'];
=======
>>>>>>> 9e160b43e47469d29a679cebcab8fd26b0e518cb

// If there is a logged in user, check high score to update
if ($_SESSION['member']) {
    $dbh = connect();

    $member = $_SESSION['member'];



<<<<<<< HEAD
    if ($member instanceof Premium) {

        $user = findUser($member->getUsername());

        $username = $user['username'];
        $oldScore = $user['highscore'];
        $oldCellsTraveled = $user['cellsTraveled'];
        $oldTotalSnake = $user['totalsnake'];

        echo 'old score: ' . $oldScore . "\n";
        echo 'old cells traveled: ' . $oldCellsTraveled . "\n";
        echo 'old total snake: ' . $oldTotalSnake . "\n";

        updateTravelAndTotal($username, $oldCellsTraveled + $cellsTraveled, $oldTotalSnake + $foodEaten);

        if ($snakeLength > $oldScore) {
            updateUserScore($username, $snakeLength);
=======
    if ($snakeLength > $oldScore) {
        updateUserScore($username, $snakeLength);
>>>>>>> 9e160b43e47469d29a679cebcab8fd26b0e518cb

        echo 'UPDATED';
    } else {
        echo 'NOT UPDATED';
    }

}

echo 'snake length: ' . $snakeLength . "\n";
echo 'cells traveled: ' . $cellsTraveled . "\n";
echo 'food eaten: ' . $foodEaten;