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

<div class="t-case"><img src="/theme/symantec_lms/pix/trophyglyph.png" alt="Trophy access icon." class="trophycase-icon"/></div>
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
							if (!$USER->username){
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
								global $USER;
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
	<div id="spacer" class="pull-right span1"></div>
<?PHP
//if cookie yes
if($_COOKIE["menu"] === "open"){
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
		<?php echo $OUTPUT->blocks('side-pre', 'span1 desktop-first-column'); ?>
		<aside id="lms-small-menu" class="lms-small-menu span1 desktop-first-column block-region">
			<span class="lms-menu-toggle span1">&raquo;</span>
			<a href="/"><img src="/theme/symantec_lms/pix/home.png" class="lms_menu_item"/></a>
			<a href="/course/index.php"><img src="/theme/symantec_lms/pix/courses.png" class="lms_menu_item"/></a>
			<a href="/course/view.php?id=4"><img src="/theme/symantec_lms/pix/demo.png" class="lms_menu_item"/></a>
			<a href="/course/view.php?id=3"><img src="/theme/symantec_lms/pix/smbt.png" class="lms_menu_item"/></a>
			<a href="#" id="reportIcon"><img src="/theme/symantec_lms/pix/report.png" class="lms_menu_item"/></a>
		</aside>
    </div>
    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
</body>
</html>