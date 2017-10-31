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
 * Self enrol plugin external functions
 *
 * @package    enrol_newenrol
 * @copyright  2013 Rajesh Taneja <rajesh@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

/**
 * Self enrolment external functions.
 *
 * @package   enrol_newenrol
 * @copyright 2012 Rajesh Taneja <rajesh@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since     Moodle 2.6
 */
class enrol_newenrol_external extends external_api {

    /**
     * Returns description of get_instance_info() parameters.
     *
     * @return external_function_parameters
     */
    public static function get_instance_info_parameters() {
        return new external_function_parameters(
                array('instanceid' => new external_value(PARAM_INT, 'instance id of newenrol enrolment plugin.'))
            );
    }

    /**
     * Return newenrol-enrolment instance information.
     *
     * @param int $instanceid instance id of newenrol enrolment plugin.
     * @return array instance information.
     */
    public static function get_instance_info($instanceid) {
        global $DB, $CFG;

        require_once($CFG->libdir . '/enrollib.php');

        $params = newenrol::validate_parameters(newenrol::get_instance_info_parameters(), array('instanceid' => $instanceid));

        // Retrieve newenrol enrolment plugin.
        $enrolplugin = enrol_get_plugin('newenrol');
        if (empty($enrolplugin)) {
            throw new moodle_exception('invaliddata', 'error');
        }

        $enrolinstance = $DB->get_record('enrol', array('id' => $params['instanceid']), '*', MUST_EXIST);
        $coursecontext = context_course::instance($enrolinstance->courseid);
        $categorycontext = $coursecontext->get_parent_context();
        newenrol::validate_context($categorycontext);

        $instanceinfo = (array) $enrolplugin->get_enrol_info($enrolinstance);
        if (isset($instanceinfo['requiredparam']->enrolpassword)) {
            $instanceinfo['enrolpassword'] = $instanceinfo['requiredparam']->enrolpassword;
        }
        unset($instanceinfo->requiredparam);

        return $instanceinfo;
    }

    /**
     * Returns description of get_instance_info() result value.
     *
     * @return external_description
     */
    public static function get_instance_info_returns() {
        return new external_single_structure(
            array(
                'id' => new external_value(PARAM_INT, 'id of course enrolment instance'),
                'courseid' => new external_value(PARAM_INT, 'id of course'),
                'type' => new external_value(PARAM_PLUGIN, 'type of enrolment plugin'),
                'name' => new external_value(PARAM_RAW, 'name of enrolment plugin'),
                'status' => new external_value(PARAM_RAW, 'status of enrolment plugin'),
                'enrolpassword' => new external_value(PARAM_RAW, 'password required for enrolment', VALUE_OPTIONAL),
            )
        );
    }
}
