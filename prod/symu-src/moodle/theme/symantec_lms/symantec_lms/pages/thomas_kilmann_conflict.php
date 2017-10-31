<?php

require_once('../../../config.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("Thomas-Kilmann Conflict");
$PAGE->set_heading("Thomas-Kilmann Conflict");
$PAGE->set_url($CFG->wwwroot.'/thomas_kilmann_conflict.php');


echo $OUTPUT->header(); ?>
<h1 id="titlebar" style="display:none;">Your conflict mode scores:</h1>
<div id="errors" class="well" style="display:none; color: red;">Please answer all questions.</div>
<div id="type_a" class="" style="display:none;">You scored <strong id="competing"></strong>in Competing.</div>
<div id="type_b" class="" style="display:none;">You scored <strong id="collaborating"></strong>in Collaborating.</div>
<div id="type_c" class="" style="display:none;">You scored <strong id="compromising"></strong>in Compromising.</div>
<div id="type_d" class="" style="display:none;">You scored <strong id="avoiding"></strong>in Avoiding.</div>
<div id="type_e" class="" style="display:none;">You scored <strong id="accommodating"></strong>in Accommodating.</div>
<div>
<div id="1" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />There are times when I let others take responsibility for solving the problem.<br />
		<input type="radio" class="isB" value="b" />Rather than negotiate the things on which we disagree, I try to stress the things upon which we both agree.
	</div>
<div id="2" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try to find a compromise situation.<br />
		<input type="radio" class="isB" value="b" />I attempt to deal with all of his and my concerns.
	</div>
<div id="3" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I am usually firm in pursuing my goals.<br />
		<input type="radio" class="isB" value="b" />I might try to soothe the other’s feelings and preserve our relationship.
	</div>
<div id="4" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try to find a compromise solution.<br />
		<input type="radio" class="isB" value="b" />I sometimes sacrifice my own wishes for the wishes of the other person.
	</div>
<div id="5" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I consistently seek the other’s help in working out a solution.<br />
		<input type="radio" class="isB" value="b" />I try to do what is necessary to avoid useless tensions.
	</div>
<div id="6" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try to avoid creating unpleasantness for myself.<br />
		<input type="radio" class="isB" value="b" />I try to win my position.
	</div>
<div id="7" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try to postpone the issue until I have had some time to think it over.<br />
		<input type="radio" class="isB" value="b" />I give up some points in exchange for others.
	</div>
<div id="8" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I am usually firm in pursuing my goals.<br />
		<input type="radio" class="isB" value="b" />I attempt to get all concerns and issues immediately out I the open.
	</div>
<div id="9" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I feel that differences are not always worth worrying about.<br />
		<input type="radio" class="isB" value="b" />I make some effort to get my way.
	</div>
<div id="10" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I am firm in pursuing my goals.<br />
		<input type="radio" class="isB" value="b" />I try to find a compromise solution.
	</div>
<div id="11" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I attempt to get all concerns and issues immediately out in the open.<br />
		<input type="radio" class="isB" value="b" />I might try to soothe the other’s feelings and preserve our relationship.
	</div>
<div id="12" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I sometimes avoid taking positions which would create controversy.<br />
		<input type="radio" class="isB" value="b" />I will let him have some of his positions if he lets me have some of mine. 
	</div>
<div id="13" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I propose a middle ground.<br />
		<input type="radio" class="isB" value="b" />I press to get my points made.
	</div>
<div id="14" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I tell him my ideas and ask him for his.<br />
		<input type="radio" class="isB" value="b" />I try to show him the logic and benefits of my position.
	</div>
<div id="15" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I might try to soothe the other’s feelings and preserve our relationship.<br />
		<input type="radio" class="isB" value="b" />I try to do what is necessary to avoid tensions.
	</div>
<div id="16" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try not to hurt the other’s feelings.<br />
		<input type="radio" class="isB" value="b" />I try to convince the other person of the merits of my position.
	</div>
<div id="17" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I am usually firm in pursuing my goals.<br />
		<input type="radio" class="isB" value="b" />I will let him have some of his positions if he lets me have some of mine.
	</div>
<div id="18" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />If it makes the other person happy, I might let him maintain his views.<br />
		<input type="radio" class="isB" value="b" />I will let him have some of his positions if he lets me have some of mine.
	</div>
<div id="19" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I attempt to get all concerns and issues immediately out in the open.<br />
		<input type="radio" class="isB" value="b" />I try to postpone the issue until I have had some time to think it over.
	</div>
<div id="20" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I attempt to immediately work through our differences.<br />
		<input type="radio" class="isB" value="b" />I try to find a fair combination of gains and losses for everyone.
	</div>
<div id="21" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />In approaching negotiations, I try to be considerate of the other person’s wishes.<br />
		<input type="radio" class="isB" value="b" />I always lean toward a direct discussion of the problem.
	</div>
<div id="22" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try to find a position that is intermediate between his and mine.<br />
		<input type="radio" class="isB" value="b" />I assert my wishes.
	</div>
<div id="23" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I am very often concerned with satisfying all our wishes.<br />
		<input type="radio" class="isB" value="b" />There are times when I let others take responsibility for solving the problem. 
	</div>
<div id="24" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />A If the other’s position seems very important to him, I would try to meet his wishes.<br />
		<input type="radio" class="isB" value="b" />I try to get him to settle for a compromise.
	</div>
<div id="25" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try to show him the logic and benefits of my position.<br />
		<input type="radio" class="isB" value="b" />In approaching negotiations, I try to be considerate of the other person’s wishes.
	</div>
<div id="26" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />A I propose a middle ground.<br />
		<input type="radio" class="isB" value="b" />I am nearly always concerned with satisfying all our wishes.
	</div>
<div id="27" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I sometimes avoid taking positions that would create controversy.<br />
		<input type="radio" class="isB" value="b" />If it makes the other person happy, I might let him maintain his views.
	</div>
<div id="28" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I am usually firm in pursuing my goals.<br />
		<input type="radio" class="isB" value="b" />I usually seek the other’s help in working out a solution.
	</div>
<div id="29" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I propose a middle ground.<br />
		<input type="radio" class="isB" value="b" />I feel that differences are not always worth worrying about.
	</div>
<div id="30" class="well" style="width:65%;">
		<input type="radio" class="isA" value="a" />I try not to hurt the other’s feelings.<br />
		<input type="radio" class="isB" value="b" />I always share the problem with the other person so that we can work it out. 
	</div>
	
	<center><a href="#" id="submit_assessment" class="btn btn-warning" role="button" style="margin-bottom:100px;">Determine Learning Style</a></center>
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
				if($(this).hasClass('isA')){
					$(this).siblings('.isB').removeAttr('checked');
					learning_style.questions[$(this).parent().attr('id')].answer = "a";
					$(this).parent().css('border-color', 'green');
				}
				if($(this).hasClass('isB')){
					$(this).siblings('.isA').removeAttr('checked');
					learning_style.questions[$(this).parent().attr('id')].answer = "b";
					$(this).parent().css('border-color', 'green');
				}
			});
			
			$('#submit_assessment').click(function(e){
				e.preventDefault();
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
		"e": 0
	},
	"questions": {
		"1": {"a": "d", "b": "e", "answer":""},
		"2": {"a": "c", "b": "b", "answer":""},
		"3": {"a": "a", "b": "e", "answer":""},
		"4": {"a": "c", "b": "e", "answer":""},
		"5": {"a": "b", "b": "d", "answer":""},
		"6": {"a": "d", "b": "a", "answer":""},
		"7": {"a": "d", "b": "c", "answer":""},
		"8": {"a": "a", "b": "b", "answer":""},
		"9": {"a": "d", "b": "a", "answer":""},
		"10": {"a": "a", "b": "c", "answer":""},
		"11": {"a": "b", "b": "e", "answer":""},
		"12": {"a": "d", "b": "c", "answer":""},
		"13": {"a": "c", "b": "a", "answer":""},
		"14": {"a": "b", "b": "a", "answer":""},
		"15": {"a": "e", "b": "d", "answer":""},
		"16": {"a": "e", "b": "b", "answer":""},
		"17": {"a": "a", "b": "d", "answer":""},
		"18": {"a": "e", "b": "c", "answer":""},
		"19": {"a": "b", "b": "d", "answer":""},
		"20": {"a": "b", "b": "c", "answer":""},
		"21": {"a": "e", "b": "b", "answer":""},
		"22": {"a": "c", "b": "a", "answer":""},
		"23": {"a": "b", "b": "d", "answer":""},
		"24": {"a": "e", "b": "c", "answer":""},
		"25": {"a": "a", "b": "e", "answer":""},
		"26": {"a": "c", "b": "b", "answer":""},
		"27": {"a": "d", "b": "e", "answer":""},
		"28": {"a": "a", "b": "b", "answer":""},
		"29": {"a": "c", "b": "d", "answer":""},
		"30": {"a": "e", "b": "b", "answer":""}
	}
};

