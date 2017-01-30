<?php

namespace Mvc\Exceptions;

class ClientHttpException extends HttpException {

    public function __construct($httpCode, $message = '', \Exception $previous = null, $code = 0)
    {
        parent::__construct($httpCode, $message, $previous, $code);
    }
}
