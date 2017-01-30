<?php

namespace Mvc\Exceptions;

class BadRequestHttpException extends ClientHttpException {

    public function __construct($message = '', \Exception $previous = null, $code = 0)
    {
        parent::__construct(400, $message, $previous, $code);
    }
}
