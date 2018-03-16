<?php

class Premium extends User
{
    protected $username;
    protected $password;
    protected $biography;
    protected $highScore;
    private $totalSnake;
    private $cellsTraveled;

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
        if($this->cellsTraveled < $cellsTraveled)
        {
            $this->cellsTraveled = $cellsTraveled;
        }

    }

    public function __toString()
    {
        return "$this->username has a password, $this->password, and says: $this->biography";
    }
}