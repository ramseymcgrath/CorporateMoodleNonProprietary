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

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/filelib.php');

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
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
	if(isset($USER->email) && strlen($USER->email)>0){
			echo "<span class='points grow'>";
			echo json_decode(get_points($USER->email));
			echo "</span>";
	}
}
?>
</div>
<div id="backpack" class="bp_off">
	<div id="bp_liner">
		<div id="symu-backpack-agentRewards" class="symu-backpack symu-backpack-agentRewards"><script> $(document).ready(function(){doBackpack();}); </script></div>
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
							if (!isset($USER->username)){
							echo '<a href="/login">Login</a>';
							}
							else{
							echo '<div class="dropdown-toggle sr-only" type=""button" id="user" data-toggle="dropdown">';
							echo $USER->username;
							echo '&#9660;';
							echo '</div>';
							}
						?>
						<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
							<?php
								$sesskey = $USER->sesskey;
								$id = $USER->id;
								$profile = '<li role="presentation"><a role="menuitem" tabindex="-1" href="/user/profile.php?='.$id.'">Profile</a></li>';
								$logout = '<li role="presentation"><a role="menuitem" tabindex="-1" href="/login/logout.php?sesskey='.$sesskey.'">Logout</a></li>';
								echo $profile;
								echo $logout;
							?>
							
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
		<section id="region-main" class="span9 pull-right">
			<?php
			echo $OUTPUT->course_content_header();
			echo $OUTPUT->main_content();
			echo $OUTPUT->course_content_footer();
			?>
		</section>
    </div>
    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
<div class="bpoverlay"></div>
</body>
</html>
