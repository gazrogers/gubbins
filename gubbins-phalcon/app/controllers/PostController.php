<?php
/**
 * Post controller class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Controller;

use Model\Entity\Posts;

/**
 * Handles Post calls
 *
 * @package GubbinsPhalcon
 */
class PostController extends \Phalcon\Mvc\Controller
{
    public function userFeedPostsAction()
    {

    }

    public function addPostAction()
    {
        $tokenKey = $this->request->getHeader('x-csrf-token-key');
        $token = $this->request->getHeader('x-csrf-token');
        if($this->security->checkToken($tokenKey, $token))
        {
            $post = new Posts([
                "userId" => $this->di->get("session")->get("auth")["userId"],
                "content" => substr($this->request->getRawBody(), 0, 255),
                "created" => date("Y-m-d H:i:s")
            ]);
            $post->save();
        }
        $this->view->disable();
    }
}
