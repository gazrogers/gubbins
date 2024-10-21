<?php
/**
 * SecurityPlugin class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Plugins;

use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Component;
use Phalcon\Acl\Enum;
use Phalcon\Acl\Role;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Library\Exceptions\NotFound as NotFoundException;

/**
 * Handles access control
 *
 * @package GubbinsPhalcon
 */

class SecurityPlugin extends Injectable
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $auth = $this->session->get('auth');
        $roles = !$auth ? [] : $auth['roles'];

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $acl = $this->getAcl();

        if(!$acl->isComponent($controller))
        {
            return true;
        }

        $allowed = array_reduce(
            $roles,
            fn($allowed, $role) => $allowed || $acl->isAllowed($role, $controller, $action),
            false
        );
        if(!$allowed)
        {
            $dispatcher->forward([
                'controller' => 'login',
                'action'     => '',
            ]);

            $this->session->destroy();

            return false;
        }

        return true;
    }

    protected function getAcl(): AclList
    {
        $acl = new AclList();
        $acl->setDefaultAction(Enum::DENY);

        // Register roles
        $roles = [
            'user' => new Role('User', 'Member privileges, granted after sign in.')
        ];

        foreach ($roles as $role) {
            $acl->addRole($role);
        }

        //Private area resources
        $userResources = [
            // 'index' => ['index']
        ];
        foreach ($userResources as $resource => $actions) {
            $acl->addComponent(new Component($resource), $actions);
        }

        // Grant access to private area to role Users
        foreach ($userResources as $resource => $actions) {
            foreach ($actions as $action) {
                $acl->allow('User', $resource, $action);
            }
        }

        return $acl;
    }
}
