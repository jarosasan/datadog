<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="/<?= CONFIG['site_path']?>/assets/css/style.css">
	<title>Brewery trip</title>
</head>
<body>
<div class="container-fluid"><div class="row">
	<div class="container">
		<div class="row">
			<div class="form text-center">
				<h1>Alaus kelias</h1>
					<div class="form-group">
						<label for="exampleInputEmail1">City</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" id="address" name="address" value="" placeholder="Enter city">
							<div class="input-group-append">
								<button id="button" class="btn btn-outline-secondary" type="button">Search</button>
							</div>
						</div>
						<small id="" class="form-text text-muted">Enter city whear you start.</small>
					</div>
					<div class="form-group">
						<label for="">Trip distance</label>
						<input id="num" type="number" class="form-control" name="num" value=""  placeholder="1000 KM">
					</div>
					<button id="go" type="submit" class="btn btn-primary">Goo!!!</button>
			</div>
		</div>
	</div>
</div>
	<div class="container">
		<div class="row">
			<div class="col s6">
				<a href="#table" id="distance" class=" col s12 waves-effect waves-teal btn btn-primary butt"></a>
			</div>
			<div class="col s6">
				<a href="#list1" id="beersColection" class="col s12 waves-effect waves-teal btn btn-primary"></a>
			</div>
		</div>
		<div class="row">
				<div id="map">
				</div>
			</div>
		<div class="row">
			<div id="table" class="col s12">
				<div class="tname">
				
				</div>
				<table class="responsive-table bordered striped">
				</table>
			</div>
			<div class="col s12">
				<ul id="list1" class="collection whit-header ">
				
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
	
	</div>
</div>
<footer class="page-footer">
	<div class="container">
		<div class="time"></div>
		<div class="memory"></div>
	</div>
</footer>


<script	src="https://code.jquery.com/jquery-3.3.1.min.js"		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4BLiS1-b1BSin89wJ12ne_ao-Gvt5-kI&callback=initMap"></script>

<script src="/<?= CONFIG['site_path']?>/assets/js/script.js"></script>

</body>
</html>
