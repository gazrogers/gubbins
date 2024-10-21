<?php
/**
 * Register application routes
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

$router = $di->getRouter();

$router->add('/post', "Post::userFeedPosts", ["GET"]);
$router->add('/post', "Post::addPost", ["POST"]);
