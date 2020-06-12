<?php

namespace Error;
use Error\Error;

class ErrorMySQL extends Error
{
    public function __construct($error) 
    {
        parent::__construct($error->getMessage(), null, $error->getCode());
    }
}