<?php
/**
 * Index controller class
 *
 * @author    Gareth Rogers <gareth@garethrogers.net>
 */

namespace Controller;

/**
 * Index page
 *
 * @package GubbinsPhalcon
 */
class IndexController extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        $appVersion = $this->di->get('version');
        $this->assets->collection('css')->setPrefix($this->di->get('url')->get('/'));
        $this->assets->collection('js')->setPrefix($this->di->get('url')->get('/'));
        $this->assets->collection('externaljs')->addJs("//accounts.google.com/gsi/client", false, false, ["async" => "async"]);
        $this->assets->addCss('css/reset.css', false, null, [], $appVersion);
        $this->assets->addCss('css/main.css', false, null, [], $appVersion);
    }

    public function indexAction()
    {
        $action = $this->di->get("session")->has("auth") ? "user" : "guest";
        $this->dispatcher->forward(
            [
                'controller' => 'index',
                'action'     => $action
            ]
        );
        $this->view->cspNonce = bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function userAction()
    {
        $this->view->loggedInUsername = $this->di->get("session")->get("auth")["name"];
    }

    public function guestAction()
    {
        $this->view->clientId = $this->di->getConfig()->credentials["GOOGLE_CLIENT_ID"];
    }
}
