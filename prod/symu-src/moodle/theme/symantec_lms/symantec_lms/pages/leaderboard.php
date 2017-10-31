<?php

require_once ('../../../config.php');
require_once ('../PHPExcel.php');
require_once ('custom_lib.php');

$PAGE->set_pagelayout('standard');
$PAGE->set_context(context_system::instance());
$context = context_system::instance();
$title = "Game Dashboard";
$heading = "Leaderboards";
$PAGE->set_title($title);
$PAGE->set_heading($heading);
$PAGE->set_url($CFG->wwwroot.'/leaderboard.php');

defined('MOODLE_INTERNAL') || die;

require_login();

global $USER;

$id = $USER->id;

$limit = optional_param('limit',10,PARAM_INT);
$excel = optional_param('excel',0,PARAM_INT);

echo $OUTPUT->header();
echo '<link rel="stylesheet" type="text/css" href="leaderboard.css">';

$isSuperUser = FALSE;

if (doesUserHaveRole($USER,'reporting_super_user')==false){
	echo "You do not have permission to access this page";
	echo $OUTPUT->footer();
    exit;
}
$data = gameGetLeaderboard($limit);
if ($data=="" or $data=="DB Error"){
    echo "DB ERROR:";
    echo $data;
    echo $OUTPUT->footer();
    exit;
};

echo "<h1>Leader Board</h1>";
echo '<div id="leaderboard" class="datagrid">';
echo makeHTMLTableLeader($data);
echo '</div>';
echo '</br>';
echo "<h3>Options</h3>";
if(!isset($_POST['submit'])) 
{
	?>
	<p>Change Number of users here:</p>
	<form action="leaderboard.php" method="post">
		Count limit:<input type="text" name="limit"><br>
		Generate Excel file:<input type="checkbox" name="excel" value="excel">
		<input type="submit" name="submit" value="Change Limit"><br>
	</form>
	<?php
}
else if(isset($_POST['submit']))
{
	?>
	<p>Change Number of users here:</p>
	<form action="leaderboard.php" method="post">
		Count limit:   <input type="text" name="limit"><br>
		Generate Excel file:<input type="checkbox" name="excel" value="excel"><br>
		<input type="submit" name="submit" value="Submit">
	</form>
	<?php
}
if ($excel == 1) 
{
	writeExcelReportLeader($arrayOfUserData);
}


echo $OUTPUT->footer();

$CON=null;

/*
START TRANSACTION;# MySQL returned an empty result set (i.e. zero rows).

UPDATE mdl_user SET institution = "inactive" WHERE lastaccess < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day));# 10 rows affected.

ROLLBACK;# MySQL returned an empty result set (i.e. zero rows).
*/

?>