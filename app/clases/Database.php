<?php

namespace Clase;
use PDO;
use Exception;

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $name = DB_NAME;

    private $dbh;
    private $stmt;

    public $error = null;

    public function __construct($host = DB_HOST, $usuario = DB_USER,$password = DB_PASSWORD,$name = DB_NAME)
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
            $this->error = $error_sql = $e->getMessage();  
        }
    }

    public function ejecutaQuery(string $query_string = '' ,array $datos = array())
    {
        if( $query_string === ''){
            throw new Exception('La query no puede estar vacia');
        }

        $explode_query = explode(' ',$query_string);

        if( count($explode_query) < 2 )
        {
            throw new Exception('Query no valida');
        }

        $tipo_consulta = $explode_query[0];

        $this->stmt = $this->dbh->prepare($query_string);

        try 
        {
            $this->stmt->execute();
            if ($tipo_consulta === 'SELECT')
            {
                $n_registros = $this->stmt->rowCount();
                $resultado = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
                return array('registros' => $resultado,'n_registros'=>$n_registros);
            }

            if ($tipo_consulta === 'UPDATE')
            {
                return array('mensaje' => 'registro modificado');
            }

            if ($tipo_consulta === 'INSERT')
            {
                $registro_id = $this->dbh->lastInsertId();
                return array(
                    'mensaje' => 'registro insertado',
                    'registro_id' =>$registro_id
                );
            }

            if ($tipo_consulta === 'DELETE')
            {
                $this->stmt->execute();
                return array('mensaje' => 'registro eliminado');
            }

        } 
        catch (PDOException $e)
        {
            print_r($e);
            throw new Exception('algo esta mal');
        }

    }

    public function bind($parametro,$valor)
    {
        $this->stmt->bindValue($parametro, $valor);
    }

}