<?php
/**
 * Index controller class
 *
 * @author    Gareth Rogers <gareth@garethrogers.net>
 */

namespace Controller;

/**
 * Handles API calls
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
        $this->assets->addCss('css/main.css', false, null, [], $appVersion);
    }

    public function indexAction()
    {

    }
}
