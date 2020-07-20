<?php 

namespace Controlador;

use Clase\Controlador;
use Interfas\Database;
use Modelo\Menus AS ModeloMenus;
use Interfas\GeneraConsultas;

class menus extends Controlador
{
    public function __construct(Database $coneccion, GeneraConsultas $generaConsulta)
    {
        $modelo = new ModeloMenus($coneccion,$generaConsulta);
        $nombreMenu = 'menus';
        $this->breadcrumb = false;

        $camposLista = [
            'Id' => 'menus_id',
            'Menu' => 'menus_nombre',
            'Etiqueta' => 'menus_etiqueta',
            'Icono' => 'menus_icono',
            'Activo' => 'menus_activo'
        ];

        $camposFiltrosLista = [
            'Menu' => 'menus.nombre'
        ];

        parent::__construct($modelo, $nombreMenu, $camposLista, $camposFiltrosLista);
    }

}