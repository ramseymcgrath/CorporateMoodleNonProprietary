<?php
/**
 * This file is the read only status page for our moodle server
 * 
 * @package    theme_symantec_lms
 * @subpackage page
 * @copyright  2015 onwards: Symantec Corp.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../../config.php');
require_once($CFG->libdir.'/environmentlib.php');

global $PAGE;
$PAGE->set_context(context_system::instance());
?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
	<title>Sym-U Server Status</title>

<style>

table {
	background-color: rgba(0, 0, 0, 0);
	border-bottom-color: rgb(128, 128, 128);
	border-collapse: collapse;
	border-left-color: rgb(128, 128, 128);
	border-right-color: rgb(128, 128, 128);
	border-top-color: rgb(128, 128, 128);
	color: rgb(51, 51, 51);
	display: table;
	font-family: Lucida;
	font-size: 14px;
	line-height: 20px;
	margin-bottom: 20px;
	max-width: 36%;
	text-align: left;
	width: 36%;
	white-space: nowrap;
}
thead {
	font-size: x-large;
	border-bottom: 2px black solid;
}

th {
	height: 28px;
	text-align: left;
	vertical-align: middle;	
	padding-bottom: 5px;
}

tr {
	border-bottom-color: rgb(128, 128, 128);
	border-left-color: rgb(128, 128, 128);
	border-right-color: rgb(128, 128, 128);
	border-top-color: rgb(128, 128, 128);
	display: table-row;
	height: 28px;
	line-height: 20px;
	vertical-align: middle;
}
td{
	display: table-cell;
	font-family: Lucida;
	font-size: 14px;
	height: 39.8125px;
	line-height: 20px;
	padding-bottom: 5px;
	padding-left: 7px;
	padding-right: 7px;
	padding-top: 10px;
	text-align: left;
	vertical-align: top;
	width: 100px;
}
.ok {
	background-color: rgb(70, 136, 71);
	border-bottom-left-radius: 3px;
	border-bottom-right-radius: 3px;
	border-collapse: collapse;
	border-top-left-radius: 3px;
	border-top-right-radius: 3px;
	color: rgb(255, 255, 255);
	display: inline-block;
	font-family: Lucida;
	font-size: 11.8439998626709px;
	font-weight: bold;
	height: 14px;
	line-height: 14px;
	padding-bottom: 2px;
	padding-left: 4px;
	padding-right: 4px;
	padding-top: 2px;
	text-align: left;
	text-shadow: rgba(0, 0, 0, 0.247059) 0px -1px 0px;
	vertical-align: baseline;
}
.r0 {
	background-color: lavender;
}
.r1 {
	color: rgb(51, 51, 51);
}

.warn{
	background-color: rgb(248, 148, 6);
	border-bottom-left-radius: 3px;
	border-bottom-right-radius: 3px;
	border-collapse: collapse;
	border-top-left-radius: 3px;
	border-top-right-radius: 3px;
	color: rgb(255, 255, 255);
	display: inline-block;
	font-family: Lucida;
	font-size: 11.8439998626709px;
	font-weight: bold;
	height: 14px;
	line-height: 14px;
	padding-bottom: 2px;
	padding-left: 4px;
	padding-right: 4px;
	padding-top: 2px;
	text-align: left;
	text-shadow: rgba(0, 0, 0, 0.247059) 0px -1px 0px;
	vertical-align: baseline;
	white-space: nowrap;
}

.error{
	background-color: red;
	border-bottom-left-radius: 3px;
	border-bottom-right-radius: 3px;
	border-collapse: collapse;
	border-top-left-radius: 3px;
	border-top-right-radius: 3px;
	color: rgb(255, 255, 255);
	display: inline-block;
	font-family: Lucida;
	font-size: 11.8439998626709px;
	font-weight: bold;
	height: 14px;
	line-height: 14px;
	padding-bottom: 2px;
	padding-left: 4px;
	padding-right: 4px;
	padding-top: 2px;
	text-align: left;
	text-shadow: rgba(0, 0, 0, 0.247059) 0px -1px 0px;
	vertical-align: baseline;
	white-space: nowrap;
}

h1 {
	display: inline-block;
}

div span{
	position: relative;
	top: -3px;
}

</style>
</head>
<body>
<?PHP
$OverallStatus=1;
$statusHTML = "<span class=\"ok\">OK</span>";

$version = $CFG->release;

// Get the results of the environment check.
list($envstatus, $environment_results) = check_moodle_environment($version);
$theTable = environment_check_table($envstatus, $environment_results);

if ($OverallStatus == 2){
	$statusHTML = "<span class=\"warn\">WARN</span>";
}
else if ($OverallStatus == 3){
	$statusHTML = "<span class=\"error\">ERROR</span>";
}
// Display the page.
echo "<div align=\"center\"><div><h1>Overall Server Status:  </h1> $statusHTML</div><br />$theTable</div><br /><br />";

?>
</body>
<?PHP

function environment_check_table($result, $environment_results) {
	global $CFG;
	global $OverallStatus;
	$errorCount=0;
	$warningCount=0;
	// Table headers
	$servertable = new html_table();//table for server checks
	$servertable->head  = array(
		get_string('name'),
		get_string('info'),
		//get_string('report'),
		get_string('status'),
	);
	$servertable->colclasses = array('centeralign name', 'centeralign info', 'leftalign report', 'centeralign status');
	$servertable->attributes['class'] = 'admintable environmenttable generaltable';
	$servertable->id = 'serverstatus';

	$serverdata = array('ok'=>array(), 'warn'=>array(), 'error'=>array());

	$othertable = new html_table();//table for custom checks
	$othertable->head  = array(
		get_string('info'),
		//get_string('report'),
		get_string('status'),
	);
	$othertable->colclasses = array('aligncenter info', 'alignleft report', 'aligncenter status');
	$othertable->attributes['class'] = 'admintable environmenttable generaltable';
	$othertable->id = 'otherserverstatus';

	$otherdata = array('ok'=>array(), 'warn'=>array(), 'error'=>array());

	// Iterate over each environment_result
	$continue = true;
	foreach ($environment_results as $environment_result) {
		$errorline   = false;
		$warningline = false;
		$stringtouse = '';
		if ($continue) {
			$type = $environment_result->getPart();
			$info = $environment_result->getInfo();
			$status = $environment_result->getStatus();
			$error_code = $environment_result->getErrorCode();
			
			// Process Report field
			$rec = new stdClass();
			// Something has gone wrong at parsing time
			if ($error_code) {
				$stringtouse = 'environmentxmlerror';
				$rec->error_code = $error_code;
				$status = get_string('error');
				$errorline = true;
				$continue = false;
			}

			if ($continue) {
				if ($rec->needed = $environment_result->getNeededVersion()) {
					// We are comparing versions
					$rec->current = $environment_result->getCurrentVersion();
					if ($environment_result->getLevel() == 'required') {
						$stringtouse = 'environmentrequireversion';
					} else {
						$stringtouse = 'environmentrecommendversion';
					}

				} else if ($environment_result->getPart() == 'custom_check') {
					// We are checking installed & enabled things
					if ($environment_result->getLevel() == 'required') {
						$stringtouse = 'environmentrequirecustomcheck';
					} else {
						$stringtouse = 'environmentrecommendcustomcheck';
					}

				} else if ($environment_result->getPart() == 'php_setting') {
					if ($status) {
						$stringtouse = 'environmentsettingok';
					} else if ($environment_result->getLevel() == 'required') {
						$stringtouse = 'environmentmustfixsetting';
					} else {
						$stringtouse = 'environmentshouldfixsetting';
					}

				} else {
					if ($environment_result->getLevel() == 'required') {
						$stringtouse = 'environmentrequireinstall';
					} else {
						$stringtouse = 'environmentrecommendinstall';
					}
				}

				// Calculate the status value
				if ($environment_result->getBypassStr() != '') {            //Handle bypassed result (warning)
					$status = get_string('bypassed');
					$warningline = true;
					$warningCount+=1;
				} else if ($environment_result->getRestrictStr() != '') {   //Handle restricted result (error)
					$status = get_string('restricted');
					$errorline = true;
					$errorCount+=1;
				} else {
					if ($status) {                                          //Handle ok result (ok)
						$status = get_string('ok');
					} else {
						if ($environment_result->getLevel() == 'optional') {//Handle check result (warning)
							$status = get_string('check');
							$warningline = true;
							$warningCount+=1;
						} else {                                            //Handle error result (error)
							$status = get_string('error');
							$errorCount+=1;
							$errorline = true;
						}
					}
				}
			}

			// Build the text
			$linkparts = array();
			$linkparts[] = $type;
			if (!empty($info)){
			   $linkparts[] = $info;
			}
			$infoStr = "";
			if (count($linkparts)==1){
				$infoStr = $linkparts[0];
			}
			else if (count($linkparts)==2){
				$infoStr = $linkparts[1];
			}
			
			$report = $infoStr." ".get_string($stringtouse, 'admin', $rec);
				
			// Format error or warning line
			if ($errorline || $warningline) {
				$messagetype = $errorline? 'error':'warn';
			} else {
				$messagetype = 'ok';
			}
			$status = '<span class="'.$messagetype.'">'.$status.'</span>';
			// Here we'll store all the feedback found
			$feedbacktext = '';
			// Append the feedback if there is some
			$feedbacktext .= $environment_result->strToReport($environment_result->getFeedbackStr(), $messagetype);
			//Append the bypass if there is some
			$feedbacktext .= $environment_result->strToReport($environment_result->getBypassStr(), 'warn');
			//Append the restrict if there is some
			$feedbacktext .= $environment_result->strToReport($environment_result->getRestrictStr(), 'error');

			// Add the row to the table
			if ($environment_result->getPart() == 'custom_check'){
				$otherdata[$messagetype][] = array ($info, /*$report,*/ $status);
			} else {
				$tStr = preg_replace("/.\([0-9].[0-9].[0-9][0-9].*\)/", "", $info);
				$info = $tStr;

				$serverdata[$messagetype][] = array ($type, $info, /*$report,*/ $status);
			}
		}
	}

	//put errors first in
	$servertable->data = array_merge($serverdata['error'], $serverdata['warn'], $serverdata['ok']);
	$othertable->data = array_merge($otherdata['error'], $otherdata['warn'], $otherdata['ok']);
	
	// Print table
	$output = '';
	$output .= html_writer::table($servertable);

	if (count($othertable->data)){
		//$output .= $this->heading(get_string('customcheck', 'admin'));
		$output .= html_writer::table($othertable);
	}

	if ($errorCount > 0){
		$OverallStatus = 3;
	}
	else if ($warningCount > 0){
		$OverallStatus = 2;
	}
	
	return $output;
}


