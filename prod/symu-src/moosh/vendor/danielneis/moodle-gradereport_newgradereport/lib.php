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

require_once($CFG->dirroot.'/grade/report/lib.php');

class grade_report_newgradereport extends grade_report {


    function __construct($courseid, $gpr, $context, $page=null) {
        parent::__construct($courseid, $gpr, $context, $page);
        $this->course_grade_item = grade_item::fetch_course_item($this->courseid);
    }

    function process_data($data){
    }

    function process_action($target, $action){
    }

    public function show() {
    }

    private function get_moodle_grades() {
        global $DB, $CFG;

        $grades = $DB->get_records('grade_grades', array('itemid' => $this->course_grade_item->id), 'userid', 'userid, finalgrade');
        if(!is_array($grades)) {
            $grades = array();
        }

        $this->moodle_grades = array();

        if ($this->course_grade_item->gradetype == GRADE_TYPE_SCALE) {
            $pg_scale = new grade_scale(array('id' => $CFG->grade_report_newgradereport_scale));
            $scale_items = $pg_scale->load_items();
            foreach ($this->moodle_students as $st)  {
                if (isset($grades[$st->id])) {
                    $fg = (int)$grades[$st->id]->finalgrade;
                    if(isset($scale_items[$fg-1])) {
                        $this->moodle_grades[$st->id] = $scale_items[$fg-1];
                    } else {
                        $this->moodle_grades[$st->id] = null;
                    }
                } else {
                    $this->moodle_grades[$st->id] = null;
                }
            }
        } else {
            foreach ($this->moodle_students as $st)  {
                if (isset($grades[$st->id])) {
                    $this->moodle_grades[$st->id] = grade_format_gradevalue($grades[$st->id]->finalgrade,
                                                                        $this->course_grade_item, true,
                                                                        $this->course_grade_item->get_displaytype(), null);
                } else {
                    $this->moodle_grades[$st->id] = null;
                }
            }
        }
    }
}
