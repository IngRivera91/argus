<?php 

namespace Controlador;

use Clase\Controlador;
use Interfas\Database;
use Modelo\Metodos AS ModeloMetodos;
use Interfas\GeneraConsultas;

class metodos extends Controlador
{
    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $modeloMetodos = new ModeloMetodos($coneccion,$generaConsulta);
        $nombreMenu = 'metodos';

        $camposLista = [
            'Id' => 'metodos_id',
            'Menu' => 'menus_nombre',
            'Metodo' => 'metodos_nombre',
            'Etiqueta' => 'metodos_etiqueta',
            'Icono' => 'metodos_icono'
        ];

        parent::__construct($modeloMetodos, $nombreMenu, $camposLista);
    }

}