<?php
require $_SERVER['DOCUMENT_ROOT'] . "/../final-config.php";

/**
 * Attempts a connection to the database.
 *
 * @return PDO|void
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

/**
 * Function that deletes a user from the database based on
 * their username.
 *
 * @param String $username of the user to be deleted.
 * @return Object the user deleted
 */
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

/**
 * Retrieves the username and highscore of seven users
 * for use in the scoreboard.
 *
 * @return Array a set of users ordered by highscore.
 */
function getHighscores()
{
   // Get users by high score, for normal member scoreboard
    global $dbh;
    $sql = "SELECT username, highscore FROM `snake-members` 
            ORDER BY highscore DESC LIMIT 7";

    $statement = $dbh->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}

/**
 * Retrieves the username, cellsTraveled and totalsnake of
 * seven users for use in the Premium scoreboard.
 *
 * @return Array a set of users ordered by total snake length.
 */
function getPremiumScores()
{
    // Get users by total snake length, for premium member scoreboard
    global $dbh;
    $sql = "SELECT username, cellsTraveled, totalsnake FROM `snake-members` 
            WHERE premium = 1 ORDER BY totalsnake DESC LIMIT 7";

    $statement = $dbh->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

/**
 * Retrieves everything from every user in the database.
 *
 * @return Array all data from all users in the database.
 */
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

/**
 * Searches the database for a user with the
 * given username.
 *
 * @param String $username to search for
 * @return Object the user, if found
 */
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

/**
 * Adds a user to the database, inputting their username, password, bio, and
 * an integer value that is 1 if they are a premium member, and 0 if they are
 * not.
 *
 * @param int $premium 1 or 0, depending on whether or not the user is premium
 * @param String $username for the user's username.
 * @param String $password for the user's password
 * @param String $bio for the user's biography.
 * @return bool true if the statement was successful, false otherwise.
 */
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

/**
 * Updates the user's highscore. Is not dependant on whether or not
 * the user is a premium member.
 *
 * @param $username the user whose score will be updated
 * @param $snakeLength the value the new highscore will be set to.
 * @return bool true if the statement was successful, false otherwise
 */
function updateUserScore($username, $snakeLength)
{
    global $dbh;
    // Define query
    $sql = "UPDATE `snake-members` SET highscore = :highscore WHERE username = :username";
    // Prepare statement
    $statement = $dbh->prepare($sql);
    // Bind parameters
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':highscore', $snakeLength, PDO::PARAM_INT);
    // Execute statement
    $success = $statement->execute();
    // Return results
    return $success;
}