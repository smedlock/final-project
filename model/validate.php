<?php
/**
 * Created by PhpStorm.
 * User: RMartin
 * Date: 2/23/2018
 * Time: 10:56 AM
 */
require_once ('model/db-functions.php');

$errors = array();

/**
 * Checks to make sure the username is not already
 * taken in the database.
 *
 * @param $username that is going to be validated.
 */
function isValidUsername($username)
{
    global $errors;
    // A username is valid if it is not already in the table
    $result = findUser($username);

    if(!empty($result))
    {
        $errors['username'] = "That name is already taken.";
    }
}

/**
 * A function that checks the two paremeters are matching, that they
 * contain at least one digit, one capital and one lowercase letter, and
 * that the password is a minimum of 8 characters.
 *
 * @param $password the password entered, which should match $confirmPass
 * @param $confirmPass password confirmation that should match $password
 */
function isValidPassword($password, $confirmPass)
{
    // A password is valid if the two fields match, and
    // it contains a capital, a lowercase, a number, and is
    // a minimum of 8 characters
    global $errors;
    $pattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/";
    if($password != $confirmPass)
    {
        $errors['password'] = "Password fields do not match. Please confirm your password.";
    }
    else if(!preg_match($pattern, $password))
    {
        $errors['password'] = "Password must contain at least one number, one capital and one
                               lowercase letter, and be at least 8 characters long.";
    }
}

/**
 * The actual function call for the above validation
 * functions, which will return an array of error messages
 * if anything is wrong with the given information.
 *
 * @param $username that is going to be validated.
 * @param $password the password entered, which should match $confirm
 * @param $confirm the password confirmation, which should match $password
 * @return array of error messages.
 */
function validate($username, $password, $confirm)
{
    global $errors;
    isValidUsername($username);
    isValidPassword($password, $confirm);
    return $errors;
}