<?php
	
	namespace app;
	
	
	class BeerTrip {
		
		private $model;
		private $geocodes = [];
		
		public function __construct( $model ) {
			$this -> model = $model;
			$this -> topDist();
			
		}
		
		
		
		/*
		 * @param array $geocodes
         *
		 **/
		private function getGeocodes() {
			$model=$this->model;
			$this -> geocodes = $model->getGeocod();
			return $this->geocodes;
			
		}
		
		/*
		 * @return Beer name.
		 *
		 * */
		private function beers($id){
			$model = $this->model;
			$beers = $model->getBeers($id);
			return $beers;
		}
		
		/*
		 * @return Brevery name.
		 *
		 * */
		private function brewery($id){
			$model = $this->model;
			$brewery = $model->getBrewery($id);
			$b = $brewery[0]['name'];
			return $b;

		}
		
		/*
	     *
	     * */
		private function cmp( $a, $b ) {
			if ( $a['distance'] == $b['distance'] ) {
				return 0;
			}
			return ( $a['distance'] < $b['distance'] ) ? - 1 : 1;
		}
		/*
		 * @return sort array by distance.
		 * */
		private function sortDist( $array ) {
			uasort($array, array($this, 'cmp'));
			return $array;
		}


        /*
         *
         * */
        private function cmp1( $a, $b ) {
            if ( $a['distance'] == $b['distance'] ) {
                return 0;
            }
            return ( $a['distance'] < $b['distance'] ) ? - 1 : 1;
        }
        /*
         * @return sort array by distance.
         * */
        private function sortBrewery( $array ) {
            uasort($array, array($this, 'cmp1'));
            return $array;
        }
		

        /**
         * @param $start
         * @param $brewery
         * @param $trDist
         * @return array
         */
        private function distanceAll($start, $brewery, $trDist ) {
			$allDist = [];
			for ( $i = 0; $i < count( $brewery ); $i ++ ) {
				$finish['latitude']  = $brewery[ $i ]['latitude'];
				$finish['longitude'] = $brewery[ $i ]['longitude'];
				$dist['distance']        = $this->getDistanceBetweenTwoPoints( $start, $finish );
				if ( $dist['distance'] < $trDist ) {
					$dist['brewery_id'] = $brewery[ $i ]['brewery_id'];
					$dist['latitude']   = $brewery[ $i ]['latitude'];
					$dist['longitude']  = $brewery[ $i ]['longitude'];
					$dust['beer_count'] = $this->model->getBeersCount($brewery[$i]['brewery_id']);
					$allDist[]          = $dist;
				}
			}
			return $allDist;
		}
		
		
		
		/*
		* @return distance beetween two pockets.
		*
		* */
		private function getDistanceBetweenTwoPoints( $point1, $point2 ) {
			
			$earthRadius = 6371;  // earth radius in km
			$point1Lat   = $point1['latitude'];
			$point2Lat   = $point2['latitude'];
			$deltaLat    = deg2rad( $point2Lat - $point1Lat );
			$point1Long  = $point1['longitude'];
			$point2Long  = $point2['longitude'];
			$deltaLong   = deg2rad( $point2Long - $point1Long );
			$a           = sin( $deltaLat / 2 ) * sin( $deltaLat / 2 ) + cos( deg2rad( $point1Lat ) ) * cos( deg2rad( $point2Lat ) ) * sin( $deltaLong / 2 ) * sin( $deltaLong / 2 );
			$c           = 2 * atan2( sqrt( $a ), sqrt( 1 - $a ) );
			
			$distance = $earthRadius * $c;
			$distance = round($distance, 3, PHP_ROUND_HALF_UP);
			return $distance;    // in km
		}
		
		
		/*
		*
		*@return array brewery  by trip distance and trip distance.
		*
		* */
		public function topDist() {
			
			header("Content-type:application/json");
			
			$start = [
				'distance'       => 0,
				'brewery_id' => 0,
				'name'      => $_POST['home'],
				'latitude'   => $_POST['lati'],
				'longitude'  => $_POST['longi'],
                'beer_count' => 0
			];
			
			$tripDist = $_POST['distance'];
			
			$allBreweryes = $this->distanceAll($start, $this->getGeocodes(), $tripDist/3);
			$allBreweryes[] = $start;
			
			$this->addBreweryesToDb($allBreweryes);
			$results[] = $start;
			$dist = 0;
			$top = $this->topFromDb();
			$beersResult = [];
			while($dist < $tripDist){
				$first = array_shift($top);
				$toStart = $this->getDistanceBetweenTwoPoints($start, $first);
				
				if (($first['distance'] + $toStart) < ($tripDist-$dist)) {
					$dist      += $first['distance'];
					$first['name'] = $this->brewery($first['brewery_id']);
					$results[] = $first;
					$top = $this->distanceAll($first, $top, $tripDist);
					$top = $this->sortDist($top);
					$beersResult = array_merge($beersResult, $this -> beers( $first['brewery_id'] ));
				}else{
					$start['distance'] = $this->getDistanceBetweenTwoPoints($start, end($results));
					$results[] = $start;
					$allDist = $dist + $start['distance'];
					$dist =$tripDist +1;
				}
			}
			$result['brewery']    = $results;
			$result['beers']      = $beersResult;
			$result['dist']       = round($allDist, 3);
			$this->dropTable();
			$r = json_encode($result);
			return $r;
			
		}
		
		private function addBreweryesToDb($breweryes){
			$model=$this->model;
			$model->createTable();
			for ($i = 0; $i < count($breweryes); $i ++){
				$model->createTemp($breweryes[$i]);
			}
			
		}
		
		private function topFromDb(){
			$model = $this->model;
			$result = $model->top();
			return $result;
		}
		
		public function dropTable(){
			$model = $this->model;
			$model->dropTable();
		}
		
	}



