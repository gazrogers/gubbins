<?php
namespace Library\Exceptions;

class Unauthorized extends HttpError
{
    public $httpErrorCode = 401;
    public $httpErrorType = 'Unauthorized';
}
