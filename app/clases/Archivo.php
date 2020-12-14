<?php

namespace Clase;

abstract class Archivo
{
    protected array  $archivosPermitidos = ['pdf'];
    protected int    $pesoMaximoArchivoMB = 2;
    protected string $rutaArchivos = RUTA_BASE.'/archivos/';

    protected function validadTipoArchivo(string $nombreOriginalArchivo):bool
    {

    }

    protected function generaNombreArchivo():string
    {

    }

    protected function validadPesoArchivo():bool
    {

    }
}