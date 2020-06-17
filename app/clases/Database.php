<?php

namespace Clase;

use PDO;
use Error\MySQL AS ErrorMySQL;
use Error\Base AS ErrorBase;
use PDOException;

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $name = DB_NAME;

    private $dbh;
    private $stmt;

    public function __construct($usuario = DB_USER,$password = DB_PASSWORD,$name = DB_NAME, $host = DB_HOST)
    {
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

    public function ejecutaConsultaDelete(string $consulta = '' ,array $blindar = array())
    {
        $this->validaConsulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarDatos($blindar);
        try 
        {
            $this->stmt->execute();
            return array('mensaje' => 'registro eliminado');
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e);
        }
    }

    public function ejecutaConsultaInsert(string $consulta = '' ,array $blindar = array())
    {
        $this->validaConsulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarDatos($blindar);
        try 
        {
            $this->stmt->execute();
            $registro_id = (int) $this->dbh->lastInsertId();
            return ['mensaje' => 'registro insertado','registro_id' =>$registro_id];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e);
        }
    }

    public function ejecutaConsultaSelect(string $consulta = '' ,array $blindar = array())
    {
        $this->validaConsulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarDatos($blindar);
        try 
        {
            $this->stmt->execute();
            $n_registros = $this->stmt->rowCount();
            $resultado = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['registros' => $resultado,'n_registros'=>(int)$n_registros];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e);
        }
    }

    public function ejecutaConsultaUpdate(string $consulta = '' ,array $blindar = array())
    {
        $this->validaConsulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarDatos($blindar);
        try 
        {
            $this->stmt->execute();
            return ['mensaje' => 'registro modificado'];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e);
        }
    }

    private function validaConsulta(string $consulta)
    {
        if( $consulta === '')
        {
            throw new ErrorBase('La consulta no puede estar vacia');
        }
    }

}