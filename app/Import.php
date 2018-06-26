<?php
	namespace app;
	use PDO;
	
	class Import {
		
	 private $list = ['beers', 'breweries', 'categories', 'geocodes', 'styles'];
	 private $connection;
	 
	
	public function __construct() {
//		$this->createDb();
		$this->createTables();
		$this->addDataToDb();
	}
	
	
	private function createDb(){
		try {
			$this -> connection = new PDO( "mysql:host=" . CONFIG['db_hostname'] . ";charset=utf8", CONFIG['db_username'], CONFIG['db_password'] );
			$this -> connection -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			
			$sql = "CREATE DATABASE IF NOT EXISTS " .CONFIG['db_name'];
			$statement = $this->connection->prepare($sql);
			$statement->execute();
			
			$this -> connection = null;
		}
		catch
		( PDOException $e) {
			echo $e -> getMessage();
		}
	}
	
	
	private function createTables(){
		try {
			$this->connection = new PDO("mysql:host=" . CONFIG['db_hostname'] . ";dbname=" . CONFIG['db_name'] . ";charset=utf8", CONFIG['db_username'], CONFIG['db_password']);
			// set the PDO error mode to exception
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
			
			$sql = "CREATE TABLE IF NOT EXISTS beers (
					id int(6),
					brewery_id int(6),
					name VARCHAR (255),
					cat_id INT (6),
					style_id INT (6),
					abv DOUBLE NULL,
					ibu DOUBLE NULL,
					srm DOUBLE NULL,
					upc DOUBLE NULL,
					filepath VARCHAR(255) NULL,
					descript TEXT NULL,
					add_user INT(6) NULL ,
					last_mod TIMESTAMP)";
			$statement = $this->connection->prepare($sql);
			$statement->execute();
			
			$sql = "CREATE TABLE IF NOT EXISTS breweries (
					id int(6),
					name VARCHAR (255),
					address1 VARCHAR (255),
					address2 VARCHAR (255),
					city VARCHAR (255),
					state VARCHAR (255),
					code VARCHAR (255),
					country VARCHAR (255),
					phone VARCHAR (255),
					website VARCHAR (255),
					filepath VARCHAR(255) NULL,
					descript TEXT NULL,
					add_user INT(6) NULL ,
					last_mod TIMESTAMP)";
			$statement = $this->connection->prepare($sql);
			$statement->execute();
			
			$sql = "CREATE TABLE IF NOT EXISTS categories (
					id int(6) NOT  NULL ,
					cat_name VARCHAR (255) NOT NULL ,
					last_mod TIMESTAMP)";
			$statement = $this->connection->prepare($sql);
			$statement->execute();
			
			$sql = "CREATE TABLE IF NOT EXISTS geocodes (
					id int(6) NOT NULL ,
					brewery_id int(6) NOT  NULL ,
					latitude DOUBLE NOT NULL ,
					longitude DOUBLE NOT NULL ,
					accuracy VARCHAR (255))";
			$statement = $this->connection->prepare($sql);
			$statement->execute();
			
			$sql = "CREATE TABLE IF NOT EXISTS styles (
					id int(6) NOT NULL ,
					cat_id INT (6) NOT  NULL ,
					style_name VARCHAR (255) NOT  NULL ,
					last_mod TIMESTAMP)";
			$statement = $this->connection->prepare($sql);
			$statement->execute();
			
			
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
		$this->connection = null;
	}
	
		/**
		 * Get Csv file
		 * @return array
		 */
		private function getDataCsv( $table ) {
			
			$data = fopen( 'beerCsv/' . $table . '.csv', 'r' );
			while ( ! feof( $data ) ) {
				$cont[] = fgetcsv( $data );
			}
			fclose( $data );
			dump($data);
			return ( $cont );
		
		}
		
		private function addDataToDb() {
			try {
				$this -> connection = new PDO( "mysql:host=" . CONFIG['db_hostname'] . ";dbname=" . CONFIG['db_name'] . ";charset=utf8",
					CONFIG['db_username'], CONFIG['db_password'] );
				$this -> connection -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$this -> connection -> setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
				
				for ( $i = 0; $i < count( $this->list ); $i ++ ) {
					
					$csv    = $this -> getDataCsv( $this->list[ $i ] );
					$fields = $csv[0];
					
					for ( $t = 1; $t < ( count( $csv ) - 1 ); $t ++ ) {
						$row  = $csv[ $t ];
						$data = [];
						
						foreach ( $row as $r ) {
							if ( $r == '' ) {
								$d = "'" . "'";
							} elseif ( is_numeric( $r ) && ! preg_match( "/^[a-zA-Z ]+$/", $r ) ) {
								$d = $r;
							} else {
								$str = filter_var( $r, FILTER_SANITIZE_SPECIAL_CHARS );
								$d   = "'" . $str . "'";
							}
							$data[] = $d;
						}
						$sql = "INSERT INTO " . $this->list[ $i ] . " (" . implode( ', ',
								$fields ) . ") VALUES (" . implode( ', ', $data ) . ")";
						
						$statement = $this->connection->prepare($sql);
						$statement->execute();

					}
				}
				
			} catch ( PDOException $e ) {
				echo "Error; " . $e -> getMessage();
			}
			$this -> connection = null;
		}
	}




	
	