function calculateLearningStyle() {
	var errors = [];
	var score="";
	for(i=1; i <= 30; i++){
		if(learning_style.questions[i.toString()].answer != "a" && learning_style.questions[i.toString()].answer != "b"){
			errors.push(i);
		}
	}
	
	if(errors.length == 0){
		$('.well').hide();
		$('#submit_assessment').hide();
		
		for(j=1; j <= 30; j++){
			if(learning_style.questions[j].answer == "a"){
				if(learning_style.questions[j].a == "a"){
					learning_style.scores["a"] += 1;
				}
				else if(learning_style.questions[j].a == "b"){
					learning_style.scores["b"] += 1;
				}
				else if(learning_style.questions[j].a == "c"){
					learning_style.scores["c"] += 1;
				}
				else if(learning_style.questions[j].a == "d"){
					learning_style.scores["d"] += 1;
				}
				else if(learning_style.questions[j].a == "e"){
					learning_style.scores["e"] += 1;
				}
			}
			if(learning_style.questions[j].answer == "b"){
				if(learning_style.questions[j].a == "a"){
					learning_style.scores["a"] += 1;
				}
				else if(learning_style.questions[j].b == "b"){
					learning_style.scores["b"] += 1;
				}
				else if(learning_style.questions[j].b == "c"){
					learning_style.scores["c"] += 1;
				}
				else if(learning_style.questions[j].b == "d"){
					learning_style.scores["d"] += 1;
				}
				else if(learning_style.questions[j].b == "e"){
					learning_style.scores["e"] += 1;
				}
			}
		}
		
		$("#titlebar").show();
			$("#type_a").show();
			$("#competing").text(learning_style.scores["a"]+"/12")
			$("#type_b").show();
			$("#collaborating").text(learning_style.scores["b"]+"/12")
			$("#type_c").show();
			$("#compromising").text(learning_style.scores["c"]+"/12")
			$("#type_d").show();
			$("#avoiding").text(learning_style.scores["d"]+"/12")
			$("#type_e").show();
			$("#accommodating").text(learning_style.scores["e"]+"/12")

	SendAJAX("/theme/symantec_lms/pages/learning_styles.php?id=<?=$id?>&score="+score);
	}
	else {
		$('.well').hide();
		for(e=0; e <= errors.length; e++){
			$(document.getElementById(errors[e])).css('border-color', 'red').css('display','block');
		}
		$('#errors').show();
		$(window).scrollTop(0);
	}
	
}
</script>

<?php
echo $OUTPUT->footer();
?>