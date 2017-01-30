<?php

namespace Mvc\Exceptions;

class HttpException extends \RuntimeException {

    protected $httpCode;

    public function __construct($httpCode, $message = null, \Exception $previous = null, $code = 0)
    {
        $this->httpCode = $httpCode;

        parent::__construct($message, $code, $previous);
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }
}
