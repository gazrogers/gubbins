<?php
/**
 * Users model class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Model\Entity;

use Phalcon\Di\Di;

/**
 * Handles data access to the users database table
 *
 * @package GubbinsPhalcon
 */
class Users extends \Phalcon\Mvc\Model
{
    public $userId;
    public $username;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("users");
    }
}