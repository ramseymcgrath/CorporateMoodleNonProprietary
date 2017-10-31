<?php

require_once('../../../config.php');
require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("Login");
$PAGE->set_heading("Login");
$PAGE->set_url($CFG->wwwroot.'/alternate_login.php');

$course = '0';

if (isset($_REQUEST['id'])){
	$course = (int) $_REQUEST['id'];
}

echo $OUTPUT->header(); ?>

<script type="text/javascript" src="/theme/javascript.php?theme=symantec_lms&amp;rev=-1&amp;type=footer"></script>


	<div class="split_auth_container">
		<center>
		<div>
			<p id="login_header"></p>
		</div>
		</center>
		<?php
			auth_googleoauth2_display_buttons();
		?>
	</div>
	<div class="split_auth_container">
	<center>
		<div>
			<p id="sam_login_text">If you encounter any issues with login, please <a href="mailto:DL-NBU-SYMU@symantec.com">contact us</a> and we will work to get you access.</p>
		</div>
		<div class="singinprovider" style="display:inline-block;padding:10px;">
			<a id="sam_login_btn" href="/auth/onelogin_saml/index.php" class="btn btn-warning" role="button"></a>
		</div>
		<div><p id="login_text"></p>
		</div>
	</center>
	</div>

	<script>
		$(document).ready(function(){
			$('#region-main').removeClass('span7');
			$('#region-main').addClass('span12');
			$('.t-case').hide();
			$('#region-main').removeClass('span7');
		});
	</script>
