<?php
	namespace app;
	
	
	class Model {
		
		public $db;
		
		public function __construct($db)
		{
			$this->db = $db;
		}
		
		public function getGeocod()
		{
			return $this->db->select("SELECT id, brewery_id, latitude, longitude FROM geocodes");

		}

		public function getBrewery($brewery_id)
		{
			return $this->db->select("SELECT name FROM breweries WHERE id = " . $brewery_id ." ");

		}
		
		public function getBeers($brewery_id)
		{
			return $this->db->select("SELECT name FROM beers WHERE brewery_id = " . $brewery_id ." ");
			
		}

		public function addUser(array $userData)
		{
			return $this->db->insert("INSERT into users (username, name, surname, email, password, level, lastIp) VALUES (:username, :name, :surname, :email, :password, :level, :ip)",
				[':username'=>$userData['username'], ':name'=>$userData['name'], ':surname'=>$userData['surname'], ':email'=>$userData['email'], ':password'=>$userData['password'], ':level'=>1, ':ip'=>$_SERVER['REMOTE_ADDR']]
			);
		}
		
		public function creatMark(array $userData)
		{
			return $this->db->create("CREATE TABLE 'marker' ('id' int(11) NOT NULL AUTO_INCREMENT, 'latitude' FLOAT(19,15) NOT NULL, 'longitude' FLOAT(19,15) NOT NULL, 'quadkey' bigint(20) NOT NULL DEFAULT 0, PRIMARY KEY ('id'), INDEX 'quadkey' ('quadkey'))");
		}
		
		
		
	}