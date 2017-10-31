<?php

require_once('../../../config.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("Learning Styles");
$PAGE->set_heading("Learning Styles");
$PAGE->set_url($CFG->wwwroot.'/learning_styles.php');

global $USER;

$id = $USER->id;

$course = '0';

echo $OUTPUT->header();

include('../../../local/notification_api/lib/ajax_interface_lib.php');


if (isset($_REQUEST['id']) && isset($_REQUEST['score'])){
	$userid = $_REQUEST['id'];
	$score = $_REQUEST['score'];
	$user = $DB->get_record('user', array('id' => $userid));
	$user->department = $score;
	$DB->update_record('user', $user);
}

if (isset($_REQUEST['retake'])){
	$score = "";
	$user = $DB->get_record('user', array('id' => $id));
	$user->department = $score;
	$DB->update_record('user', $user);
}
else {
	$user = $DB->get_record('user', array('id' => $id));
	$score = $user->department;
}
if ($score != "" && !isset($_REQUEST['message']) && !isset($_REQUEST['messageSent'])){

	if (isset($_REQUEST['showScore'])){
		$styles = str_split($_REQUEST['score']);
	?>
		<h1 id="titlebar">Learning style results for <?=$_REQUEST['firstname'] ?> <?=$_REQUEST['lastname'] ?>:</h1>
	<?php
	}
	else {
		$styles = str_split($score);
	?>
		<p>Welcome to the Learning Styles Assessment. Once the assessment is complete, the results will be available in your Sym-U Profile, by selecting “My Learning Style” from the user menu at the top right hand corner of your page. You are free to re-take the assessment as many times as you would like.</p>
		<p>Understanding your learning style will give you some information on how you approach training and what types of content and environments work best for you.</p>
	<?php
	}
	?>
	<?php
	if(in_array('a', $styles)){
	?>
	<div id="type_a" class=""><h2>Linguistic</h2>
	<p>Linguistic learners generally have highly developed reading, speaking and writing skills. They often have an expansive vocabulary, find it easy to express themselves and have strong recall of information they have read. These learners learn best when taught with spoken or written materials rather that abstract visual information and may benefit especially from expanded definitions such as those in the glossary, class discussions or written assignments. </p></div>
	<?php
	}
	if(in_array('b', $styles)){
	?>
	<div id="type_b" class=""><h2>Logical-Mathematical</h2>
	<p>Logical Mathematical learners enjoy working with numbers and complex calculations. They work through problems systematically and like to track their progress. These users are most likely to approach learning scientifically – looking for logical examples or statistics to back up new information, while at the same time beware of a tendency to overanalyze certain details within the training content. A logical learner would likely benefit from making lists of key points from the material.</p></div>
	<?php
	}
	if(in_array('c', $styles)){
	?>
	<div id="type_c" class=""><h2>Musical</h2>
	<p>Musical learners can use pitch, rhythm and tone to enhance their learning – and their ability to retain information will be enhanced through patterns of sound. They often play an instrument, sing or speak in a rhythmic manner. Musical learners may unconsciously hum or tap rhythmically while concentrating. They are more likely to be sensitive to distracting sounds. This is one of the more challenging learning styles to cater to in an online learning platform. Learners who are aware of this trait may want to think of songs that tie into what the lesson is trying to teach. </p></div>
	<?php
	}
	if(in_array('d', $styles)){
	?>
	<div id="type_d" class=""><h2>Visual/Spatial</h2>
	<p>Visual/Spatial learners generally think in pictures, rather than words and prefer the use of graphics, photographs and other images to understand and apply new concepts. They might easily grasp the big picture, but struggle to retain smaller details and can often see patterns, and understand relationships with more ease than other learning styles. Visual learners are often creative, innovative thinkers.</p></div>
	<?php
	}
	if(in_array('e', $styles)){
	?>
	<div id="type_e" class=""><h2>Bodily-Kinaesthetic</h2>
	<p>Kinaesthetic learners do best with a hands-on approach. They may find it hard to sit for long periods of time without an opportunity for activity and exploration. In school, they may have enjoyed modeling, drawing, athletics, dance or hands-on science labs. These learners enjoy physical activities and perhaps take a run or a walk while working out problems or if something is bothering them. Particularly while going through longer courses, it is important for these learners to get up and move around if they find themselves starting to fidget or unable to concentrate.  </p></div>
	<?php
	}
	if(in_array('f', $styles)){
	?>
	<div id="type_f" class=""><h2>Intrapersonal</h2>
	<p>Intrapersonal learners are more likely to be private, introspective an independent. They prefer to work alone and are known to spend time on self-analysis and are more likely to be aware of their emotions, motivations, goals an beliefs.  They think independently. These learners would benefit from setting personal training goals that reflect longer-term objectives.</p></div>
	<?php
	}
	if(in_array('g', $styles)){
	?>
	<div id="type_g" class=""><h2>Interpersonal</h2>
	<p>Intrapersonal learners relate to learning best when working with others sharing, comparing and collaborating. They are great group leaders. They communicate well with people verbally and non-verbally and are more drawn to activities that include social interaction. Interpersonal learners should look for opportunity to share the learning experience with co-workers through discussion groups or by working with or as a mentor. </p></div>
	<?php
	}
	if (isset($_REQUEST['showScore'])){
	?>
	<div style="width:50%;">
		<center>
			<input type="button" class="" value="My Learning Score" onclick="window.location.assign('/theme/symantec_lms/pages/learning_styles.php')">
			<input type="button" class="" value="Done" onclick="window.location.assign('/my')">
		</center>
	</div>
	<?php
	}
	else{
	?>
	<div style="width:50%;">
		<center>
			<input type="button" class="" value="Retake Quiz" onclick="window.location.assign('/theme/symantec_lms/pages/learning_styles.php?retake')">
			<input type="button" class="" value="Share My Results" onclick="window.location.assign('/theme/symantec_lms/pages/learning_styles.php?message')">
		</center>
	</div>
	<?php
	}
}
else if(isset($_REQUEST['message'])) {
	echo "<form method='post' action='learning_styles.php?messageSent'>";
	echo "<p>Hold down the Ctrl (windows) / Command (Mac) button to select multiple message recipients.</p>";
	echo "<select name='users[]' width='300' height='300' style='width:300px;height:300px' multiple>";
	getUserList();
	echo "</select><br />";
	echo '<input type="submit" value="Send My Learning Style">';
	echo '</form>';
}
else if(isset($_REQUEST['messageSent'])) {
	echo "Message sent.<br />";

	foreach ($_POST['users'] as $selected_option) {
		mailSpecificUser($id, $selected_option, $score);
	}
	?>
	<input type="button" class="" value="Return Home" onclick="window.location.assign('/my')">
	<?php
}
else {
?>
<div id="errors" class="well" style="display:none; color: red; width:50%;">Please answer all questions.</div>


<div class="">
	<p style="width:50%;">Welcome to the Learning Styles Assessment. Once the assessment is complete, the results will be available in your Sym-U Profile, by selecting “My Learning Style” from the user menu at the top right hand corner of your page. You are free to re-take the assessment as many times as you would like.</p>
		<p style="width:50%;">Understanding your learning style will give you some information on how you approach training and what types of content and environments work best for you.</p>
		<div style="width:50%;">
			<center>
				<input class="tracker page1" type="button" value="1" />
				<input class="tracker disabled page2" type="button" value="2" />
				<input class="tracker disabled page3" type="button" value="3" />
				<input class="tracker disabled page4" type="button" value="4" />
				<input class="tracker disabled page5" type="button" value="5" />
				<input class="tracker disabled page6" type="button" value="6" />
			</center>
		</div>
	<div id="page1" />
		<div id="1" class="well" style="width:50%;">
			I'd rather draw a map than give someone verbal directions.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="2" class="well" style="width:50%;">
			I can play (or used to play) a musical instrument.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="3" class="well" style="width:50%;">
			I can associate music with my moods.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="4" class="well" style="width:50%;">
			I can add or multiply in my head.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="5" class="well" style="width:50%;">
			I like to work with calculators and computers.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div style="width:50%;">
			<center><input type="button" class="pageButton" value="Next Page" onclick="paginate(this,'page2');"/></center>
		</div>
	</div>
	<div id="page2" style="display: none" />
		<div id="6" class="well" style="width:50%;">
			I pick up new dance steps fast.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="7" class="well" style="width:50%;">
			It's easy for me to say what I think in an argument or debate.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="8" class="well" style="width:50%;">
			I enjoy a good lecture, speech or sermon.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="9" class="well" style="width:50%;">
			I always know north from south no matter where I am.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="10" class="well" style="width:50%;">
			Life seems empty without music.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div style="width:50%;">
			<center><input type="button" class="pageButton" value="Next Page" onclick="paginate(this,'page3');"/></center>
		</div>
	</div>
	<div id="page3" style="display: none" />
		<div id="11" class="well" style="width:50%;">
			I always understand the directions that come with new gadgets or appliances.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="12" class="well" style="width:50%;">
			I like to work puzzles and play games.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="13" class="well" style="width:50%;">
			Learning to ride a bike (or skates) was easy.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="14" class="well" style="width:50%;">
			I am irritated when I hear an argument or statement that sounds illogical.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="15" class="well" style="width:50%;">
			My sense of balance and coordination is good.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div style="width:50%;">
			<center><input type="button" class="pageButton" value="Next Page" onclick="paginate(this,'page4');"/></center>
		</div>
	</div>
	<div id="page4" style="display: none" />
		<div id="16" class="well" style="width:50%;">
			I often see patterns and relationships between numbers faster and easier than others.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="17" class="well" style="width:50%;">
			I enjoy building models (or sculpting).<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="18" class="well" style="width:50%;">
			I'm good at finding the fine points of word meanings.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="19" class="well" style="width:50%;">
			I can look at an object one way and see it sideways or backwards just as easily.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="20" class="well" style="width:50%;">
			I often connect a piece of music with some event in my life.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div style="width:50%;">
			<center><input type="button" class="pageButton" value="Next Page" onclick="paginate(this,'page5');"/></center>
		</div>
	</div>
	<div id="page5" style="display: none" />
		<div id="21" class="well" style="width:50%;">
			I like to work with numbers and figures.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="22" class="well" style="width:50%;">
			Just looking at shapes of buildings and structures is pleasurable to me.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="23" class="well" style="width:50%;">
			I like to hum, whistle and sing in the shower or when I'm alone.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="24" class="well" style="width:50%;">
			I'm good at athletics.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="25" class="well" style="width:50%;">
			I'd like to study the structure and logic of languages.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div style="width:50%;">
			<center><input type="button" class="pageButton" value="Next Page" onclick="paginate(this,'page6');"/></center>
		</div>
	</div>
	<div id="page6" style="display: none" />
		<div id="26" class="well" style="width:50%;">
			I'm usually aware of the expression on my face.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="27" class="well" style="width:50%;">
			I'm sensitive to the expressions on other people's faces.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="28" class="well" style="width:50%;">
			I stay "in touch" with my moods.   I have no trouble identifying them.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="29" class="well" style="width:50%;">
			I am sensitive to the moods of others.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div id="30" class="well" style="width:50%;">
			I have a good sense of what others think of me.<br /><input type="radio" class="IsTrue" value="true" />True<br /><input type="radio" class="IsFalse" value="false" />False
		</div>
		<div style="width:50%;">
			<center><a href="#" id="submit_assessment" class="btn btn-warning" role="button" style="margin-bottom:100px;">Determine Learning Style</a></center>
		</div>

	</div>

</div>

<div style="display:none;">You did it!</div>

<script>
$( document ).ready(function() {
	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=get_lang", function ( lang ){
		if(lang == "en_us"){
			lang = "en";
		}
		languageurl = '/theme/symantec_lms/javascript/strings/'+lang+'/strings.js';
		console.log(languageurl);
		$.getJSON(languageurl).done(function(json){
			Strings = json;

			$('div.well input').bind('click', function(e){
				if($(this).hasClass('IsTrue')){
					$(this).siblings('.IsFalse').removeAttr('checked');
					learning_style.questions[$(this).parent().attr('id')].answer = "true";
					$(this).parent().css('border-color', 'green');
				}
				if($(this).hasClass('IsFalse')){
					$(this).siblings('.IsTrue').removeAttr('checked');
					learning_style.questions[$(this).parent().attr('id')].answer = "false";
					$(this).parent().css('border-color', 'green');
				}
			});

			$('#submit_assessment').click(function(e){
				calculateLearningStyle();
			});
		});
	});
});

