<?php
/**
 * The User class represents a user from the snake game website.
 *
 * The User class represents a normal member. It has four values;
 * username, password, biography, and highscore.
 *
 * @author Raine Padilla <epadilla7@mail.greenriver.edu>
 * @author Scott Medlock <smedlock@mail.greenriver.edu>
 * @copyright 2018
 */

class User
{
    protected $username;
    protected $password;
    protected $biography;
    protected $highScore;

    function __construct($username, $password, $biography='')
    {
        $this->username = $username;
        $this->password = $password;
        $this->biography = $biography;
        $this->highScore = 0;
    }

    /**
     * Retrieves the username value for the User object.
     *
     * @return String representing username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Changes the username value for the User object.
     *
     * @param String $username that the value should be changed to.
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Retrieves the password value for the User object.
     *
     * @return String representing password.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Changes the password value for the User object.
     *
     * @param String $password that the value should be changed to.
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Retrieves the biography from the User object.
     *
     * @return String representing the bio.
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Changes the biography value for the User object.
     *
     * @param String $biography that the value should be changed to.
     * @return void
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    /**
     * Retrieves the highscore for this User.
     *
     * @return int representing the highscore.
     */
    public function getHighScore()
    {
        return $this->highScore;
    }

    /**
     * Changes the value for the highscore, but only if the
     * new value is greater than the old one.
     *
     * @param int $highScore that might be the new value.
     * @return void
     */
    public function setHighScore($highScore)
    {
        if($highScore > $this->highScore)
        {
            $this->highScore = $highScore;
        }

    }

    /**
     * The default method of printing this user.
     *
     * @return String representing the values for username, password and bio.
     */
    public function __toString()
    {
        return "$this->username has a password, $this->password, and says: $this->biography";
    }


}