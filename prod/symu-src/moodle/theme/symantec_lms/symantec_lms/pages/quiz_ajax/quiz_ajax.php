<?php
include_once __DIR__."/../../../config.php";
include_once __DIR__."/../custom_lib.php";
$mConfig = str_replace('\\','/',dirname(__FILE__).'/../../config.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');

include_once $mConfig;

$CON=null;
$queryArray = $_REQUEST;

//This section checks the "f" parameter and calls appropriate functions
if (!empty($queryArray) && array_key_exists("f",$queryArray)!==false){
	if ($queryArray['f'] == "update" && $queryArray['user'] != null){
		mailSpecificUser($queryArray['user']);
	}
}
