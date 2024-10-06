<?php
namespace Library\Exceptions;

use Exception;
use Phalcon\Http\Response;

class HttpError extends Exception
{
    public $httpErrorCode;
    public $httpErrorType;

    public function extra(Response $response)
    {
        // This may be implemented to add extra headers - as in the Unauthorized response
    }
}
