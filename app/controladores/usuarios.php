<?php 

namespace Controlador;

use Ayuda\Html;
use Ayuda\Redireccion;
use Clase\Controlador;
use Interfas\Database;
use Error\Base AS ErrorBase;
use Modelo\Grupos AS ModeloGrupos;
use Modelo\Usuarios AS ModeloUsuarios;

class usuarios extends Controlador
{
    private array $gruposRegistros;
    public int $usuarioId;

    public function __construct(Database $coneccion)
    {
        $modelo = new ModeloUsuarios($coneccion);
        $modeloGrupos = new ModeloGrupos($coneccion);

        try {
            $columas = ['grupos_id','grupos_nombre'];
            $this->gruposRegistros = $modeloGrupos->buscarTodo($columas,[],'',true)['registros'];
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al obtner los grupos');
            $error->muestraError();
        }

        $nombreMenu = 'usuarios';
        $this->breadcrumb = false;

        $camposLista = [
            'Id' => 'usuarios_id',
            'Nombre' => 'usuarios_nombre_completo',
            'Usuario' => 'usuarios_usuario',
            'Activo' => 'usuarios_activo'
            
        ];

        $camposFiltrosLista = [
            'Nombre' => 'usuarios.nombre_completo',
            'Grupo' => 'grupos.nombre'
        ];

        parent::__construct($modelo, $nombreMenu, $camposLista, $camposFiltrosLista);
    }

    public function registrar()
    {
        $this->breadcrumb = true;
        
        $this->htmlInputFormulario[] = Html::input('Nombre Completo','nombre_completo',4);
        $this->htmlInputFormulario[] = Html::input('Correo','correo_electronico',4);
        $this->htmlInputFormulario[] = Html::input('Usuario','usuario',4);
        $this->htmlInputFormulario[] = Html::input('Contraseña','password',4);
        $this->htmlInputFormulario[] = Html::selectConBuscador(
            'grupos',
            'Grupo', 
            'grupo_id', 
            4,
            $this->gruposRegistros,
            'grupos_nombre',
            '-1',
            1
        );
        

        $this->htmlInputFormulario[] = Html::submit('Registrar',$this->llaveFormulario,4);
    }

    public function modificar()
    {
        parent::modificar();
        $this->breadcrumb = true;

        $nombreMenu = $this->nombreMenu;
        $registro = $this->registro;

        $this->htmlInputFormulario[] = Html::input('Nombre Completo','nombre_completo',4,$registro["{$nombreMenu}_nombre_completo"]);
        $this->htmlInputFormulario[] = Html::input('Correo','correo_electronico',4,$registro["{$nombreMenu}_correo_electronico"]);
        $this->htmlInputFormulario[] = Html::input('Usuario','usuario',4,$registro["{$nombreMenu}_usuario"]);
        $this->htmlInputFormulario[] = Html::selectConBuscador(
            'grupos',
            'Grupo', 
            'grupo_id', 
            4,
            $this->gruposRegistros,
            'grupos_nombre',
            $registro["{$nombreMenu}_grupo_id"],
            1
        );

        $this->htmlInputFormulario[] = Html::submit('Modificar',$this->llaveFormulario,4);
    }

    public function nuevaContra()
    {
        $this->usuarioId = $this->validaRegistoId();
        
        try {
            $resultado = $this->modelo->buscarPorId($this->usuarioId);
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al obtener datos de el registro a cambiar contraseña',$e);
            if ($this->redireccionar) {
                $error->muestraError();
                exit;
            }
            throw $error;
        }

        $this->registro = $resultado['registros'][0];

        $this->htmlInputFormulario['inputContraseña'] = Html::input('Contraseña','password',4);
        $this->htmlInputFormulario['submit'] = Html::submit('cambiar contraseña',$this->llaveFormulario,4);
    }

    public function nuevaContraBd()
    {

        $nombreLlaveFormulario = $this->llaveFormulario;
        
        if (!isset($_POST[$nombreLlaveFormulario])) {
            $mensaje = 'llave no valida';
            if (!$this->redireccionar) {
                return $mensaje;
            }
            $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
            header("Location: {$url}");
            exit;
        }

        $usuarioId = $_POST['usuarioId'];
        $datos = ['password' => md5($_POST['password']) ];
        
        try {
            $resultado = $this->modelo->modificarPorId($usuarioId, $datos);
        } catch (ErrorBase $e) {
            $error = new ErrorBase('Error al cambiar contraseña',$e);
            if ($this->redireccionar) {
                $error->muestraError();
                exit;
            }
            throw $error;
        }

        $mensaje = 'se cambio la contraseña';
        if (!$this->redireccionar) {
            return $mensaje;
        }
        $url = Redireccion::obtener($this->nombreMenu,'lista',SESSION_ID,$mensaje)."&pag={$this->obtenerNumeroPagina()}";
        header("Location: {$url}");
        exit; 
    }

}