var learning_style = {
	"scores": {
		"a": 0,
		"b": 0,
		"c": 0,
		"d": 0,
		"e": 0,
		"f": 0,
		"g": 0
	},
	"questions": {
		"1": {"type": "d", "answer":""},
		"2": {"type": "c", "answer":""},
		"3": {"type": "c", "answer":""},
		"4": {"type": "b", "answer":""},
		"5": {"type": "b", "answer":""},
		"6": {"type": "e", "answer":""},
		"7": {"type": "a", "answer":""},
		"8": {"type": "a", "answer":""},
		"9": {"type": "d", "answer":""},
		"10": {"type": "c", "answer":""},
		"11": {"type": "d", "answer":""},
		"12": {"type": "b", "answer":""},
		"13": {"type": "e", "answer":""},
		"14": {"type": "a", "answer":""},
		"15": {"type": "e", "answer":""},
		"16": {"type": "b", "answer":""},
		"17": {"type": "e", "answer":""},
		"18": {"type": "a", "answer":""},
		"19": {"type": "d", "answer":""},
		"20": {"type": "c", "answer":""},
		"21": {"type": "b", "answer":""},
		"22": {"type": "d", "answer":""},
		"23": {"type": "c", "answer":""},
		"24": {"type": "e", "answer":""},
		"25": {"type": "a", "answer":""},
		"26": {"type": "f", "answer":""},
		"27": {"type": "g", "answer":""},
		"28": {"type": "f", "answer":""},
		"29": {"type": "g", "answer":""},
		"30": {"type": "g", "answer":""}
	}
};

