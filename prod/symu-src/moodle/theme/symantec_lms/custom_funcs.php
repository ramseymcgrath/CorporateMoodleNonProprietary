<?php
$mConfig = str_replace('\\','/',dirname(__FILE__).'\config.php');

include_once $mConfig;

$CON=null;
$queryArray = $_REQUEST;

if ( isset($_REQUEST['event']) ){
	$badgeId="";
	if ( $_REQUEST['event'] == "award_badge"){
		if ( isset($_REQUEST['badge_id']) ){
			$badgeId = $_REQUEST['badge_id'];

			$dataString;
			$dataString = getBadgeInfo($badgeId);
		}
	}
}

if ( $_REQUEST['f'] == "get_firstlast"){
	global $CON;
	global $CFG;
	if (connectToDB() == false){
		return null;
	}
	$the_user = $_REQUEST['user'];
	$rslt = mysqli_query($CON, "SELECT `firstname`,`lastname` FROM `mdl_user` WHERE `username` LIKE '".$the_user."'");
	$row = mysqli_fetch_assoc($rslt);
	$fn_ln = $row["firstname"]." ".$row["lastname"];
	mysqli_close($CON);
	$CON=null;
	print($fn_ln);
}

if ($queryArray['f'] == "get_categories"){
		$theCats = getCats( );
		print ( join(",", $theCats) );
	}

function getscore($_attemptid){
	global $CON;
	global $CFG;
	
	$attemptScore=0;
	if (connectToDB() == false){
		return null;
	}
	
	$rslt = mysqli_query($CON, "SELECT * FROM mdl_quiz_attempts WHERE id='$_attemptid'");
	
	$row = mysqli_fetch_all($rslt,MYSQLI_BOTH);
	
	$attemptScore = $row[0]["sumgrades"];
	if ($attemptScore == null)
	{
		$attemptScore = "it was null yo.";
	}
	mysqli_close($CON);
	$CON=null;
	
	return $attemptScore;
}

function connectToDB(){
	global $CON;
	global $CFG;
	
	if ($CON != null){
		return true;
	}
	
	$CON=mysqli_connect($CFG->dbhost, $CFG->dbuser, $CFG->dbpass, $CFG->dbname);
	
	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		return false;
	}
	return true;
}

function behaviorPing($verb, $data){
    $agent_id = $_COOKIE["BVSDKdip"];

	$BV_ENV;
	$envsetting = get_my_config('environment');
	if ($envsetting == "0"){
		$BV_ENV = 'sandbox';
	}
	else{
		$BV_ENV = 'api';
	}

	$BV_CAIRO_KEY = get_my_config('cairokey');
	$BV_SITE_ID = get_my_config('siteid');
	$BV_VERSION = get_my_config('apiversion');
	
    if ($agent_id != null){
        // users endpoint
        $agentsEndpoint = "http://" . $BV_ENV. ".badgeville.com/cairo/". $BV_VERSION . "/" . $BV_CAIRO_KEY . "/sites/" . $BV_SITE_ID . "/agents/".$agent_id. "/activities";

        // action parameter
        $myParameters = "?do=create";

        // data parameter
        $myParameters = $myParameters . "&data={\"verb\":\"".$verb."\",".$data."}";
       
		$curl_result = process_BVcurl_request($agentsEndpoint.$myParameters);
    }

	if ($curl_result != null){
		setcookie("doNotify", $agent_id , null, "/", "symantec.com");
	}
}

function get_my_config($key){
	global $CON;
	global $CFG;
	
	if (connectToDB() == false){
		return null;
	}
	
	$rslt = mysqli_query($CON, "SELECT value FROM mdl_config_plugins WHERE name='$key'");
	$row = mysqli_fetch_assoc($rslt);
	$data = $row["value"];
	mysqli_close($CON);
	$CON=null;
	return $data;
}

/**
 *  Helper function to call Cairo API
 */
function process_BVcurl_request($url, $req=NULL){
    $result = NULL;
    $json='';

    $dbFlag =  get_my_config('debugflag');
    $debugMail = get_my_config('debugmail');

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ( $req === "delete" ){
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    }
    curl_setopt($ch, CURLOPT_URL, $url);

    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Status code will return 200 except for server errors
    curl_close($ch);

    // check for successful http response
    if($http_status != '200'){
        $result = NULL;  // return NULL value to indicate failure
    }

    if ( $dbFlag == 1 || $dbFlag == true ){
        $message = $url."\n\n".$result;
        error_log($message, 1, $debugMail, "From: no-reply@symu.symantec.com\n");
    }
    return $result;
}

function getCats() {
	global $CON;
	global $CFG;
	
	$course_cats;
	
	if (connectToDB() == false){
		return null;
	}
	
	$result = mysqli_query($CON, "SELECT name,id FROM mdl_course_categories WHERE depth = 1");
	
	while( $row = mysqli_fetch_array($result) ){
		$course_cats[] = $row['name'].",".$row['id'];
	}

	mysqli_close($CON);
	$CON=null;

	return $course_cats;
}
