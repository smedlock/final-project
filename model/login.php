<?php
/**
 * Created by PhpStorm.
 * User: RMartin
 * Date: 3/10/2018
 * Time: 12:22 PM
 */

function login($username, $password)
{
    global $dbh;
    $sql = "SELECT * FROM `snake-members` WHERE username = :username AND password = :password";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);

    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (empty($result))
    {
        echo "User doesn't exist!";
    }
    else
    {
        print_r($result);
        //echo "NEW LINE";
        // create a new member object with the values pulled from the database

        $username = $result['username'];
        $password = $result['password'];
        $bio = $result['bio'];
        $premium = $result['premium'];
        $highscore = $result['highscore'];

     /*   echo $username;
        echo $password;
        echo $bio;
        echo $premium;
        echo $highscore; */

        // Check if the user is premium to instantiate correct class
        if($premium == 1)
        {
            $longsnake = $result['longsnake'];
            $totalsnake = $result['totalsnake'];

            $member = new Premium($username, $password, $bio);
            $member->setHighScore($highscore);
            $member->setLongSnake($longsnake);
            $member->setTotalSnake($totalsnake);
        }
        else
        {
            $member = new User($username, $password, $bio);
            $member->setHighScore($highscore);
        }

        return $member;
    }
}