<?php
/**
 * Created by PhpStorm.
 * User: RMartin
 * Date: 3/10/2018
 * Time: 12:22 PM
 */

/**
 * A function that checks to see if the user exists in the database.
 * If they do, it then checks that the password entered hashes to the
 * same password in the database. If both cases are true, it creates
 * a member object and logs the user in.
 *
 * @param $username The member's username
 * @param $password the member's password
 * @return Premium_User|User
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
        $premium = $result['premium'];
        $highscore = $result['highscore'];

        // Verify password hash is correct
        if(password_verify($password, $DBpassword))
        {
            // Check if the user is premium to instantiate correct class
            if($premium == 1)
            {
                $cellsTraveled = $result['cellsTraveled'];
                $totalsnake = $result['totalsnake'];

                $member = new Premium_User($DBusername, $DBpassword, $bio);
                $member->setHighScore($highscore);
                $member->setCellsTraveled($cellsTraveled);
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

/**
 * Destroys the current session and resets all values that
 * might show a logged-in view.
 */
function logout()
{
    session_unset();
    session_destroy();
    $_SESSION['active'] = false;
    $_SESSION['member'] = null;

}