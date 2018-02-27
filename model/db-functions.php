<?php
require '/home/epadilla/final-config.php';

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

function getUser()
{
    global $dbh;
    // Define query
    // Prepare statement
    // Bind parameters
    // Execute statement
    // Return results
}

function addUser($username, $password, $bio)
{
    global $dbh;
    // Define query
    $sql = "INSERT INTO snake-members(username, password, bio) VALUES (:username, :password, :bio)";

    // Prepare statement
    $statement = $dbh->prepare($sql);

    // Bind parameters
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':bio', $bio, PDO::PARAM_STR);

    // Execute statement
    $success = $statement->execute();

    // Return results
   return $success;
}