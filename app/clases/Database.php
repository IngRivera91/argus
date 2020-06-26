<?php

namespace Clase;

use PDO;
use PDOException;
use Clase\Validaciones;
use Error\MySQL AS ErrorMySQL;


class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $name = DB_NAME;

    private $dbh;
    private $stmt;

    private $valida;

    public function __construct($usuario = DB_USER,$password = DB_PASSWORD,$name = DB_NAME, $host = DB_HOST)
    {
        $this->valida = new Validaciones();
        $this->host = $host;
        $this->user = $usuario;
        $this->password = $password;
        $this->name = $name;
        
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
        $opciones = array(PDO::ATTR_PERSISTENT=>true, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);

        try
        {
            $this->dbh = new PDO($dsn,$this->user,$this->password,$opciones);
            $this->dbh->exec('set names utf8');
        } 
        catch (PDOException $e) 
        {
            throw new ErrorMySQL($e);
        }
    }

    private function blindarDatos($datos):void
    {
        if (count($datos) != 0){
            foreach ( $datos as $campo => $valor){
                $campo_explode = explode('.',$campo);
                $numero = count($campo_explode);
                if ($numero > 1){
                    $this->stmt->bindValue(':'.$campo_explode[($numero-1)],$valor);
                }else{
                    $this->stmt->bindValue(':'.$campo,$valor);
                }

            }
        }
    }

    private function blindarFiltros($filtros):void
    {
        if (count($filtros) != 0){
            foreach ( $filtros as $filtro){
                $this->stmt->bindValue(':'.$filtro['campo'],$filtro['valor']);
            }
        }
    }

    public function ejecutaConsultaDelete(string $consulta = '' ,array $blindar = array())
    {
        $this->valida->consulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarDatos($blindar);
        try 
        {
            $this->stmt->execute();
            return array('mensaje' => 'registro eliminado');
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e,' Consulta: '.$consulta);
        }
    }

    public function ejecutaConsultaInsert(string $consulta = '' ,array $datos = array())
    {
        $this->valida->consulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarDatos($datos);
        try 
        {
            $this->stmt->execute();
            $registro_id = (int) $this->dbh->lastInsertId();
            return ['mensaje' => 'registro insertado','registro_id' =>$registro_id];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e,' Consulta: '.$consulta);
        }
    }

    public function ejecutaConsultaSelect(string $consulta = '' ,array $filtros = array())
    {
        $this->valida->consulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarFiltros($filtros);
        try 
        {
            $this->stmt->execute();
            $n_registros = $this->stmt->rowCount();
            $resultado = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['registros' => $resultado,'n_registros'=>(int)$n_registros];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e,' Consulta: '.$consulta);
        }
    }

    public function ejecutaConsultaUpdate( string $consulta = '' , array $datos = [] , array $filtros = [] )
    {
        $this->valida->consulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarDatos($datos);
        $this->blindarFiltros($filtros);
        try 
        {
            $this->stmt->execute();
            return ['mensaje' => 'registro modificado'];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e,' Consulta: '.$consulta);
        }
    }

}