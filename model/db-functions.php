<?php
require '/home/epadilla/final-config.php';

/*
 * To-do:
 * - Get users by high score, for normal member scoreboard
 * - Get users by total snake length, for premium member scoreboard
 * - Get user by username, if it exists, for username validation
 */

function connect()
{
    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME,
            DB_PASSWORD);
        //echo "Connected to database!!!";
        return $dbh;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }
}

function getUsers()
{
    global $dbh;
    // Define query
    $sql= "SELECT * FROM snake-members";
    // Prepare statement
    $statement = $dbh->prepare($sql);
    // Bind parameters

    // Execute statement
    $statement->execute();
    // Return results
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function findUser($username)
{
    global $dbh;
    // Define query
    $sql= "SELECT * FROM snake-members WHERE username = $username";
    // Prepare statement
    $statement = $dbh->prepare($sql);
    // Bind parameters

    // Execute statement
    $statement->execute();
    // Return results
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function addUser($premium, $username, $password, $bio)
{
    global $dbh;
    // Define query
    $sql = "INSERT INTO `snake-members` (premium, username, password, bio) VALUES (:premium, :username, :password, :bio)";

    // Prepare statement
    $statement = $dbh->prepare($sql);

    // Bind parameters
    $statement->bindParam(':premium', $premium, PDO::PARAM_BOOL);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':bio', $bio, PDO::PARAM_STR);

    // Execute statement
    $success = $statement->execute();

    // Return results
   return $success;
}