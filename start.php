<?php

	header( "Content-type: application/json; charset=utf-8" );

	require_once "config.php";
	include "app/Model.php";
	include "app/BeerTrip.php";
	include "app/Database.php";
//	include "app/Import.php";
	//	 autoloading classes
	
	
	
	
	//	relatioship setup
//	$import = new app\Import();
	$db = new app\Database();
	$model = new app\Model($db);
	$beerTrip = new app\BeerTrip($model);
	echo $beerTrip->topDist();
	


	
	
	
	
	
