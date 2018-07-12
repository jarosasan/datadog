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

        public function getBeersCount($brewery_id)
        {
            return $this->db->select("SELECT COUNT(brewery_id) AS count FROM beers WHERE brewery_id = " . $brewery_id ." ");

        }

        public function calculateDistance($dist, $lati, $longi)
        {
            return $this->db->select("SELECT g.brewery_id, br.name, g.latitude, g.longitude, ( 6372.797560856 * acos( cos( radians(". $lati . ") ) * cos( radians( g.latitude ) ) * cos( radians( g.longitude ) - radians(".$longi.") ) + sin( radians(".$lati.") ) * sin( radians( g.latitude ) ) ) ) AS distance FROM geocodes g LEFT JOIN breweries br ON g.brewery_id=br.id HAVING distance< ".$dist." ORDER BY distance ASC");
        }

		
	}