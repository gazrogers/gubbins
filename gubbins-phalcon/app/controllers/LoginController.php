<?php
/**
 * Login controller class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Controller;

use Google_Client;
use Library\Exceptions\Forbidden as ForbiddenException;
use Library\Exceptions\InternalServerError as InternalServerErrorException;

/**
 * Handles authorization
 *
 * @package GubbinsPhalcon
 */
class LoginController extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        $appVersion = $this->di->get('version');
        // $this->assets->collection('css')->setPrefix($this->di->get('url')->get('/'));
        // $this->assets->collection('js')->setPrefix($this->di->get('url')->get('/'));
        $this->assets->addCss('css/main.css', false, null, [], $appVersion);
        $this->assets->addJs("//accounts.google.com/gsi/client", false, false, ["async" => "async"]);
    }

    public function indexAction()
    {
        $this->view->clientId = $this->di->getConfig()->credentials["GOOGLE_CLIENT_ID"];
    }

    public function callbackAction()
    {
        // This is Google sign-in specific and will have to be refactored at a later date
        // CSRF check
        if($_COOKIE['g_csrf_token'] !== $this->request->get("g_csrf_token"))
        {
            throw new ForbiddenException("CSRF verification failed");
        }
        // Verify ID token
        $client = new Google_Client(['client_id' => $this->di->getConfig()->credentials["GOOGLE_CLIENT_ID"]]);
        $payload = $client->verifyIdToken($this->request->get('credential'));
        if($payload)
        {
            $userId = $payload['sub'];
            $userEmail = $payload['email'];
            $userImage = $payload["picture"];
        }
        else
        {
            throw new ForbiddenException("Invalid ID token");
        }
        // Now either login existing user or create new user (use ID rater than email as this never changes)

        $this->response->redirect('/');
    }
}
