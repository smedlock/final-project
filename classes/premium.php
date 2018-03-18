<?php

class Premium_User extends User
{
    protected $username;
    protected $password;
    protected $biography;
    protected $highScore;
    private $totalSnake;
    private $cellsTraveled;

    /**
     * @return mixed
     */
    public function getCellsTraveled()
    {
        return $this->cellsTraveled;
    }

    /**
     * @param mixed $cellsTraveled
     */
    public function setCellsTraveled($cellsTraveled)
    {
        $this->cellsTraveled = $cellsTraveled;
    }


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