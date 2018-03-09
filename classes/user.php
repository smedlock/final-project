<?php

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
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

    /**
     * @return int
     */
    public function getHighScore()
    {
        return $this->highScore;
    }

    /**
     * @param int $highScore
     */
    public function setHighScore($highScore)
    {
        if($highScore > $this->highScore)
        {
            $this->highScore = $highScore;
        }

    }

    public function __toString()
    {
        return "$this->username has a password, $this->password, and says: $this->biography";
    }


}