<?php
/**
 * FollowGraph model class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Model\Entity;

use Phalcon\Di\Di;

/**
 * Handles data access to the followGraph database table
 *
 * @package GubbinsPhalcon
 */
class FollowGraph extends \Phalcon\Mvc\Model
{
    public $followed;
    public $follower;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("followGraph");
    }
}