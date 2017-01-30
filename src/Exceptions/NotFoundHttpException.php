<?php

namespace Mvc\Exceptions;

class NotFoundHttpException extends ClientHttpException {

    public function __construct($message = '', \Exception $previous = null, $code = 0)
    {
        parent::__construct(404, $message, $previous, $code);
    }
}
