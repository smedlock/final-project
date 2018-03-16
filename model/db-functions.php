<?php
require $_SERVER['DOCUMENT_ROOT'] . "/../final-config.php";

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

function removeUser($username)
{
    // Delete user by username
    global $dbh;
    $sql = "DELETE FROM `snake-members` WHERE username = :username";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':username', $username,
                          PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch();

    return $result;
}

function getHighscores()
{
   // Get users by high score, for normal member scoreboard
    global $dbh;
    $sql = "SELECT username, highscore FROM `snake-members` 
            ORDER BY highscore LIMIT 10";

    $statement = $dbh->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}

function getPremiumScores()
{
    // Get users by total snake length, for premium member scoreboard
    global $dbh;
    $sql = "SELECT username, highscore, totalsnake FROM `snake-members` 
            WHERE premium = 1 ORDER BY totalsnake LIMIT 10";

    $statement = $dbh->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function getUsers()
{
    global $dbh;
    // Define query
    $sql= "SELECT * FROM `snake-members`";
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
    $sql= "SELECT * FROM `snake-members` WHERE username = :username";
    // Prepare statement
    $statement = $dbh->prepare($sql);
    // Bind parameters
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    // Execute statement
    $statement->execute();
    // Return results
    $result = $statement->fetch();

    return $result;
}

function addUser($premium, $username, $password, $bio)
{
    $result = findUser($username);
    if (empty($result)) {
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
}

function updateUserScore($username, $snakeLength)
{
    global $dbh;
    // Define query
    $sql = "UPDATE `snake-members` SET longsnake = :longsnake WHERE username = :username";
    // Prepare statement
    $statement = $dbh->prepare($sql);
    // Bind parameters
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':longsnake', $snakeLength, PDO::PARAM_INT);
    // Execute statement
    $success = $statement->execute();
    // Return results
    return $success;
}