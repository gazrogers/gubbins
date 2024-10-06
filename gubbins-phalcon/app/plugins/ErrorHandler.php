<?php
/**
 * Error handler class
 *
 * @author Gareth Rogers <gareth@garethrogers.net>
 */

namespace Plugins;

use Error;
use Exception;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Library\Exceptions\HttpError;

/**
 * Handles errors and exceptions
 *
 * @package GubbinsPhalcon
 */

class ErrorHandler extends Injectable
{
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        $response = $this->di->get('response');
        if($exception instanceof HttpError)
        {
            $status = [$exception->httpErrorCode, $exception->httpErrorType];
            $errors = [$exception->getMessage()];
            $exception->extra($response);
            // $errorPage = $exception->errorPage;
        }
        elseif($exception instanceof Exception)
        {
            $status = [500, 'Internal Server Error'];
            $errors = [$exception->getMessage()];
            $this->di->get('logger')->error($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
        }
        else
        {
            $status = [500, 'Internal Server Error'];
            $errors = ["Server error"];
            $this->di->get('logger')->error(
                $exception instanceof Error ? $exception->getMessage() . PHP_EOL . $exception->getTraceAsString() : "Unhandled error class: " . get_class($exception)
            );
        }

        // if($this->request->getHeader('Accept') == "application/json")
        // {
            $this->view->disable();
            $response->setStatusCode(...$status);
            $response->setJsonContent(["errors" => $errors]);
            $response->send();
        // }
        // else
        // {
        //     $this->assets->addCss("/css/reset.css");
        //     $this->assets->addCss("/css/shared.css");
        //     $this->assets->addCss("/css/layouts.css");
        //     $this->assets->addCss("/css/error.css");
        //     $this->view->bodyClass = "error";
        //     $this->view->pageTitle = "Something went wrong";
        //     $this->view->setLayout("results");
        //     $this->view->setTemplateBefore('with-header');
        //     $this->view->pick($errorPage ?: "itsallgonepearshaped");
        //     $this->view->pageTitle = "Error";
        //     $this->view->errors = $errors;
        // }

        return false;
    }
}
