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

 echo 'GAME OVER' . "\n\n";
 echo 'Here are your stats for this game:' . "\n";
 echo 'score: ' . $snakeLength . "\n";
 echo 'cells traveled: ' . $cellsTraveled . "\n";
 echo 'food eaten: ' . $foodEaten;

 // If there is a logged in user, check high score to update
 if($_SESSION['active'] == 1)
 {
     $dbh = connect();

     $member = $_SESSION['member'];

     $user = findUser($member->getUsername());
     $username = $user['username'];
     $oldScore = $user['highscore'];

     if ($snakeLength > $oldScore) {
         updateUserScore($username, $snakeLength);

         echo "\nCongratulations, You got a new high score!";
     }

     if($member instanceof Premium_User)
     {

         $oldCellsTraveled = $user['cellsTraveled'];
         $oldTotalSnake = $user['totalsnake'];

         updateTravelAndTotal($username, $oldCellsTraveled + $cellsTraveled,
                             $oldTotalSnake + $foodEaten);


     }
 }
