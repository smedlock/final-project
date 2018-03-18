<?php

class Premium extends User
{
    protected $username;
    protected $password;
    protected $biography;
    protected $highScore;
    private $totalSnake;


    // Does not have a separate constructor from Member, so will
    // automatically call parent constructor

    /**
     * @return mixed
     */
    public function getTotalSnake()
    {
        return $this->totalSnake;
    }

    /**
     * @param mixed $totalSnake
     */
    public function setTotalSnake($totalSnake)
    {
        $this->totalSnake += $totalSnake;
    }

    public function __toString()
    {
        return "$this->username has a password, $this->password, and says: $this->biography";
    }
}