<?php

namespace Mvc\Exceptions;

class ServerHttpException extends HttpException {

    public function __construct($httpCode, $message = '', \Exception $previous = null, $code = 0)
    {
        parent::__construct($httpCode, $message, $previous, $code);
    }
}
