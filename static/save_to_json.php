<?php
	
	function return_json($array) {
		header('Content-type: application/json');
		echo json_encode($array);
		exit();
	}
	
	function return_json_err($msg) {
		return_json(['status'=>'error', 'message'=>strval($msg)]);
	}
	
	function return_json_succ($array) {
		return_json(array_merge(['status'=>'success'], $array));
	}
	
	$POST = json_decode(file_get_contents('php://input'), true);
	
	if(!$POST) return_json_err("No POST data");
	
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
	$host = $_SERVER['HTTP_HOST'];
	
	file_put_contents("map.geojson", json_encode($POST));
	
	return_json_succ(["saved_to"=> "$protocol$host/map.geojson"]);