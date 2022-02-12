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
	function get_timestamp(){
	    return (new DateTime())->getTimestamp();
	}
	function make_backup($database) {
        if(!file_exists("PinsBase/$database.geojson")) return;
        $version = get_timestamp();
	    rename("PinsBase/$database.geojson", "PinBase/backup/$database"."_$version.geojson");
	}

	if(!isset($_GET["database"])) return_json_err("no databese given");

	$POST = json_decode(file_get_contents('php://input'), true);
	$database = $_GET["database"];
	
	if(!$POST) return_json_err("No POST data");
	
	$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
	$host = $_SERVER['HTTP_HOST'];

    make_backup($database);

	file_put_contents("PinsBase/$database.geojson", json_encode($POST));
	
	return_json_succ(["saved_to"=> "$protocol$host/PinsBase/$database.geojson"]);

