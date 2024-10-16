<?php
/**
 * GoogleLogins model class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Model\Entity;

use Phalcon\Di\Di;

/**
 * Handles data access to the googleLogins database table
 *
 * @package GubbinsPhalcon
 */
class GoogleLogins extends \Phalcon\Mvc\Model
{
    public $googleSubject;
    public $userId;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("googleLogins");

        $this->hasOne('userId', Users::class, 'userId', ['alias' => 'user']);
    }
}