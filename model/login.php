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
    $sql = "SELECT * FROM `snake-members` WHERE username = :username";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);

    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (empty($result))
    {
        echo "User doesn't exist!";
    }
    else
    {
        // create a new member object with the values pulled from the database
        $DBusername = $result['username'];
        $DBpassword = $result['password'];
        $bio = $result['bio'];
        $premium = $result['Premium_User'];
        $highscore = $result['highscore'];

        // Verify password hash is correct
        if(password_verify($password, $DBpassword))
        {
            // Check if the user is premium to instantiate correct class
            if($premium == 1)
            {
                $totalsnake = $result['totalsnake'];

                $member = new Premium_User($DBusername, $DBpassword, $bio);
                $member->setHighScore($highscore);
                $member->setTotalSnake($totalsnake);
            }
            else
            {
                $member = new User($DBusername, $DBpassword, $bio);
                $member->setHighScore($highscore);
            }

            $_SESSION['active'] = true;
            return $member;
        }
        else
        {
            echo "Password incorrect!";
        }
    }
}

function logout()
{
    session_unset();
    session_destroy();
    $_SESSION['active'] = false;
    $_SESSION['member'] = null;

}