function calculateLearningStyle() {
	var errors = [];
	var score="";
	for(i=1; i <= 30; i++){
		if(learning_style.questions[i.toString()].answer != "true" && learning_style.questions[i.toString()].answer != "false"){
			errors.push(i);
		}
	}

	if(errors.length == 0){
		$('.well').hide();
		$('#submit_assessment').hide();

		for(a=1; a <= 30; a++){
			if(learning_style.questions[a].answer == "true"){
				if(learning_style.questions[a].type == "a"){
					learning_style.scores["a"] += 1;
				}
				else if(learning_style.questions[a].type == "b"){
					learning_style.scores["b"] += 1;
				}
				else if(learning_style.questions[a].type == "c"){
					learning_style.scores["c"] += 1;
				}
				else if(learning_style.questions[a].type == "d"){
					learning_style.scores["d"] += 1;
				}
				else if(learning_style.questions[a].type == "e"){
					learning_style.scores["e"] += 1;
				}
				else if(learning_style.questions[a].type == "f"){
					learning_style.scores["f"] += 1;
				}
				else if(learning_style.questions[a].type == "g"){
					learning_style.scores["g"] += 1;
				}
			}
		}

		$("#titlebar").show();

		if(learning_style.scores["a"] >= 4){
			//$("#type_a").show();
			score += "a";
		}
		if(learning_style.scores["b"] >= 4){
			//$("#type_b").show();
			score += "b";
		}
		if(learning_style.scores["c"] >= 4){
			//$("#type_c").show();
			score += "c";
		}
		if(learning_style.scores["d"] >= 4){
			//$("#type_d").show();
			score += "d";
		}
		if(learning_style.scores["e"] >= 4){
			//$("#type_e").show();
			score += "e";
		}
		if(learning_style.scores["f"] >= 1){
			//$("#type_f").show();
			score += "f";
		}
		if(learning_style.scores["g"] >= 1){
			//$("#type_g").show();
			score += "g";
		}

	window.location.assign('/theme/symantec_lms/pages/learning_styles.php?id=<?=$id?>&score='+score);
	}
	else {

		$('.well').hide();
		for(e=0; e <= errors.length; e++){
			$(document.getElementById(errors[e])).css('border-color', 'red').css('display','block');
		}
		$('.pageButton').hide();
		$('.tracker').hide();
		$('#page1').show();
		$('#page2').show();
		$('#page3').show();
		$('#page4').show();
		$('#page5').show();
		$('#page6').show();
		$('#errors').show();
		$(window).scrollTop(0);
	}

}

function paginate(e, page){
	$(e).parent().parent().parent().css('display', 'none');
	document.getElementById(page).style.display="block";
	$('.tracker').addClass('disabled');
	$('.'+page).removeClass('disabled');
}
</script>

<?php

}

echo $OUTPUT->footer();

$CON=null;

function getUserList(){
	global $USER, $SESSION, $CFG, $DB, $CON;

	if (gameConnectToDB() == false){
		return false;
	}
	$result = mysqli_query($CON, "SELECT firstname, lastname, id FROM `mdl_user` WHERE institution = '".$USER->institution."'");

	while( $row = mysqli_fetch_array($result) ){
		echo "<option value='".$row['id']."'>";
		echo $row['firstname'];
		echo " ";
		echo $row['lastname'];
		echo "</option>";
	}

	mysqli_close($CON);
	$CON=null;
}
?>
