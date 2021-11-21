<?php

namespace App\Controllers;

class AdminController extends UserController
{
    public function __construct()
    {
        parent::__construct();
        $this->nameController = 'Admin';
        $this->filtrosBase = [
            ['campo' => 'users.group_id', 'valor' => GRUPO_ADMINISTRADORES_ID, 'signoComparacion' => '=', 'relacion' => ''],
        ];
    }

    public function lista()
    {
        parent::lista();
        unset($this->camposLista['Grupo']);

    }

    public function generaInputFiltros (array $datosFiltros): void
    {
        parent::generaInputFiltros($datosFiltros);
        unset($this->htmlInputFiltros['Group+id']);
    }

    public function registrar()
    {
        parent::registrar();
        unset($this->htmlInputFormulario['SelectGroup']);
    }

    public function registrarBd()
    {
        $_POST['group_id'] = GRUPO_ADMINISTRADORES_ID;
        parent::registrarBd();
    }

    public function modificar()
    {
        parent::modificar();
        unset($this->htmlInputFormulario['SelectGroup']);
    }
}
