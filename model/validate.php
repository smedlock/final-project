<?php
/**
 * Created by PhpStorm.
 * User: RMartin
 * Date: 2/23/2018
 * Time: 10:56 AM
 */
require_once ('model/db-functions.php');

$errors = array();

function isValidUsername($username)
{
    // A username is valid if it is not already in the table
}

function isValidPassword($password, $confirmPass)
{
    // A password is valid if the two fields match, and
    // it contains a capital, a lowercase, a number, and is
    // a minimum of 8 characters
    global $errors;
    $pattern = "(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}";
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

function validate($password, $confirm)
{
    global $errors;
    isValidPassword($password, $confirm);
    return $errors;
}