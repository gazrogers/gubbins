<?php
namespace Library\Exceptions;

class InternalServerError extends HttpError
{
    public $httpErrorCode = 500;
    public $httpErrorType = 'Internal Server Error';
}
