<?php
 
	namespace Clase;

	class Database{
		private $host = DB_HOST;
		private $user = DB_USER;
		private $password = DB_PASSWORD;
		private $name = DB_NAME;

		private $errores;
		public $error = null;

		public $dbh;
		public $stmt;

		public function __construct($usuario = DB_USER,$password = DB_PASSWORD){
		    $this->user = $usuario;
		    $this->password = $password;
            $this->errores = new Errores();
			$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->name;
			$opciones = array(
				\PDO::ATTR_PERSISTENT => true,
				\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
			);

			try {
				$this->dbh = new \PDO($dsn,$this->user,$this->password,$opciones);
				$this->dbh->exec('set names utf8');
			} catch (\PDOException $e) {
                $error_sql = $e->getMessage();
                $this->errores->n_error_mysql =$error_sql;
                $this->errores->error_mysql =$error_sql;
                $this->error =  $this->errores->datos(1,'Error, al conectar a la base de datos',
                    __CLASS__,__LINE__,__FILE__,$error_sql,__FUNCTION__);
			}
		}

		public function query($sql){
			$this->stmt = $this->dbh->prepare($sql);
		}

        public function bind($parametro,$valor){
            $this->stmt->bindValue($parametro, $valor);
        }

        public function execute(){
			$this->stmt->execute();
		}

        public function registros(){
            $this->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

		public function rowCount(){
			$this->execute();
			return $this->stmt->rowCount();
		}
	}
