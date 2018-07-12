<?php
	namespace app;
	
	include "app/Import.php";
	use PDO;
	
	
	class Database {
		
		private $connection;
		private $import;
		
		public function __construct(){
			if ( $this->tablesExists(CONFIG['db_name']) > 0){
				$this->connect();
			}else{
				new Import();
				$this->connect();
			}
		}

		private function connect(){
			
			try {
				$this->connection = new PDO("mysql:host=" . CONFIG['db_hostname'] . ";dbname=" . CONFIG['db_name'] . ";charset=utf8", CONFIG['db_username'], CONFIG['db_password']);
				// set the PDO error mode to exception
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}
		
		private function tablesExists($db){
			
			$this->connection = new PDO("mysql:host=" . CONFIG['db_hostname'] . ";dbname=information_schema;charset=utf8", CONFIG['db_username'], CONFIG['db_password']);
			
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
				
				$sql = "SELECT COUNT( TABLE_NAME )  FROM COLUMNS WHERE TABLE_SCHEMA = '$db'";
				$statement = $this->connection->prepare($sql);
				$statement->execute();
				$this -> connection = null;
				
				$r =  $statement->fetchColumn();
				return $r;
			
		}

		private function tableEmpty() {

        }
		
		// Select
		public function select( $sql,  $param = [])
		{
			// example SELECT * FROM users WHERE id = :id
			$statement = $this->connection->prepare($sql);
			// example $param = ["id" => 666];
			$statement->execute($param);
			return $statement->fetchAll(PDO::FETCH_ASSOC);
		}

		// Insert
		public function insert( $sql,  $param = [])
		{
			$statement = $this->connection->prepare($sql);
			$statement->execute($param);
			return $this->connection->lastInsertId();
		}

		// Remove
		public function remove( $sql,  $param = [])
		{
			$statement = $this->connection->prepare($sql);
			$statement->execute($param);
			return $statement->rowCount();
		}
		
		// Create
		public function create( $sql,  $param = [])
		{
			$statement = $this->connection->prepare($sql);
			$statement->execute($param);
			return $this->connection->lastInsertId();
		}

		function __destruct() { $this->connection = null; }
		
	}