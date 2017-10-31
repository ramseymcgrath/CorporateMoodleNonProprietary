<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is a one-line short description of the file
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    grade_report_newgradereport
 * @author     Daniel Neis Araujo <danielneis@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

include('../../../config.php');
require($CFG->libdir .'/gradelib.php');
require($CFG->dirroot.'/grade/lib.php');
require($CFG->dirroot.'/grade/report/newgradereport/lib.php');

$courseid = required_param('id', PARAM_INT);// course id

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourseid');
}

$PAGE->set_url(new moodle_url('/grade/report/newgradereport/index.php', array('id'=>$courseid)));

require_login($courseid);

$context = get_context_instance(CONTEXT_COURSE, $course->id);

require_capability('gradereport/newgradereport:view', $context);

print_grade_page_head($COURSE->id, 'report', 'newgradereport',
                      get_string('pluginname', 'gradereport_newgradereport') .
                      $OUTPUT->help_icon('pluginname', 'gradereport_newgradereport'));

grade_regrade_final_grades($courseid);//first make sure we have proper final grades

$gpr = new grade_plugin_return(array('type'=>'report', 'plugin'=>'grader', 'courseid'=>$courseid));// return tracking object
$report = new grade_report_newgradereport($courseid, $gpr, $context);// Initialise the grader report object

$report->show();

echo $OUTPUT->footer();
