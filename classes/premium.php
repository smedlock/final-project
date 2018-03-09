<?php

class Premium extends User
{
    protected $username;
    protected $password;
    protected $biography;
    protected $highScore;
    private $totalSnake;
    private $longSnake;

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
    public function getLongSnake()
    {
        return $this->longSnake;
    }

    /**
     * @param mixed $longSnake
     */
    public function setLongSnake($longSnake)
    {
        if($this->longSnake < $longSnake)
        {
            $this->longSnake = $longSnake;
        }

    }
}