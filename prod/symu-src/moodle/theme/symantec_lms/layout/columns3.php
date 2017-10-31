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

require_once($CFG->dirroot.'/local/game_api/game.php');

$left = (!right_to_left());  // To know if to add 'pull-right' and 'desktop-first-column' classes in the layout for LTR.

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<input type="hidden" name="userid" value="<?php $USER->id;?>">
<input type="hidden" name="sessionid" value="<?php $USER->sesskey;?>">

<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div class="t-case"><img src="/theme/symantec_lms/pix/trophyglyph.png" alt="Trophy access icon." class="trophycase-icon"/>
<?php
$game_config = get_config('local_game_api');
if($game_config->enable_API == 1){
	if(!empty($USER->email) && strlen($USER->email)>0){
			echo "<span class='points grow'>";
			echo json_decode(get_points($USER->email));
			echo "</span>";
	}
}
?>
</div>
<div id="backpack" class="bp_off">
	<div id="bp_liner">
		<div id="symu-backpack-agentRewards" class="symu-backpack symu-backpack-agentRewards"></div>
	</div>
</div>
<header role="banner" class="lms-banner navbar navbar-fixed-top moodle-has-zindex">
    <nav role="navigation">
        <div class="lms-container container-fluid lms-header">
            <div>
                <?php echo $OUTPUT->custom_menu(); ?>
                <ul class="nav pull-right lms-nav">
					<li class="lms-header-text"><?php echo $SITE->shortname; ?> </li>
					<li class="lms-header-text">&nbsp;|&nbsp;</li>
                    <li class="lms-header-text lms-user-header-text">
						<div class="dropdown">

						<?php
							if (isset($USER->username) && !$USER->username){
							echo '<a href="/login">Login</a>';
							}elseif(isset($USER->username) && strlen($USER->username)>0){
							echo '<div class="dropdown-toggle sr-only" type="button" id="user" data-toggle="dropdown">';
							echo $USER->username;
							echo '&#9660;';
							echo '</div>';
							}
						?>
						<ul id="usermenu" class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
						</ul>
					</li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page" class="lms-container container-fluid">

    <header id="page-header" class="lms-page-header clearfix navbar navbar-default">
	</header>

    <div id="page-content" class="row-fluid">
	<div id="spacer" class="pull-right span1"></div>
<?PHP
//if cookie yes
if(isset($_COOKIE["menu"]) && $_COOKIE["menu"] === "open"){
?>

		<section id="region-main" class="span7 pull-right">
			<?php
			echo $OUTPUT->course_content_header();
			echo $OUTPUT->main_content();
			echo $OUTPUT->course_content_footer();
			?>
		</section>

		<?php echo $OUTPUT->blocks('side-pre', 'span4 desktop-first-column'); ?>
<?PHP
}else{
//if cookie no
?>
		<section id="region-main" class="span10 pull-right">
			<?php
			echo $OUTPUT->course_content_header();
			echo $OUTPUT->main_content();
			echo $OUTPUT->course_content_footer();
			?>
		</section>
		<?php echo $OUTPUT->blocks('side-pre', 'span1 desktop-first-column'); ?>
<?PHP
}
?>
		<aside id="lms-small-menu" class="lms-small-menu span1 desktop-first-column block-region" style="display:none;" >
		<?php $shownames = $PAGE->theme->settings->menushownames; ?>
			<span class="lms-menu-toggle span1">&raquo;</span>
			<!--Home should always appear-->
			<a href="<?php echo $PAGE->theme->settings->menuitem1; ?>"><img src="/theme/symantec_lms/pix/home.png" class="lms_menu_item" title="Home"/></a>
			<?php if($shownames){?><div id="lms_home_icon" class="lms_menu_item_text"></div><?php } ?>
			<!--Course button should always appear-->
			<a href="/course/index.php"><img src="/theme/symantec_lms/pix/courses.png" class="lms_menu_item" title="Courses"/></a>
			<?php if($shownames){?><div id="lms_courses_icon" class="lms_menu_item_text"></div><?php } ?>
			<!--SMBT-->
			<?PHP
			if (!empty($PAGE->theme->settings->menuitem4)) {
				$targetcourseid = $PAGE->theme->settings->menuitem4;
				$context = context_course::instance($targetcourseid);
				if(is_enrolled($context, $USER->id)) {
			?>
			<a href="/course/view.php?id=<?php echo ($PAGE->theme->settings->menuitem4!=NULL && !empty($PAGE->theme->settings->menuitem4))?$PAGE->theme->settings->menuitem4:""; ?>"><img src="/theme/symantec_lms/pix/smbt.png" class="lms_menu_item" title="SMBT Course"/></a>
			<?php if($shownames){?><div  id="lms_smbt_icon" class="lms_menu_item_text"></div><?php } ?>
			<?PHP
				}
			}
			?>
			<!--Glossary-->
			<a href="/mod/glossary/view.php?id=113"><img src="/theme/symantec_lms/pix/glossary.png" class="lms_menu_item" title="Glossary"/></a>
			<?php if($shownames){?><div id="lms_glossary_icon" class="lms_menu_item_text"></div><?php } ?>
			<!--Leaderboard-->
			<a href="<?php echo $PAGE->theme->settings->leadermenu; echo "?id="; echo $COURSE->id;?>"><img src="/theme/symantec_lms/pix/ranking.png" class="lms_menu_item" title="Rank"/></a>
			<?php if($shownames){?><div id="lms_game_icon" class="lms_menu_item_text"></div><?php } ?>
			<!--Feedback-->
			<a href="<?php echo $PAGE->theme->settings->menuitemfeedback; ?>" id="reportIcon"><img src="/theme/symantec_lms/pix/report.png" class="lms_menu_item" title="Report Issue"  onclick="showFeedbackModal('<?php
									if(!empty($USER->email)){
										print $USER->email;
									}
								?>')"/></a>
			<?php if($shownames){?><div id="lms_feedback_icon" class="lms_menu_item_text"></div><?php } ?>
		</aside>
    </div>
    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
<div class="bpoverlay"></div>
</body>
</html>
