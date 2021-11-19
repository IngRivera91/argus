<?php

namespace App\Controllers;

use App\Class\Auth;
use App\class\BaseController;
use App\Class\Html;
use App\Class\Redireccion;
use App\Errors\Base as ErrorBase;
use App\Models\Group;
use App\Models\User;
use Exception;

class UserController extends BaseController
{
    private array $grupos;
    public function __construct()
    {
        $this->model = User::class;
        $this->nameController = 'User';
        $this->grupos = Group::query()->get()->toArray();

        $this->listaRelations = ['group'];

        parent::__construct();
    }

    public function lista()
    {
        $this->breadcrumb = false;

        $this->filtroRelations = [
            'Group' => 'group'
        ];

        $this->filtroTableRelations = [
            'Group' => 'groups'
        ];

        $this->camposLista = [
            'Id' => 'id',
            'Nombre' => 'name',
            'Apellidos' => 'last_name',
            'Correo' => 'email',
            'Usuario' => 'user',
            'Grupo' => 'group+name',
            'Activo' => 'activo',
        ];

        parent::lista();
    }

    public function generaInputFiltros (array $datosFiltros): void
    {
        $col = 3;
        $this->sizeColumnasInputsFiltros = $col;

        $datos['User+name'] = '';
        $datos['User+last_name'] = '';
        $datos['Group+id'] = '';

        foreach ($datosFiltros as $key => $filtro) {
            $datos[$key] = $filtro;
        }

        $placeholder = '';

        $tablaCampo = 'User+name';
        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Nombre',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);

        $tablaCampo = 'User+last_name';
        $this->htmlInputFiltros[$tablaCampo] = Html::inputText($col,'Apellidos',1,$tablaCampo,$placeholder,$datos[$tablaCampo]);

        $tablaCampo = 'Group+id';
        $this->htmlInputFiltros[$tablaCampo] = Html::selectConBuscador(
            'selectGroup',
            'id',
            'Grupo',
            $tablaCampo,
            $col,
            $this->grupos,
            'name',
            $datos[$tablaCampo],
            1,
            ''
        );
    }

    public function registrar()
    {
        $this->breadcrumb = true;

        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Nombre',1,'name');
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Apellidos',2,'last_name');
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Correo',3,'email');
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Usuario',4,'user');
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Contraseña',5,'password');
        $this->htmlInputFormulario[] = Html::selectConBuscador(
            'selectGroups',
            'id',
            'Grupo',
            'group_id',
            4,
            $this->grupos,
            'name',
            '-1',
            1
        );

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $registro = $this->registro;

        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Nombre',1,'name','',$registro['name']);
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Apellidos',2,'last_name','',$registro['last_name']);
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Correo',3,'email','',$registro['email']);
        $this->htmlInputFormulario[] = Html::inputTextRequired(4,'Usuario',4,'user','',$registro['user']);
        $this->htmlInputFormulario[] = Html::selectConBuscador(
            'selectGroups',
            'id',
            'Grupo',
            'group_id',
            4,
            $this->grupos,
            'name',
            $registro['group']['id'],
            1
        );

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

    public function nuevaContra()
    {
        parent::modificar();

        $this->htmlInputFormulario['inputContraseña'] = Html::inputTextRequired(4,'Contraseña',1,'password');
        $this->htmlInputFormulario['submit'] = Html::submit('cambiar contraseña',$this->llaveFormulario,4);
    }

    public function nuevaContraBd()
    {

        $datos = $this->validaDatosFormulario();

        try {
            $this->consulta = $this->model::query();
            $this->registro = $this->consulta->find($datos['usuarioId']);
            $this->registro->password = Auth::encryptPassword($datos['password']);
            $this->registro->updated_user_id = USUARIO_ID;
            $this->registro->save();
        } catch (Exception $e) {
            if (DEBUG_MODE) {
                $error = new ErrorBase($e->getMessage());
                $error->muestraError();exit;
            }
            $mensaje = 'error al tratar de cambiar la contraseña';
            Redireccion::enviar($this->nameController,'lista',SESSION_ID,$mensaje);
            exit;
        }

        $this->registro->password = md5($datos['password']);
        $this->registro->save();

        $mensaje = 'se cambio la contraseña';

        $url = Redireccion::obtener($this->nameController,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
        exit;
    }
}
