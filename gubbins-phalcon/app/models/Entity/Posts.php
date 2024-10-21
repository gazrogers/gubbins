<?php
/**
 * Posts model class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Model\Entity;

use Phalcon\Di\Di;

/**
 * Handles data access to the posts database table
 *
 * @package GubbinsPhalcon
 */
class Posts extends \Phalcon\Mvc\Model
{
    public $postId;
    public $userId;
    public $content;
    public $created;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("posts");
    }
}