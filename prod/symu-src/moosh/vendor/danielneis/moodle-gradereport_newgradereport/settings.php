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

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $scales_options = array(get_string('none'));
    if ($scales = $DB->get_records('scale', array('courseid' => 0), 'id', 'id, name')) {
        foreach($scales as $obj){
            $scales_options[$obj->id] = $obj->name;
        }
    }
    $settings->add(new admin_setting_configselect('grade_report_newgradereport_scale',
                                                  get_string('config_scale', 'gradereport_newgradereport'),
                                                  get_string('desc_scale', 'gradereport_newgradereport'),
                                                  0,
                                                  $scales_options));

}
