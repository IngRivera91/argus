<?php

namespace Clase;

use PDO;
use PDOException;
use PDOStatement;
use Clase\Validaciones;
use Error\MySQL AS ErrorMySQL;


class Database
{
    private string $hostBd = DB_HOST;
    private string $usuarioBD = DB_USER;
    private string $passwordBd = DB_PASSWORD;
    private string $nombreBd = DB_NAME;
    private PDO $dbh;
    private PDOStatement $stmt;
    private Validaciones $valida;

    public function __construct(
        string $usuario = DB_USER, 
        string $passwordBd = DB_PASSWORD,
        string $nombreBd = DB_NAME, 
        string $hostBd = DB_HOST
    ) {
        $this->valida = new Validaciones();
        $this->hostBd = $hostBd;
        $this->usuarioBD = $usuario;
        $this->passwordBd = $passwordBd;
        $this->nombreBd = $nombreBd;
        
        $dsn = 'mysql:host=' . $this->hostBd . ';dbname=' . $this->nombreBd;
        $opciones = array(PDO::ATTR_PERSISTENT=>true, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);

        try
        {
            $this->dbh = new PDO($dsn,$this->usuarioBD,$this->passwordBd,$opciones);
            $this->dbh->exec('set names utf8');
        } 
        catch (PDOException $e) 
        {
            throw new ErrorMySQL($e);
        }
    }

    private function blindarDatos(array $datos):void
    {
        if (count($datos) != 0)
        {
            foreach ( $datos as $campo => $valor)
            {
                $this->stmt->bindValue(":{$this->valida->analizaCampo($campo)}",$valor);
            }
        }
    }

    private function blindarFiltros(array $filtros):void
    {
        if (count($filtros) != 0){
            foreach ( $filtros as $filtro){
                $this->stmt->bindValue(":{$this->valida->analizaCampo($filtro['campo'])}",$filtro['valor']);
            }
        }
    }

    public function ejecutaConsultaDelete(string $consulta = '', array $filtros = []):array
    {
        $this->valida->consulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarFiltros($filtros);
        try 
        {
            $this->stmt->execute();
            return ['mensaje' => 'registro eliminado'];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e,' Consulta: '.$consulta);
        }
    }

    public function ejecutaConsultaInsert(string $consulta = '', array $datos = []):array
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

    public function ejecutaConsultaSelect(string $consulta = '', array $filtros = []):array
    {
        $this->valida->consulta($consulta);
        $this->stmt = $this->dbh->prepare($consulta);
        $this->blindarFiltros($filtros);
        try 
        {
            $this->stmt->execute();
            $n_registros = $this->stmt->rowCount();
            $resultado = $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            return [ 'registros' => $resultado , 'n_registros' => (int) $n_registros ];
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e,' Consulta: '.$consulta);
        }
    }

    public function ejecutaConsultaUpdate(string $consulta = '', array $datos = [], array $filtros = []):array
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

    public function obtenColumnasTabla(string $tabla):array
    {
        $consulta = "SHOW COLUMNS FROM $tabla FROM {$this->nombreBd}";
        $this->stmt = $this->dbh->prepare($consulta);
        try 
        {
            $this->stmt->execute();
            $resultado = (array) $this->stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->generaArrayColumnas($resultado);
        } 
        catch (PDOException $e)
        {
            throw new ErrorMySQL($e,' Consulta: '.$consulta);
        }
    }

    private function generaArrayColumnas(array $columnasArray):array
    {
        $arrayColumnas = [];

        foreach ($columnasArray as $columna)
        {
            $arrayColumnas[] = "{$columna['Field']}";
        }

        return $arrayColumnas;
    }
}