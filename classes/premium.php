<?php
/**
 * The Premium_User class represents a Premium member on the snake site.
 *
 * The Premium class represents a Premium member. In addition to the
 * member fields, the Premium member adds two ints; $totalSnake, to keep
 * track of the whole length of all snakes over the life of the Premium member,
 * and $cellsTraveled, which keeps track of how much their snakes have moved.
 *
 * @author Raine Padilla <epadilla7@mail.greenriver.edu>
 * @author Scott Medlock <smedlock@mail.greenriver.edu>
 * @copyright 2018
 */

class Premium_User extends User
{
    private $totalSnake;
    private $cellsTraveled;

    // Does not have a separate constructor from Member, so will
    // automatically call parent constructor

    /**
     * Retrieves the number of cells traveled.
     *
     * @return String representing the number of cells traveled.
     */
    public function getCellsTraveled()
    {
        return $this->cellsTraveled;
    }

    /**
     * Adds the $cellsTraveled to the current number stored
     * for cells traveled.
     *
     * @param int $cellsTraveled the number to be added.
     * @return void
     */
    public function setCellsTraveled($cellsTraveled)
    {
        $this->cellsTraveled += $cellsTraveled;
    }

    /**
     * Retrieves the total length of the Premium object's snake.
     *
     * @return String representing total snake length.
     */
    public function getTotalSnake()
    {
        return $this->totalSnake;
    }

    /**
     * Adds the $snakeLength to the current number stored
     * for total snake length.
     *
     * @param mixed $snakeLength
     */
    public function setTotalSnake($snakeLength)
    {
        $this->totalSnake += $snakeLength;
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