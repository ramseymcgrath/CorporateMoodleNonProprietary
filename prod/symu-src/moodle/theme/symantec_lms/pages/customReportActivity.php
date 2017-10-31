<?php

require_once ('../../../config.php');
require_once ('../PHPExcel.php');
require_once ('custom_lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("Generate Custom Report");
$PAGE->set_heading("Generate Custom Report");
$PAGE->set_url($CFG->wwwroot.'/customReportActivity.php');

defined('MOODLE_INTERNAL') || die;

require_login();

global $USER;

$id = $USER->id;

$course = '0';

echo $OUTPUT->header();

$isSuperUser = FALSE;

if (doesUserHaveRole($USER,'reporting_super_user')==true){
	$isSuperUser = TRUE;
}


if(!doesUserHaveRole($USER,'reporting_user')==true  and !doesUserHaveRole($USER,'reporting_super_user')==true){
	echo "You do not have permission to access this page";
	echo $OUTPUT->footer();
    exit;

}
?>
<form action="<?php echo $CFG->wwwroot;?>/report/progressVendor/index.php" method="post">
	<select name="course">
<?php
getCourseOptions();
?>
	</select>
	<br />
	<select multiple name="workcenter[]">
<?php
getWorkCenter($isSuperUser);
?>
	</select>
	<br />
	<input type="hidden" name="isencoded" value="0">
	<input type="submit" name="submit" value="Generate Report"><br>
</form>
<?php
echo $OUTPUT->footer();

$CON=null;

/*
START TRANSACTION;# MySQL returned an empty result set (i.e. zero rows).

UPDATE mdl_user SET institution = "inactive" WHERE lastaccess < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 30 day));# 10 rows affected.

ROLLBACK;# MySQL returned an empty result set (i.e. zero rows).
*/

?>