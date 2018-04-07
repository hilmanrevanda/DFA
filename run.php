<?php

index();

function index(){
	if( isset($_POST["data"]) and isset($_POST["input"]) and isset($_POST["end"]) and isset($_POST["start"]) ){
		$rules = setData($_POST["data"]);

		$state = $_POST["start"];

		$accept_states = explode(",", $_POST["end"]);

		$input = $_POST["input"];

		$tokens = str_split($input , 1);

		// $tokens = array_merge(
		//     str_split($input),
		//     ['EOF']
		// );

		// echo "start:". $state ."\n";

		// print "<pre>";
		// print_r($accept_states);
		// print "</pre>";

		// echo "rules:\n";
		// print "<pre>";
		// print_r($rules);
		// print "</pre>";

		// echo "input:\n";
		// print "<pre>";
		// print_r($input);
		// print "</pre>";

		foreach ($tokens as $token) {
		    if (!isset($rules[$state][$token])) {
		        $token = var_export($token, true);
		        echo "No rule found for state" . ($state + 1) . ", token " . $token;
		    }
		    $state = $rules[$state][$token];
		}
		if (!in_array($state, $accept_states)) {
		    echo "Ended in state" . ($state + 1) . "which is not an accept state.";
		}
		echo "The provided input has been accepted by accept state " . ($state + 1);

	}else{
		echo "Invalid input";
	}
}


function setData($value){
	$arry = explode("|", $value);

	$newarry = array();

	$i = 0;
	foreach ($arry as $val) {
		$tmp = explode(",", $val);

		$newarry[$i]['0'] = $tmp[0];
		$newarry[$i]['1'] = $tmp[1];

		$i++;
	}
	return $newarry;
}
