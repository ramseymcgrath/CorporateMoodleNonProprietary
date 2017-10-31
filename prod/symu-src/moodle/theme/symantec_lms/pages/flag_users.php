<?php

require_once('../../../config.php');
//include_once($CFG->wwwroot.'/theme/symantec_lms/custom_funcs.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("Flag Inactive Users");
$PAGE->set_heading("Flag Inactive Users");
$PAGE->set_url($CFG->wwwroot.'/flag_users.php');

//defined('MOODLE_INTERNAL') || die;

global $USER;

$id = $USER->id;

$course = '0';

echo $OUTPUT->header();

if (isset($_REQUEST['done'])){

echo "The following users were updated:<br />";

$users = flagUsers();

}
else{
?>
<p>This operation will search the user list for users who last accessed the system more than 90 days ago and update those users to the inactive workcenter.</p>
<form action="flag_users.php?done" method="post">
<input type='submit' value='Check Users' />
</form>
<?php
}

echo $OUTPUT->footer();

$CON=null;

function flagUsers(){
	global $USER, $SESSION, $CFG, $DB, $CON;
	
	if (connectToDB() == false){
		return false;
	}
	$result = mysqli_query($CON, "SELECT firstname, lastname FROM `mdl_user` WHERE lastaccess < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 90 day)) AND institution <> 'inactive'");
	
	$operation = mysqli_query($CON, "UPDATE mdl_user SET institution = 'inactive' WHERE lastaccess < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 90 day))");
	
	while( $row = mysqli_fetch_array($result) ){
		echo $row['firstname'];
		echo " ";
		echo $row['lastname'];
		echo "<br />";
	}
	
	mysqli_close($CON);
	$CON=null;
}


/*
START TRANSACTION;# MySQL returned an empty result set (i.e. zero rows).

UPDATE mdl_user SET institution = "inactive" WHERE lastaccess < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day));# 10 rows affected.

ROLLBACK;# MySQL returned an empty result set (i.e. zero rows).
*/

?>