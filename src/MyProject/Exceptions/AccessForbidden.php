<?php


namespace MyProject\Exceptions;


use Throwable;

class AccessForbidden extends \Exception
{
public function __construct($message = "", $code = 0, Throwable $previous = null)
{
    parent::__construct($message, $code, $previous);

    $this->message = 'Forbidden';
    $this->code = 403;
}
}