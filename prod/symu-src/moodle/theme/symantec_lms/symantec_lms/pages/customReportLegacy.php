<?php

require_once('../../../config.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("Generate Custom Report");
$PAGE->set_heading("Generate Custom Report");
$PAGE->set_url($CFG->wwwroot.'theme/symantec_lms/pages/customReport.php');

defined('MOODLE_INTERNAL') || die;

require_login();

global $USER;

$id = $USER->id;

$course = '0';

echo $OUTPUT->header();

if(!isset($_POST['submit'])) 
{
?>
<form action="customReport.php" method="post">
	<select name="courseid">
<?php
getCourseOptions();
?>
	</select>
	<br />
	<select name="workcenter">
<?php
getWorkCenter();
?>
	</select>
	<br />
	<input type="submit" name="submit" value="Generate Feedback"><br>
</form>
<?php
}
else if(isset($_POST['submit'])) 
{
echo "Users from Workcenter ".$_POST['workcenter']." and CourseID ".$_POST['courseid']."<br /><br />";
echo "<ul>";
generateReport($_POST['courseid'], $_POST['workcenter']);
echo "</ul>";
}
echo $OUTPUT->footer();

function generateReport($courseid, $workcenter){
	global $USER, $SESSION, $CFG, $DB, $CON;
	
	if (connectToDB() == false){
		return false;
	}
	$temptable = mysqli_query($CON, "CREATE TEMPORARY TABLE tablename SELECT CONCAT(u.firstname, ' ', u.lastname) AS 'fullname', u.email, u.id, ROUND((g.finalgrade/g.rawgrademax)*100) AS grade, IF(g.finalgrade > i.gradepass, 'Complete', 'Incomplete') AS complete, i.itemname as name, FROM_UNIXTIME(g.timemodified) AS 'completionDate' FROM `mdl_grade_grades` g JOIN `mdl_grade_items` i ON g.itemid = i.id JOIN `mdl_user` u ON u.id = g.userid WHERE i.courseid = $courseid AND i.itemmodule IS NOT NULL AND u.institution = '$workcenter'");
	$lessons = getAllLessons($courseid);
	//$quizzes = getAllQuizzes($courseid);
	$users = getReportUsers($courseid, $workcenter);
	print_r($users, true);
	
	echo "<table class='table'>";
	echo "<tr><th>Full Name</th><th>Email Address</th>";
		foreach($lessons as $lesson){
			if($lesson['name']!= ""){
				echo "<th>".$lesson['name']."</th>";
				echo "<th>Complete</th>";
				echo "<th>Completion Date</th>";
			}
		}

	echo "</tr>";
	
	
	
	foreach($users as $user){
		echo "<tr>";
		echo "<td>".$user['name']."</td>";
		echo "<td>".$user['email']."</td>";
			foreach($lessons as $lesson){
				getUsersGrades($user['id'], $lesson['name']);
			}
		echo "</tr>";
	}
	
	echo "</table>";
	
	mysqli_close($CON);
	$CON=null;
}

function getReportUsers($courseid, $workcenter){
	global $USER, $SESSION, $CFG, $DB, $CON;
	
	$users=null;
	
	$result = mysqli_query($CON, "SELECT DISTINCT fullname, id, email FROM `tablename`");
	print_r($result,true);
	while( $row = mysqli_fetch_array($result) ){
		$users[] = array( "name" => $row['fullname'], "email" => $row['email'], "id" => $row['id']);
	}
	
	return $users;
}

function getUsersGrades($userid, $name){
	global $USER, $SESSION, $CFG, $DB, $CON;
	
	$result = mysqli_query($CON, "SELECT grade, complete, completionDate FROM `tablename` WHERE id = '$userid' AND name = '$name'");
	if (mysqli_num_rows($result)==0) { 
		echo "<td>--</td>";
		echo "<td>Incomplete</td>";
		echo "<td>--</td>";
	}
	else{
		while( $row = mysqli_fetch_array($result) ){
			echo "<td>";
			
			if($row['grade'] == ""){
				echo "0";
			}
			else {
				echo $row['grade'];
			}
			echo "%</td>";
			echo "<td>".$row['complete']."</td>";
			echo "<td>".$row['completionDate']."</td>";
		}
	}
}

function getAllLessons($courseid){
	global $USER, $SESSION, $CFG, $DB, $CON;
	
	$lessons=null;
	
	$result = mysqli_query($CON, "SELECT DISTINCT name FROM `tablename` WHERE name != '' AND name IS NOT NULL");
	
	while( $row = mysqli_fetch_array($result) ){
		$lessons[] = array( "name" => $row['name']);
	}
	
	return $lessons;
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

function getCourseOptions(){
	global $USER, $SESSION, $CFG, $DB, $CON;
	
	if (connectToDB() == false){
		return false;
	}
	
	$result = mysqli_query($CON, "SELECT id, fullname FROM `mdl_course`");
	
	while( $row = mysqli_fetch_array($result) ){
		echo "<option ";
		echo "value='".$row['id']."'";
		echo ">";
		echo $row['fullname'];
		echo "</option>";
	}
	
	mysqli_close($CON);
	$CON=null;
}

function getWorkCenter(){
	global $USER, $SESSION, $CFG, $DB, $CON;
	
	if (connectToDB() == false){
		return false;
	}
	
	$result = mysqli_query($CON, "SELECT name FROM `mdl_cohort`");
	
	while( $row = mysqli_fetch_array($result) ){
		echo "<option ";
		echo "value='".$row['name']."'";
		echo ">";
		echo $row['name'];
		echo "</option>";
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