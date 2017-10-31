<?php
 
/**
 * Settings for the symantec_lms theme
 */
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    global $CFG, $USER, $DB;

	$mySettings = new admin_externalpage('Flag Inactive Users', 'Flag Inactive Users', new moodle_url('/theme/symantec_lms/pages/flag_users.php'));
	
	$ADMIN->add('users', $mySettings);
}

if ($ADMIN->fulltree) {

$settings->add(new admin_setting_configcheckbox('theme_symantec_lms/menushownames',
        get_string('menushownamesText','theme_symantec_lms'), get_string('menushownamesDesc', 'theme_symantec_lms'), 0 ));

// Intro Course ID setting
$name = 'theme_symantec_lms/introcourseid';
$title = get_string('introcourseid','theme_symantec_lms');
$description = get_string('introcourseiddesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '0', PARAM_RAW, 5);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
		
//home button config
$name = 'theme_symantec_lms/menuitem1';
$title = get_string('menuitem1','theme_symantec_lms');
$description = get_string('menuitem1desc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '/my', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
$name = 'theme_symantec_lms/menuitem1text';
$title = get_string('menuitem1text','theme_symantec_lms');
$description = get_string('menuitem1textdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'HOME', PARAM_RAW, 5);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//courses button config
$name = 'theme_symantec_lms/menuitem2';
$title = get_string('menuitem2','theme_symantec_lms');
$description = get_string('menuitem2desc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '/course', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
$name = 'theme_symantec_lms/menuitem2text';
$title = get_string('menuitem2text','theme_symantec_lms');
$description = get_string('menuitem2textdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'COURSES', PARAM_RAW, 5);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//intro course menu item
$name = 'theme_symantec_lms/menuitem3';
$title = get_string('menuitem3','theme_symantec_lms');
$description = get_string('menuitem3desc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'null', PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
$name = 'theme_symantec_lms/menuitem3text';
$title = get_string('menuitem3text','theme_symantec_lms');
$description = get_string('menuitem3textdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'INTRO', PARAM_RAW, 5);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//smbt course menu item
$name = 'theme_symantec_lms/menuitem4';
$title = get_string('menuitem4','theme_symantec_lms');
$description = get_string('menuitem4desc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'null', PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
$name = 'theme_symantec_lms/menuitem4text';
$title = get_string('menuitem4text','theme_symantec_lms');
$description = get_string('menuitem4textdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'SMBT', PARAM_RAW, 5);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//home button config
$name = 'theme_symantec_lms/leadermenu';
$title = get_string('leadermenu','theme_symantec_lms');
$description = get_string('leadermenudesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '/local/game_api/gameStats.php', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
$name = 'theme_symantec_lms/leadermenutext';
$title = get_string('leadermenutext','theme_symantec_lms');
$description = get_string('leadermenutextdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'HOME', PARAM_RAW, 5);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//feedback button config
$name = 'theme_symantec_lms/menuitemfeedback';
$title = get_string('menuitemfeedback','theme_symantec_lms');
$description = get_string('menuitemfeedbackdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_URL);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
$name = 'theme_symantec_lms/menuitemfeedbacktext';
$title = get_string('menuitemfeedbacktext','theme_symantec_lms');
$description = get_string('menuitemfeedbacktextdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, 'FEEDBACK', PARAM_RAW, 5);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//Course ID for Superhero theme
$name = 'theme_symantec_lms/superherothemeID';
$title = get_string('superherothemeID','theme_symantec_lms');
$description = get_string('superherothemeIDdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//Course ID for Pirate theme
$name = 'theme_symantec_lms/piratethemeID';
$title = get_string('piratethemeID','theme_symantec_lms');
$description = get_string('piratethemeIDdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

//Course ID for Pirate theme
$name = 'theme_symantec_lms/wizardthemeID';
$title = get_string('wizardthemeID','theme_symantec_lms');
$description = get_string('wizardthemeIDdesc', 'theme_symantec_lms');
$setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_RAW);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);
}