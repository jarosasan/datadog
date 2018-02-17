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
		
		public function createTable(){
			return $this->db->create("CREATE TABLE IF NOT EXISTS temp (id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, brewery_id INT(6) NOT NULL, latitude FLOAT NOT NULL, longitude FLOAT NOT NULL, distance FLOAT  )");
		}
		
		public function createTemp(array $temp){
			return $this->db->insert("INSERT into temp  (brewery_id, latitude, longitude, distance) VALUES (:brewery, :lat, :long, :dist)", [':brewery'=>$temp['brewery_id'], ':lat'=>$temp['latitude'], ':long'=>$temp['longitude'], ':dist'=>$temp['distance']
			]);
		}
		
		public function dropTable(){
			return $this->db->remove("DELETE FROM temp");
		}
		
		
		public function top(){
			return $this->db->select("SELECT t.brewery_id, t.latitude, t.longitude, t.distance,
			 COUNT(b.brewery_id) AS beers_count
			 FROM temp t
			 LEFT JOIN beers b ON t.brewery_id = b.brewery_id
			 GROUP BY b.brewery_id
			 ORDER BY beers_count DESC, distance ASC");
		}
		
	}