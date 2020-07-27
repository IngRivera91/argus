<?php

namespace Error;
use PDOException;
use Error\Base AS ErrorBase;

class MySQL extends ErrorBase
{
    public function __construct(PDOException $error , string $consultaSQL = '') 
    {
        parent::__construct($error->getMessage(), null, $error->getCode(), $consultaSQL);
    }
}