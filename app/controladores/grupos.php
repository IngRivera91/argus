<?php 

namespace Controlador;

use Ayuda\Html;
use Clase\Modelo;
use Modelo\Metodos;
use Clase\Controlador;
use Interfas\Database;
use Error\Base AS ErrorBase;
use Modelo\Grupos AS ModeloGrupos;

class grupos extends Controlador
{
    public array $metodosAgrupadosPorMenu;
    public string $nombreGrupo;
    public int $grupoId;
    public Modelo $Metodos;

    public function __construct(Database $coneccion)
    {
        $modelo = new ModeloGrupos($coneccion);
        $this->Metodos = new Metodos($coneccion);
        $nombreMenu = 'grupos';
        $this->breadcrumb = false;

        $camposLista = [
            'Id' => 'grupos_id',
            'Grupo' => 'grupos_nombre',
            'Activo' => 'grupos_activo'
        ];

        $camposFiltrosLista = [
            'Grupo' => 'grupos.nombre'
        ];

        parent::__construct($modelo, $nombreMenu, $camposLista, $camposFiltrosLista);
    }

    public function registrar()
    {
        $this->breadcrumb = true;
        
        $this->htmlInputFormulario[] = Html::input('Grupo','nombre',4);

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $nombreMenu = $this->nombreMenu;
        $registro = $this->registro;

        $this->htmlInputFormulario[] = Html::input('Grupo','nombre',4,$registro["{$nombreMenu}_nombre"]);

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

    public function permisos()
    {
        $grupoId = $this->validaRegistoId();
        $this->grupoId = $grupoId;
        $this->metodosAgrupadosPorMenu = $this->modelo->obtenerMetodosAgrupadosPorMenu($grupoId);
        $this->nombreGrupo = $this->modelo->obtenerNombreGrupo($grupoId);
        
    }

    public function validaMedotoId()
    {
        if (!isset($_GET['metodoId'])) {
            throw new ErrorBase('se esperaba el parametro GET metodoId');  
        }

        $metodoId = (int) $_GET['metodoId'];

        if (!$this->Metodos->existeRegistroId($registroId)) {
            throw new ErrorBase('el metodoId no existe'); 
        }
        
        return $metodoId;

    }

    public function validaGrupoId()
    {
        if (!isset($_GET['grupoId'])) {
            throw new ErrorBase('se esperaba el parametro GET grupoId');  
        }

        $grupoId = (int) $_GET['grupoId'];

        if (!$this->modelo->existeRegistroId($registroId)) {
            throw new ErrorBase('el grupoId no existe');  
        }
        
        return $grupoId;
    }

}