<?php

require_once('vendor/autoload.php');

use model\factories\ActionFactory;
use controller\ActionController;
use model\factories\StatusFactory;
use controller\StatusController;
use model\factories\TechnicianFactory;
use controller\TechnicianController;
use model\factories\LocationFactory;
use controller\LocationController;
use model\factories\ReportFactory;
use controller\ReportController;

// Dirty hack to allow Yannick to work without Vagrant
if ( file_exists( 'C:\dontvagrant.txt' ) ) {
	$root = "webandmobile/";
} else {
	$root = "";
}

$router = new AltoRouter();
$router->setBasePath('/');

try {
	# curl -X GET http://192.168.1.250/action/
	$router->map('GET', $root.'action/', 
		function() {
			$controller = new ActionController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/status/
	$router->map('GET', $root.'status/', 
		function() {
			$controller = new StatusController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/technician/
	$router->map('GET', $root.'technician/', 
		function() {
			$controller = new TechnicianController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/location/
	$router->map('GET', $root.'location/', 
		function() {
			$controller = new LocationController();
			$controller->handleFindAll();
		}
	);
	
	# curl -X GET http://192.168.1.250/report/
	$router->map('GET', $root.'report/', 
		function() {
			$controller = new ReportController();
			$controller->handleFindAll();
		}
	);

	# curl -X GET http://192.168.1.250/action/1
	$router->map('GET', $root.'action/[i:getal]', 
		function( $id ) {
			$controller = new ActionController();
			$controller->handleFind( $id );
		}
	);
	
	# curl -X GET http://192.168.1.250/location/1
	$router->map('GET', $root.'location/[i:getal]', 
		function( $id ) {
			$controller = new LocationController();
			$controller->handleFind( $id );
		}
	);
	
	# curl -X GET http://192.168.1.250/report/1
	$router->map('GET', $root.'report/[i:getal]', 
		function( $id ) {
			$controller = new ReportController();
			$controller->handleFind( $id );
		}
	);

	# curl -X GET http://192.168.1.250/status/1
	$router->map('GET', $root.'status/[i:getal]', 
		function( $id ) {
			$controller = new StatusController();
			$controller->handleFind( $id );
		}
	);

	# curl -X GET http://192.168.1.250/technician/1
	$router->map('GET', $root.'technician/[i:getal]', 
		function( $id ) {
			$controller = new TechnicianController();
			$controller->handleFind( $id );
		}
	);

	$router->map('POST', $root.'action/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$action = ActionFactory::CreateFromArray( $data );
			$controller = new ActionController();
			$controller->handleCreate( $action );
		}
	);

	$router->map('POST', $root.'status/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$status = StatusFactory::CreateFromArray( $data );
			$controller = new StatusController();
			$controller->handleCreate( $status );
		}
	);
	
	$router->map('POST', $root.'report/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$report = ReportFactory::CreateFromArray( $data );
			$controller = new ReportController();
			$controller->handleCreate( $report );
		}
	);
		
	$router->map('POST', $root.'location/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$location = LocationFactory::CreateFromArray( $data );
			$controller = new LocationController();
			$controller->handleCreate( $location );
		}
	);
			
	$router->map('POST', $root.'technician/',
		function() {
			$json = file_get_contents( 'php://input' );
			$data = json_decode( $json, true );
			$technician = TechnicianFactory::CreateFromArray( $data );
			$controller = new TechnicianController();
			$controller->handleCreate( $technician );
		}
	);

	$match = $router->match();

	if( $match && is_callable( $match['target'] ) ){
		call_user_func_array( $match['target'], $match['params'] ); 
	} else {
		echo 'Geen match';
	}

} catch (Exception $e) {
	var_dump($e);
} finally {
	$pdo = null;
}