<?php
function GetRoles($User)
{
    global $CON;
    global $CFG;

    $context = context_system::instance();
    $roles = get_user_roles($context, $User->id, false);

    $roleNames = array();

    foreach ($roles as $role) {
        array_push($roleNames, $role->shortname);
    }
    //Now get more roles from role table
    if (connectToDB() == false) {
        return "{}";
    }

    $result = mysqli_query($CON, "SELECT * FROM `mdl_local_qa_plugin_user` WHERE user_id = '" . $User->username . "'");

    while ($row = mysqli_fetch_array($result)) {//Add roles from QA Plugin table
        array_push($roleNames, "qaplugin_" . $row["user_profile"]);
    }

    mysqli_close($CON);
    $CON = null;


    return $roleNames;
}

function doesUserHaveRole($User, $roleName)
{
    $roles = GetRoles($User);
    //print_r($roles);
    $hasRole = false;
    foreach ($roles as $role) {
        if ($role == $roleName) {
            $hasRole = true;
        }
    }
    return $hasRole;
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

function getWorkCenter($isSuperUser){
    global $USER, $SESSION, $CFG, $DB, $CON;

    $workcenters = array();

    if (connectToDB() == false){
        return false;
    }
    
    $result = mysqli_query($CON, "SELECT name FROM `mdl_cohort`");
    
    while( $row = mysqli_fetch_array($result) ){
        array_push($workcenters,$row['name']);
    }
    mysqli_close($CON);
    $CON=null;
    writeWorkcenters($workcenters,$isSuperUser,$USER->institution);   
}

function writeOption($workcenter){
    echo "<option ";
    echo "value='".$workcenter."'";
    echo ">";
    echo $workcenter;
    echo "</option>";
}

function writeWorkcenters($workcenters, $isSuperUser, $userWC){
    if ($isSuperUser == FALSE){
        if (strpos($userWC, 'Sutherland') !== false){

            foreach ($workcenters as $workcenter){
                if (strpos($workcenter, 'Sutherland') !== false){
                    writeOption($workcenter);
                }
            }
        }
        else{
            if ($userWC != NULL and $userWC != ""){
                writeOption($userWC);
            }
            else {
                echo "</select>";
                echo "</form>";
                echo "Error, this user has no institution. Please contact administrator";
                echo $OUTPUT->footer();
                exit;
            }
        }  
    }
    else {
        foreach ($workcenters as $workcenter){
            writeOption($workcenter);
        }
    }   
}

function getCourseInfo(){
    global $USER, $SESSION, $CFG, $DB, $CON;
    
    if (connectToDB() == false){
        return false;
    }
    
    $result = mysqli_query($CON, "SELECT * FROM `mdl_assignments`");
    
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

class LessonResult{
    public $lessonName;
    public $isCompleted;
    public $grade;
    public $completionDate;
    function __construct($LessonName) {
        $this->lessonName = $LessonName;
    }
    function setGrade($Value){
         $this->grade = $Value;
    }
    function setComplete($Value){
         $this->isCompleted = $Value;
    }
    function setCompletionDate($Value){
         $this->completionDate = $Value;
    }
}

class UserInfo{
    public $userName;
    public $userEmail;
    public $lessonArray;
    public $id;
    public $workcenter;
    function __construct($UserName, $UserEmail, $ID, $Workcenter){
        $this->userName = $UserName;
        $this->userEmail = $UserEmail;
        $this->id = $ID;
        $this->workcenter = $Workcenter;
        $this->lessonArray = array();
    }
    function addLessonObjToArray($lessonObj){
        if(in_array($lessonObj,$this->lessonArray, true)==FALSE){
            array_push($this->lessonArray, $lessonObj);
        }
    }
}

function getReportUsers($rows){ 
    $users=array();
    $userIDArray = array();
    
    foreach( $rows as $row ){  
        if (in_array($row['id'],$userIDArray)==FALSE){
            $newUser = new UserInfo($row['fullname'], $row['email'], $row['id'], $row['institution']);
            array_push($users, $newUser);
            array_push($userIDArray,  $row['id']);
        }    
    }
    return $users;
}

function getAllLessons($rows){
    $lessonNameArray = array();
    foreach( $rows as $row ){  
        if (in_array($row['name'],$lessonNameArray)==FALSE){
            array_push($lessonNameArray,$row['name']);
        } 
    }
    return $lessonNameArray;
}

function getUsersGrades($userObj,$rows){
    $userid = $userObj -> id;
    foreach( $rows as $row ){
        if($row['id']==$userid){
            $newResult = new LessonResult($row['name']);
            if($row['grade'] != NULL){
                $newResult->setGrade($row['grade']);
                $newResult->setComplete($row['complete']);
                $newResult->setCompletionDate($row['completionDate']);
            }else{
                $newResult->setGrade("");
                $newResult->setComplete($row['complete']);
                $newResult->setCompletionDate("");
            }
            $userObj->addLessonObjToArray($newResult);
        }         
    }  
}

function generateWorkCenterString($workcenter){
    $outString = "(";
    if (count($workcenter)>1){
        foreach($workcenter as $singleWorkCenter){
            $outString = $outString."'".$singleWorkCenter."',";
        }
        $outString = rtrim($outString, ",");
    }
    else{
        $outString = $outString."'".$workcenter[0]."'";
    }
    $outString = $outString.")";
    return $outString; 
}

function generateReport($courseid, $workcenter){
    global $USER, $SESSION, $CFG, $DB, $CON;
    //print_r($arrayOfNames);
    if (connectToDB() == false){
        return false;
    }
    $userData = null;
    $workCenterString = generateWorkCenterString($workcenter);
    $query = "SELECT CONCAT(u.firstname, ' ', u.lastname) AS 'fullname', u.institution ,u.email, u.id, ROUND((g.finalgrade/g.rawgrademax)*100) AS grade, IF(g.finalgrade > i.gradepass, 'Complete', 'Incomplete') AS complete, i.itemname as name, FROM_UNIXTIME(g.timemodified) AS 'completionDate' FROM `mdl_grade_grades` g JOIN `mdl_grade_items` i ON g.itemid = i.id JOIN `mdl_user` u ON u.id = g.userid WHERE i.courseid = ".$courseid." AND i.itemmodule IS NOT NULL AND u.institution in ".$workCenterString;
    //echo "Query Is ".$query;
    
    $result = mysqli_query($CON, $query);

    $rowsInMem = array();
    while( $row = mysqli_fetch_array($result) ){
        array_push($rowsInMem,$row);
    }
    mysqli_close($CON);
    $CON=null;

    $userObjectArray = getReportUsers($rowsInMem);
    $lessonNameArray = getAllLessons($rowsInMem);
    foreach($userObjectArray as $userObj){
        getUsersGrades($userObj,$rowsInMem);
    }     
    return $userObjectArray;
}

function makeTitleRow($userObj){
    $row = array();
    array_push($row, "User Name");
    array_push($row, "User Email");
    array_push($row, "Workcenter");
    $LessonColumns = array();
    foreach($userObj->lessonArray as $lessonObj){       
        array_push($LessonColumns, "Lesson Name");
        array_push($LessonColumns, "Lesson Complete");
        array_push($LessonColumns,"Lesson Grade");
        array_push($LessonColumns, "Completion Date");
    }
    array_push($row, "Course Complete");
    $completeRow = array_merge($row,$LessonColumns);
    return $completeRow;

}

function writeExcelReport($userObjArray) {
    $rows = array();
    $titleRow = makeTitleRow($userObjArray[0]);
    foreach($userObjArray as $userObj){
        $row = changeUserObjToRow($userObj);
        array_push($rows,$row);
    }
    array_unshift($rows,$titleRow);

    $uniqueID = uniqid();
    if (count($rows) > 0):
        $target_output_dir = "/var/www/html/symumoodle/convertedFiles/";
        $outputFiletype = ".xlsx";
        $outPath = $target_output_dir . $uniqueID . $outputFiletype;
        $outFilename = $uniqueID . $outputFiletype;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                             ->setCreator("SYMU Report")
                             ->setLastModifiedBy("SYMU Report")
                             ->setTitle("SYMU Report")
                             ->setSubject("SYMU Report")
                             ->setDescription("SYMU Report")
                             ->setKeywords("none")
                             ->setCategory("SYMU Report");
        $objPHPExcel->getActiveSheet()->fromArray($rows, " - ", "A1");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($outPath);
        echo "<a href = \"" . $CFG->wwwroot . "/convertedFiles/" . $outFilename . "\">Download your report here (xlsx Format)</a>";
    endif;
}

function changeUserObjToRow($userObj){
    $row = array();
    array_push($row, $userObj->userName);
    array_push($row, $userObj->userEmail);
    array_push($row, $userObj->workcenter);
    $CourseCompleted = "Complete";
    $LessonColumns = array();
    foreach($userObj->lessonArray as $lessonObj){
        if($lessonObj->isCompleted=="Incomplete"){
            $CourseCompleted = "Incomplete";
        }        
        array_push($LessonColumns, $lessonObj->lessonName);
        array_push($LessonColumns, $lessonObj->isCompleted);
        array_push($LessonColumns, $lessonObj->grade);
        array_push($LessonColumns, $lessonObj->completionDate);
    }
    array_push($row, $CourseCompleted);
    $completeRow = array_merge($row,$LessonColumns);
    return $completeRow;
}
function writeUsersToHTML($userObjArray){
    $rows = array();
    $titleRow = makeTitleRow($userObjArray[0]);
    foreach($userObjArray as $userObj){
        $row = changeUserObjToRow($userObj);
        array_push($rows,$row);
    }
    array_unshift($rows,$titleRow);
    echo "<table>";
    foreach($rows as $row){
        echo "<tr>";
        foreach($row as $val){
            echo "<td>";
            echo $val;
            echo "</td>";
        }
        echo "</tr>";
    }

    return;
}

function gameGetLeaderboard($limit) {
    global $CON;
    global $CFG;
    global $USER;

    $users=null;
    $userArray = "";
    
    if (connectToDB() == false){
        return "DB Error";
    }
    $result = mysqli_query($CON, "SELECT mdl_user.id AS id, mdl_user.firstname AS firstname ,mdl_user.lastname AS lastname, SUM(mdl_local_game_api.points) AS points, COUNT(mdl_local_game_api.badgeid) AS badges, mdl_user.institution AS workcenter FROM `mdl_user` INNER JOIN `mdl_local_game_api` ON mdl_user.id=mdl_local_game_api.userid GROUP BY mdl_user.id ORDER BY points DESC LIMIT $limit");
    
    $rank = 1;
    while( $row = mysqli_fetch_array($result) ){            
        $users[] = array( "firstname" => $row['firstname'],"lastname" => $row['lastname'],"id" => $row['id'], "points" => $row['points'], "badges" => $row['badges'], "workcenter" => $row['workcenter'], "rank" => $rank );
        $rank = $rank+1;
    }
    
    if($users===null){
        $userArray="";
    }
    else{
        $userArray = $users;
    }
    
    mysqli_close($CON);
    $CON=null;

    return $users;
}

function makeTitleRowLeader(){
    $row = array();
    array_push($row, "Rank");
    array_push($row, "User Name");
    array_push($row, "Points");
    array_push($row, "Badges");
    array_push($row, "Workcenter");
    return $row;
}

function changeUserObjToRowLeader($userObj){
    $row = array();
    $name = "".$userObj['firstname']." ".$userObj['lastname'];
    array_push($row, $userObj['rank']);
    array_push($row, $name);
    array_push($row, $userObj['points']);
    array_push($row, $userObj['badges']);
    array_push($row, $userObj['workcenter']);
    return $row;
}

function makeHTMLTableLeader($data){

    $outString = "";
    $rows = array();
    $titleRow = makeTitleRowLeader();
    foreach($data as $userObj){
        $row = changeUserObjToRowLeader($userObj);
        array_push($rows,$row);
    }
    array_unshift($rows,$titleRow);
    $outString .= "<table class=\"generaltable flexible boxaligncenter\" style=\"text-align:left\">";

    foreach($rows as $row){
        $outString .= "<tr>";
        foreach($row as $val){
            $outString .= "<td>";
            $outString .= $val;
            $outString .= "</td>";
        }
        $outString .= "</tr>";
    }
    $outString .= "</table>";
    return $outString;
}

function writeExcelReportLeader($userObjArray) {
    $rows = array();
    $titleRow = makeTitleRowLeader();
    foreach($userObjArray as $userObj){
        $row = changeUserObjToRowLeader($userObj);
        array_push($rows,$row);
    }
    array_unshift($rows,$titleRow);

    $uniqueID = uniqid();
    if (count($rows) > 0):
        $target_output_dir = "/var/www/html/symumoodle/convertedFiles/";
        $outputFiletype = ".xlsx";
        $outPath = $target_output_dir . $uniqueID . $outputFiletype;
        $outFilename = $uniqueID . $outputFiletype;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()
                             ->setCreator("SYMU Report")
                             ->setLastModifiedBy("SYMU Report")
                             ->setTitle("SYMU Report")
                             ->setSubject("SYMU Report")
                             ->setDescription("SYMU Report")
                             ->setKeywords("none")
                             ->setCategory("SYMU Report");
        $objPHPExcel->getActiveSheet()->fromArray($rows, " - ", "A1");
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($outPath);
        echo "<h3>Excel File</h3>";
        echo "<a href = \"" . $CFG->wwwroot . "/convertedFiles/" . $outFilename . "\">Download your file here (xlsx Format)</a>";
    endif;
}

?>