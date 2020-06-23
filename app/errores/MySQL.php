<?php

namespace Error;
use Error\Base AS ErrorBase;

class MySQL extends ErrorBase
{
    public function __construct( $error , $consultaSQL = null ) 
    {
        parent::__construct( $error->getMessage(), null , (int) $error->getCode() , $consultaSQL );
    }
}