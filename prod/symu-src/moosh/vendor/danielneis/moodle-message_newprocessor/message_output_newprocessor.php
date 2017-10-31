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
 * Contains the definiton of the newprocessor message processors (does nothing)
 *
 * @package   message_newprocessor
 * @copyright 2008 Luis Rodrigues and Martin Dougiamas
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot.'/message/output/lib.php');

/**
 * The newprocessor message processor
 *
 * @package   message_newprocessor
 * @copyright 2008 Luis Rodrigues and Martin Dougiamas
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class message_output_newprocessor extends message_output {

    /**
     * Processes the message (do nothing).
     * @param object $eventdata the event data submitted by the message sender plus $eventdata->savedmessageid
     */
    function send_message($eventdata) {
        return true;
    }

    /**
     * Creates necessary fields in the messaging config form.
     *
     * @param array $preferences An array of user preferences
     */
    function config_form($preferences){
        return '';
    }

    /**
     * Parses the submitted form data and saves it into preferences array.
     *
     * @param stdClass $form preferences form class
     * @param array $preferences preferences array
     */
    function process_form($form, &$preferences){
    }

    /**
     * Returns the default message output settings for this output
     *
     * @return int The default settings
     */
    public function get_default_messaging_settings() {
        return MESSAGE_PERMITTED;
    }

    /**
     * Loads the config data from database to put on the form during initial form display
     *
     * @param array $preferences preferences array
     * @param int $userid the user id
     */
    function load_data(&$preferences, $userid){
    }

    /**
     * Returns true as message can be sent to internal support user.
     *
     * @return bool
     */
    public function can_send_to_any_users() {
        return true;
    }
}
