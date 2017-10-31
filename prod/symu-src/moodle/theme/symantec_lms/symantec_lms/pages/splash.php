<?php

     if (isset($USER) && !isset($USER->username)){
	 echo "<style>#page-content{ 
			background: url('../theme/symantec_lms/pix/splash.jpg') no-repeat center center fixed;
			z-index: 4031;
    		min-height: 100%; 
			position: fixed;
			top: 0px;
			left: 0px;
			cursor: pointer;
			  -webkit-background-size: cover;
			  -moz-background-size: cover;
			  -o-background-size: cover;
			  background-size: cover;
			}
			html, body {
    		height: 100%;
    		margin: 0;
			}
			</style>";
	echo "<script>
		function doBackpack(){};
		$(document).ready(
			$('#page-content').on('click', function(){
				window.location = '/theme/symantec_lms/pages/alternate_login.php';
			})
		)
		</script>";
	} else {
		echo "<script type=\"text/javascript\">document.location.href=/my/;</script>";
	}
     exit();
?>