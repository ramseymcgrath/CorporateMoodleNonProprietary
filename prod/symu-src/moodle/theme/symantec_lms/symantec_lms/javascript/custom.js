
//Global variable to store logged in user name to retrieve full name
var loggedInUser="";
var courseId = 0;
var Strings;
var USERID = $('input[name=userid]').val();
var SESSIONID = $('input[name=sessionid]').val();
var language = "";


function getLanguageStrings(){

}

function SendAJAX( phpRequest, doneFunction ){
	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			if (doneFunction){
				doneFunction(xmlhttp.responseText);
			}
		}
	}

	xmlhttp.open("GET", phpRequest, true);
	xmlhttp.send();
}

$.fn.redraw = function(){
  $(this).each(function(){
    var redraw = this.offsetHeight;
  });
};

$( document ).ready(function() {
	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=get_lang", function ( lang ){
		if(lang == "en_us"){
			lang = "en";
		}
		languageurl = '/theme/symantec_lms/javascript/strings/'+lang+'/strings.js';
		console.log(languageurl);
		$.getJSON(languageurl).done(function(json){
			Strings = json;


	if( courseId == 0 ){
		var classList = $('body')[0].className.split(/\s+/);
		for (var i = 0; i < classList.length; i++) {
			if (classList[i].indexOf('course-') > -1 ) {
				courseId = classList[i].split('-')[1];
			}
		}
	}

//checks course to determine if it is the superhero course from the theme config
	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=superhero_course", function ( f ){
		superHeroCourse = f;
		if ($('body:first').is('.course-'+superHeroCourse)){
			$('.theme').addClass('superhero');
		}
	});
//checks course to determine if it is the pirate course from the theme config
	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=pirate_course", function ( f ){
		pirateCourse = f;
		if ($('body:first').is('.course-'+pirateCourse)){
			$('.theme').addClass('pirate');
		}
	});
//checks course to determine if it is the wizard course from the theme config
	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=wizard_course", function ( f ){
		wizardCourse = f;
		if ($('body:first').is('.course-'+wizardCourse)){
			$('.theme').addClass('wizard');
		}
	});

//opens images in new window, if they match the class "inwindow"
	$('img.inwindow').on('click', function( event ){
		event.preventDefault();
		window.open(this.src,  null, 'height=' + this.naturalHeight + ', width=' + this.naturalWidth + ', toolbar=0, location=0, status=0, scrollbars=0, resizable=0');
	});
//opens backpack
	$('div.t-case').on('click', function(){
		toggleBP();
	});


	$('#symu-backpack-agentRewards > div > button').click( function(e){
		$('#backpack').removeClass('bp_on').addClass('bp_off');
		$('div.bpoverlay').hide();
	});

	if ( typeof($('div.dropdown a[href="/login"]')[0])=='object' ){
		$.removeCookie('BVSDKdip',{path:'/',domain:'symantec.com'});
	}

	//move the notification block out of the hidden menu
	var theDiv = $('div.modal').clone();

	if (theDiv != undefined){
		$('div.modal').remove();
		$(document.body).append(theDiv);
	}

	if ($.QueryString["symu"]=="start" || $.cookie('symu') == "start" ){
		$('fieldset.collapsed').removeClass('collapsed');
		highlightAndShowTip(introArray1);
	}

	$('input#id_submitbutton[value="Post to forum"]').click(function (e){
		//var agentId = $.cookie('BVSDKdip');
	});

	$('div.loginform input#loginbtn').click( function (event){
		var uname = $('div.loginform input#username').val();
		loggedInUser = uname;
	});

	$('#block-region-side-pre').prepend('<span id="menu_collapse" class="lms-menu-toggle">&laquo;</span>');
	//$('#menu_collapse').addClass('span4');
	applyMenuHeight();
	$(window).resize(function() {
	  applyMenuHeight();
	});
	$('.lms-menu-toggle').click(function(){
		if ($('#region-main').hasClass('span10')){
			$('#lms-small-menu').hide();
			$('#region-main').removeClass('span10').addClass('span7');
			$('#block-region-side-pre').removeClass('span1').addClass('span4');
			$('#block-region-side-pre').show();
			$('aside.span4').css({'height':$('aside.span4').innerHeight()+2+'px'});
			applyMenuHeight();
			$.cookie('menu','open',{path:'/',domain:'symantec.com'});
		}
		else if($('#region-main').hasClass('span7')){
			$('aside.span4').css({'height':$('aside.span4').innerHeight()-2+'px'});
			$('#block-region-side-pre').hide();
			$('#lms-small-menu').show();
			$('#region-main').removeClass('span7').addClass('span10');
			$('#block-region-side-pre').removeClass('span4').addClass('span1');
			applyMenuHeight();
			$.cookie('menu','closed',{path:'/',domain:'symantec.com'});
		}
	});
	if($.cookie('menu') == null && !$('#region-main').hasClass('span12') && !$('body').hasClass('pagelayout-base')){
		$('#lms-small-menu').hide();
		$('#region-main').removeClass('span10').addClass('span7');
		$('#block-region-side-pre').removeClass('span1').addClass('span4');
		$('#block-region-side-pre').show();
		$.cookie('menu','open',{path:'/',domain:'symantec.com'});
	}
	if($.cookie('menu') == "open" && !$('#region-main').hasClass('span12') && !$('body').hasClass('pagelayout-base')){
		$('#lms-small-menu').hide();
		$('#region-main').removeClass('span10').addClass('span7');
		$('#block-region-side-pre').removeClass('span1').addClass('span4');
		$('#block-region-side-pre').show();
		$.cookie('menu','open',{path:'/',domain:'symantec.com'});
	}
	if($.cookie('menu') == "closed" || $('#region-main').hasClass('span12') && !$('body').hasClass('pagelayout-base')){
		$('#block-region-side-pre').hide();
		if( !$('#region-main').hasClass('span12') ){
			$('#region-main').removeClass('span7').addClass('span10');
			$('#lms-small-menu').show();
			$('aside.span4').css({'height':$('aside.span4').innerHeight()+2+'px'});
		}
	}

	$('ul.nav.navbar-nav.lms-nav-list li a').hover(function(){
		$(this).parent().addClass('active');
	}, function(){
		$(this).parent().removeClass('active');
	});
	$('ul.nav.navbar-nav.lms-nav-list li.active a').unbind();

	$('.trophycase-icon').addClass("t-case-icon-pointer");

	//LMS-720 "Back to course" button on lessons
	if(window.location.href.indexOf("mod/quiz/view.php") > -1) {
       var courseid;
	   $('div.singlebutton.quizstartbuttondiv form div').append('<input id="course-home-button" type="button" value="Back to Course">');
		var classList = $('body')[0].className.split(/\s+/);
		for (var i = 0; i < classList.length; i++) {
			if (classList[i].indexOf('course-') > -1 ) {
				courseid = classList[i].split('-')[1];
			}
		}
		 $('#course-home-button').bind('click', function(){
			window.location = '/course/view.php?id='+courseid;
		});
    }
	//LMS-1439 "Back to forum" button on posts
		if(window.location.href.indexOf("mod/forum/discuss.php") > -1) {
       var forumid;
	   $('div.discussioncontrol.nullcontrol').append('<input id="forum-home-button" type="button" value="Back to Forum">');
		var classList = $('body')[0].className.split(/\s+/);
		for (var i = 0; i < classList.length; i++) {
			if (classList[i].indexOf('cmid-') > -1 ) {
				forumid = classList[i].split('-')[1];
			}
		}
		 $('#forum-home-button').bind('click', function(){
			window.location = '/mod/forum/view.php?id='+forumid;
		});
    }

	//LMS-1438 "Back to course" button on checklists
		if(window.location.href.indexOf("/mod/checklist/view.php") > -1) {
       var courseid;
	   $('div.box.checklistbox').append('<input id="course-home-button" type="button" style="margin-top: 25px;" value="Back to Course">');
		var classList = $('body')[0].className.split(/\s+/);
		for (var i = 0; i < classList.length; i++) {
			if (classList[i].indexOf('course-') > -1 ) {
				courseid = classList[i].split('-')[1];
			}
		}
		 $('#course-home-button').bind('click', function(){
			window.location = '/course/view.php?id='+courseid;
		});
    }

	$("body").click( function(event){
		if (event.target.id == "close-notify"){
			var overlayEl = $("#notify-overlay");
			overlayEl.hide();
			overlayEl.detach();
			var notifyDlg = $("#symu-badge-notify");
			notifyDlg.hide();
			notifyDlg.detach();
		}
	});

	if(typeof Strings == 'undefined'){
		$.getJSON(languageurl).done(function(json){
			Strings = json;
			doBackpack( USERID, courseId );
			buildUserMenu();
		});
	}else{
		doBackpack( USERID, courseId );
		buildUserMenu();
	};

	//menu localization
	$("#lms_home_icon").html(Strings['leftsidenavigation_hometext']);
	$("#lms_courses_icon").html(Strings['leftsidenavigation_coursestext']);
	$("#lms_smbt_icon").html(Strings['leftsidenavigation_smbttext']);
	$("#lms_glossary_icon").html(Strings['leftsidenavigation_glossarytext']);
	$("#lms_game_icon").html(Strings['leftsidenavigation_gametext']);
	$("#lms_feedback_icon").html(Strings['leftsidenavigation_feedbacktext']);
	$("#leaderboard_title").html(Strings['gameStats_leaderTab']);
	$("#ladder_title").html(Strings['gameStats_ladderTab']);

	$('#sfdc_login_btn').html(Strings['sfdc_loginButton']);
	$('#sfdc_login_text').html(Strings['sfdc_loginText']);
	$('#sam_login_btn').html(Strings['sam_loginButton']);
	$('#sam_login_text').html(Strings['sam_loginText']);
	$('#login_header').html(Strings['login_heading']);
	$('#login_text').html(Strings['login_text']);

	checkNotification();

	//notification_API
	if(window.location.href.indexOf("/course/") > -1) {
		SendAJAX("/local/notification_api/lib/ajax_interface_lib.php?f=getUserSubscriptions", function ( subscriptions ){
			var subs = JSON.parse(subscriptions);
			$("h3.categoryname").each(function(i){
				var subscribed = false;
				var catID = parseQueryString(this.firstChild.href).categoryid;
				for(var i = 0; i < subs.length; i++){
					if(subs[i] == String(catID)){
						subscribed = true;
					}
				}
				if(subscribed == true){//subscription does not exist
				$(this).append('<input class="unsub" type="submit" value="'+Strings['notification_unsubscribe']+'" style="float: right" onclick="unsubscribeToCategory('+catID+')" title="'+Strings['notification_unsubscribe_title']+'">');
				}
				else{
				$(this).append('<input class="sub" type="submit" value="'+Strings['notification_subscribe']+'" style="float: right" onclick="subscribeToCategory('+catID+')" title="'+Strings['notification_subscribe_title']+'">');
				}
			});
			$("h3").bind("DOMSubtreeModified", function() {
				$("h4.categoryname").each(function(i){
					if(!$(this).hasClass("hasbtn")){
						$(this).css('line-height','30px');
						var subcategorySubscribed = false;
						var catID = parseQueryString(this.firstChild.href).categoryid;
						for(var i = 0; i < subs.length; i++){
							if(subs[i] == String(catID)){
								subcategorySubscribed = true;
							}
						}
						if(subcategorySubscribed == true){//subscription does not exist
						$(this).append('<input class="unsub" type="submit" value="'+Strings['notification_unsubscribe']+'" style="float: right" onclick="unsubscribeToCategory('+catID+')" title="'+Strings['notification_unsubscribe_title']+'">');
						$(this).addClass('hasbtn');
						}
						else{
						$(this).append('<input class="sub" type="submit" value="'+Strings['notification_subscribe']+'" style="float: right" onclick="subscribeToCategory('+catID+')" title="'+Strings['notification_subscribe_title']+'">');
						$(this).addClass('hasbtn');
						}
					}
				});
			});
		});
	};

	//image captions
	$('.image-caption').each(function(){
		var floatVal = $(this).find('img').css('float')
		$(this).css('float', floatVal);
	});
	$('.caption-container').each(function(){
		var floatVal = $(this).find('img').css('float')
		$(this).css('float', floatVal);
	});

	//Twistee
	$('div.twistee').on('click', function(){
		if($(this).find('div.twistee_content').hasClass('open')){
			$(this).find('div.twistee_content').removeClass('open');
		}
		else{
			$(this).find('div.twistee_content').addClass('open');
		}
	});

	$('.theme.lightbox').featherlight({targetAttr:'src',contentFilter:'image'});

    console.log( "ready!" );
			});
	});
});

function subscribeToCategory(catID){
	SendAJAX("/local/notification_api/lib/ajax_interface_lib.php?f=subscribeUserToCategory&catID="+catID, function ( lang ){
	window.location = '/course/index.php';
	});
}

function unsubscribeToCategory(catID){
	SendAJAX("/local/notification_api/lib/ajax_interface_lib.php?f=unsubscribeUserToCategory&catID="+catID, function ( lang ){
	window.location = '/course/index.php';
	});
}

function notifyPoints(points){//localized
	$('body').append('<div id="notify-overlay" class="symu-badge-notify-overlay" style="display: block;"></div>\
	<div class="symu-badge-notify" id="symu-badge-notify">\
		<div class="symu-badge-notify-container">\
				<div class="symu-badge-details" style="position: initial; top: 0px;">\
					<h1>'+Strings['notifyPoints_title']+'</h1>\
					<h4>'+Strings['notifyPoints_message'].replace('{%}', points)+'</h4>\
				</div>\
				<button id="close-notify">'+Strings['notifyPoints_buttontext']+'</button>\
		</div>\
	<div>');
}

function notifyMaxPointsFeedbackCourse(){//localized
	$('body').append('<div id="notify-overlay" class="symu-badge-notify-overlay" style="display: block;"></div>\
	<div class="symu-badge-notify" id="symu-badge-notify">\
		<div class="symu-badge-notify-container">\
				<div class="symu-badge-details" style="position: initial; top: 0px;">\
					<h1>'+Strings['notifyMaxPointsFeedbackCourse_title']+'</h1>\
					<h4>'+Strings['notifyMaxPointsFeedbackCourse_message']+'</h4>\
				</div>\
				<button id="close-notify">'+Strings['notifyMaxPointsFeedbackCourse_buttontext']+'</button>\
		</div>\
	<div>');
}

function notifyMaxPointsFeedback(){//localized
	$('body').append('<div id="notify-overlay" class="symu-badge-notify-overlay" style="display: block;"></div>\
	<div class="symu-badge-notify" id="symu-badge-notify">\
		<div class="symu-badge-notify-container">\
				<div class="symu-badge-details" style="position: initial; top: 0px;">\
					<h1>'+Strings['notifyMaxPointsFeedback_title']+'</h1>\
					<h4>'+Strings['notifyMaxPointsFeedback_message']+'</h4>\
				</div>\
				<button id="close-notify">'+Strings['notifyMaxPointsFeedback_buttontext']+'</button>\
		</div>\
	<div>');
}

function notifyQuizOneHundredPercent(points){//localized
	$('body').append('<div id="notify-overlay" class="symu-badge-notify-overlay" style="display: block;"></div>\
	<div class="symu-badge-notify" id="symu-badge-notify">\
		<div class="symu-badge-notify-container">\
				<div class="symu-badge-details" style="position: initial; top: 0px;">\
					<h1>'+Strings['notifyQuizOneHundredPercent_title']+'</h1>\
					<h4>'+Strings['notifyQuizOneHundredPercent_message'].replace('{%}', points)+'</h4>\
				</div>\
				<button id="close-notify">'+Strings['notifyQuizOneHundredPercent_buttontext']+'</button>\
		</div>\
	<div>');
}

function toggleBP(){
	if ($('#backpack').hasClass('bp_off')){
		$('#backpack').removeClass('bp_off').addClass('bp_on');
		$('div.bpoverlay').show();
	}
	else if ($('#backpack').hasClass('bp_on')){
			$('#backpack').removeClass('bp_on').addClass('bp_off');
			$('div.bpoverlay').hide();
		}
	else {
		return;
	}
}

function checkNotification () {//localized
	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=checknotify", function (notificationParamJSON){
		var notificationParam = (JSON && JSON.parse(notificationParamJSON));
		if (notificationParam.quiz == "true" && notificationParam.notify == "true"){
			//notifyQuizOneHundredPercent(notificationParam.points);
			return;
		}
		if (notificationParam.notify == "true"){
			$('body').append('<div id="notify-overlay" class="symu-badge-notify-overlay" style="display: block;">\
			</div><div class="symu-badge-notify" id="symu-badge-notify"><div class="symu-badge-notify-container">\
			<img class="symu-badge-reward-starburst" src="/theme/symantec_lms/pix/starburst.png"><img class="symu-badge-picture" src="'+
			notificationParam.badge.image+'"><div class="symu-badge-details"><h1>'+Strings['checkNotification_title']+'</h1><h4>'+notificationParam.points+' '+Strings['checkNotification_message']+'</h4><div class="symu-badge-name">'+notificationParam.badge.badgeName+'</div><div class="symu-badge-desc">'+
			notificationParam.badge.description+'</div></div><button id="close-notify">OK</button></div></div>');
			return;
		}
	});
}

function doBackpack(userid, course_id){//localized
	var badgeArray;
	var courseArray;
	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=get_every_badge", function(e){
		badgeArray = (JSON && JSON.parse(e));

		SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=get_all_users_courses", function(f){
			courseArray = (JSON && JSON.parse(f));

			var theBackpack = '<div class="bpheader"><div class="bpheadertext">'+Strings['doBackpack_title']+'</div></div><div class="bpbody" ><div class="bpbodyScroller">';
			var otherBadges = '<div class="otherbadges"><span class="othercoursenamelabel">'+Strings['doBackpack_othertext']+'</span><div class="otherinnercoursebadgecontainer">';
			var lastPrimary = 0;
			$.each(badgeArray, function(i, v){
				if($.inArray(badgeArray[i].courseid, courseArray) == -1){

				}
				else if(badgeArray[i].primary == true){
					theBackpack +='	<div class="courseBadgeRow"><span class="coursenamelabel">'+badgeArray[i].coursename+'</span>';
					theBackpack +='	<div class="primaryBadge"><span class="hovertip"  title="'+badgeArray[i].description+'"><img class="pimary-badge hovertip '+isEarned(badgeArray[i].isearned)+'" src="'+badgeArray[i].image+'" data-badge-name="'+badgeArray[i].badgeName+'" /></span></div><div class="outercoursebadgecontainer"><div class="innercoursebadgecontainer">';
					var tempArray =[];
					$.each(badgeArray, function(j, v){
						if(badgeArray[j].courseid == badgeArray[i].courseid && badgeArray[j].primary == false){
							tempArray.unshift(badgeArray[j]);
						}
					});
					tempArray.sort(orderByDate);
					$.each(tempArray, function(j, v){
						theBackpack +='<span class="hovertip"  title="'+tempArray[j].description+'"><img class="innerbadges '+isEarned(tempArray[j].isearned)+'" src="'+tempArray[j].image+'" data-badge-name="'+tempArray[j].badgeName+'" /></span>';
					});
					theBackpack +='</div></div></div>';
					lastPrimary = badgeArray[i].courseid;
				}
				else if(badgeArray[i].courseid == lastPrimary){

				}
				else{
					otherBadges +='<span class="hovertip"  title="'+badgeArray[i].description+'"><img class="innerbadges '+isEarned(badgeArray[i].isearned)+'" src="'+badgeArray[i].image+'" data-badge-name="'+badgeArray[i].badgeName+'" /></span>';
				}
			});

			theBackpack += otherBadges;
			theBackpack +='	</div></div>';
			theBackpack += '</div><div class="symu-backpack-rewards-overlay"></div></div><div><button id="closeBPButton" style="margin-top: -39px; float: right;" onclick="toggleBP()">'+Strings['doBackpack_buttontext']+'</button></div>';

			$('#symu-backpack-agentRewards').html(theBackpack);

			$(document).ready(function(){
				$('.hovertip').tooltip();
			});

			$(".not-earned").attr('src', '/theme/symantec_lms/pix/defaultbadge.png');
		});
	});
}

function isEarned(state){
	if (state == "true"){
		return "earned";
	}
	else {
		return "not-earned";
	}
}

function orderByDate(a,b){
	if (a.date < b.date)
		return 1;
	if (a.date > b.date)
		return -1;
	return 0;
}

function doLadder(limit, course, userid, workcenter, showall){//localized
	var ajaxtarget = "/local/game_api/lib/ajax_interface_lib.php?f=get_ladder&limit="+limit+"&course="+course+"&workcenter="+workcenter+"&showall="+showall;
	SendAJAX(ajaxtarget, function (e){
		playerArray = (JSON && JSON.parse(e));
		var index;
		var currentWorkcenter = workcenter;
		$.each(playerArray, function(i, v){
			if(playerArray[i].id == userid){
				index = i;
			}
		});
		if (playerArray.length > 10){
			firstThree= playerArray.slice(0, 3);

			ladder = playerArray.slice((index-3), (index+4));

			playerArray = $.merge(firstThree, ladder);
		}
		outputString = '<table class="table table-striped"><tr><th>'+Strings['doLadder_rankheader']+'</th><th>'+Strings['doLadder_avatarheader']+'</th><th>'+Strings['doLadder_nameheader']+'</th><th>'+Strings['doLadder_badgesheader']+'</th><th>'+Strings['doLadder_pointsheader']+'</th></tr>';
		for(var i=0; i<playerArray.length; i++){
			if(playerArray[i].workcenter == currentWorkcenter){
				outputString +=
					"<tr"+currentUser(playerArray[i].id, userid)+"><td><h3>"+playerArray[i].rank+".</h3></td>"+
						"<td><img class='leaderboardImage' src='/user/pix.php/"+playerArray[i].id+"/f1.jpg' /></td>"+
						"<td>"+playerArray[i].firstname+" "+playerArray[i].lastname+"</td>"+
						"<td>"+playerArray[i].badges+"</td>"+
						"<td>"+playerArray[i].points+"</td>"+
					"</tr>";
			}
			else{
				outputString +=
					"<tr"+currentUser(playerArray[i].id, userid)+"><td><h3>"+playerArray[i].rank+".</h3></td>"+
						"<td><img class='leaderboardImage' src='/theme/symantec_lms/pix/defaultavatar.png' /></td>"+
						"<td>"+playerArray[i].workcenter+" team member</td>"+
						"<td>"+playerArray[i].badges+"</td>"+
						"<td>"+playerArray[i].points+"</td>"+
					"</tr>";
			}
			if (i == 2){
				outputString +="<tr><td colspan='5'><div class='text-center'><h1>...</h1></div></td></tr>";
			}
		}
		outputString += "</table>";
		$("#ladder-pane").html(outputString);
	});
}

function doLeader(limit, course, userid, workcenter, showall){//localized
	var ajaxtarget = "/local/game_api/lib/ajax_interface_lib.php?f=get_leader&limit="+limit+"&course="+course+"&workcenter="+workcenter+"&showall="+showall;
	SendAJAX(ajaxtarget, function (e){
		playerArray = (JSON && JSON.parse(e));
		var index;
		var currentWorkcenter = workcenter;
		$.each(playerArray, function(i, v){
			if(playerArray[i].id == userid){
				index = i;
			}
		});
		outputString = '<table class="table table-striped"><tr><th>'+Strings['doLeader_rankheader']+'</th><th>'+Strings['doLeader_avatarheader']+'</th><th>'+Strings['doLeader_nameheader']+'</th><th>'+Strings['doLeader_badgesheader']+'</th><th>'+Strings['doLeader_pointsheader']+'</th></tr>';
		for(var i=0; i<playerArray.length; i++){
			if(playerArray[i].workcenter == currentWorkcenter){
				outputString +=
					"<tr"+currentUser(playerArray[i].id, userid)+"><td><h3>"+playerArray[i].rank+".</h3></td>"+
						"<td><img class='leaderboardImage' src='/user/pix.php/"+playerArray[i].id+"/f1.jpg' /></td>"+
						"<td>"+playerArray[i].firstname+" "+playerArray[i].lastname+"</td>"+
						"<td>"+playerArray[i].badges+"</td>"+
						"<td>"+playerArray[i].points+"</td>"+
					"</tr>";
			}
			else{
				outputString +=
					"<tr"+currentUser(playerArray[i].id, userid)+"><td><h3>"+playerArray[i].rank+".</h3></td>"+
						"<td><img class='leaderboardImage' src='/theme/symantec_lms/pix/defaultavatar.png' /></td>"+
						"<td>"+playerArray[i].workcenter+" team member</td>"+
						"<td>"+playerArray[i].badges+"</td>"+
						"<td>"+playerArray[i].points+"</td>"+
					"</tr>";
			}
		}
		outputString += "</table>";
		$("#leader-pane").html(outputString);
	});
}

function doSelector(userid, e){
	selctorArray = (JSON && JSON.parse(e));
	outputString = "<select>";
	for(var i=0; i<selctorArray.length; i++){
		outputString += "<option value=\""+selctorArray[i].id+"\">";
		outputString += selctorArray[i].name;
		outputString += "</option>";
	}
	outputString += "</select>";
	$("#selector-pane").html(outputString);
}

function ladderButton(){
	var course = $("#course_selector option:selected").val();
	var userid = $("#user_selector").val().toNum();
	doLadder(10, course, userid);
}

function currentUser(id, match){
	if(id == match)
		return " class='warning'";
	else
		return "";
}

function doSyllabus( course_id ){
	if (course_id == 0){
		var classList = $('body')[0].className.split(/\s+/);
		for (var i = 0; i < classList.length; i++) {
			if (classList[i].indexOf('course-') > -1 ) {
				course_id = classList[i].split('-')[1];
			}
		}
	}

	SendAJAX("/local/game_api/lib/ajax_interface_lib.php?f=course_badges&course_id="+course_id, function (syllabusParam){
		var badgesArray = JSON && JSON.parse(syllabusParam);

		var theSyllabus = '<div id="symu-badge-courseSyllabus" class="symu-badge-courseSyllabus">\
		<div class="symu-badge-body symu-badge-col" ><div class="symu-badge-cards symu-badge-col" >';

		for(var i=0; i <= badgesArray.length;i++){
			var tempObj = badgesArray[i];
			if (tempObj != undefined){
				var theImage = tempObj.image;
				var theClass = "symu-badge-card symu-badge-grey";
				if (tempObj.earned == 1){
					theClass = "symu-badge-card";
				}
				theSyllabus+='<div class="'+theClass+'" ><div class="symu-badge-picture-container">\
					<img class="symu-badge-picture" src="'+theImage+'"></div><div class="symu-badge-details"><div class="symu-badge-name">'+tempObj.badgeName+
					'</div><div class="bubble" ><p>' + tempObj.description+'</p></div></div></div>';
			}
		}
		theSyllabus+='</div></div></div>';
		$('#symu-syllabus').html(theSyllabus);

		//this is where we show the informational bubble popup
		var balloonShowing=false;
		var theBalloon = null;
		$('img.symu-badge-picture').mouseenter(function(event) {
			event.preventDefault();
			if (balloonShowing == true){
				return;
			}
			balloonShowing = true;
			var E = event.target;
			var eLeft = $(E).offset().left;
			var eTop = $(E).offset().top;
			theBalloon = $(E.parentElement.nextElementSibling).find('.bubble');
			var mousePosX = ((eLeft+(E.width/2))-(theBalloon.width()/2)), mousePosY = eTop+E.height + 5;
			theBalloon.css({top:mousePosY, left:mousePosX});
			theBalloon.show();
		}).mouseleave(function(event) {
			event.preventDefault();
			theBalloon.hide();
			balloonShowing=false;
			theBalloon = null;
		});
	});
}

(function($) {
    $.QueryString = (function(a) {
        if (a == "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i)
        {
            var p=a[i].split('=');
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split('&'))
})(jQuery);

var applyMenuHeight = function() {
  var height = $(window).height()-88;
  $("#lms-small-menu").height(height);
  $("#block-region-side-pre").height(height);
};

function gup( name, url ) {
  if (!url) url = location.href
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( url );
  return results == null ? null : results[1];
}

String.prototype.toNum = function(){
    return parseInt(this, 10);
}

function badgeAward (badgeID, userID, courseID){
	if(isPrimaryBadge(badgeID)){
		SendAJAX("/local/game_api/game.php?action=boost&user="+userID+"&auth_key=12345&course="+courseID, function ( data ){

		});
	}
}

function buildUserMenu(){
	var menuHTML = '<li role="presentation"><a role="menuitem" tabindex="-1" href="/user/profile.php?='+USERID+'">'+Strings['layoutDropdown_profiletext']+'</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="/user/preferences.php">'+Strings['layoutDropdown_preferencestext']+'</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="/theme/symantec_lms/pages/learning_styles.php">'+Strings['layoutDropdown_learningtext']+'</a></li><li role="presentation"><a role="menuitem" tabindex="-1" href="/login/logout.php?sesskey='+SESSIONID+'">'+Strings['layoutDropdown_logouttext']+'</a></li>';
	$('#usermenu').html(menuHTML);
}

function parseQueryString(qstr) {
	var query = {};
	var a = qstr.substr(1).split('?');
	for (var i = 0; i < a.length; i++){
		var b = a[i].split('=');
		query[decodeURIComponent(b[0])] = decodeURIComponent(b[1] || '');
	}
	return query;
}


//replace JIRA feedback collector
function showFeedbackModal(userEmail){

	subject = "";
	summary = "";
	url = window.location.href ;

	html = '<div id="notify-overlay" class="symu-badge-notify-overlay" style="z-index: 4;"></div>\
	<div id="myModal" class="modal fade in" role="dialog" style="display:none">\
	<div class="modal-dialog">\
		<div class="modal-content">\
			<div class="modal-header">\
				<button type="button" class="close" data-dismiss="modal" onclick="removeModal()">&times;</button>\
				<h4 class="modal-title">'+Strings['feedback_title']+'</h4></div>\
			<div class="modal-body">\
				<p>'+Strings['feedback_text']+'</p>\
				<p>\
					<label for="summary">'+Strings['feedback_summary_title']+'</label>\
					<input type="text" id="summary">\
					<label for="description">'+Strings['feedback_description_title']+'</label>\
					<textarea style="width:95%;height:160px;" id="description"></textarea>\
				</p>\
			</div>\
			<div class="modal-footer">\
				<button type="button" class="btn btn-default" data-dismiss="modal" id="register" onclick="JIRAFeedbackSubmit(\
				\''+userEmail+'\', \
				);" disabled>'+Strings['feedback_submit_btn']+'</button>\
			</div>\
		</div>\
	</div>\
</div>';
	$('body').append(html);
	$('#myModal, #notify-overlay').fadeIn(400, 'linear');
	$('.modal-dialog input, .modal-dialog textarea').keyup(function() {
        var empty = false;
        $('.modal-dialog input, .modal-dialog textarea').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });

        if (empty) {
            $('#register').attr('disabled', 'disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
        } else {
            $('#register').removeAttr('disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
        }
    });
}

function removeModal(){
	$('#myModal, #notify-overlay').fadeOut(400, function(){$('#myModal, #notify-overlay').remove();});
}
var JIRAFeedbackSubmit = function(user_email) {

	var summary = $('#summary').val();

	var description = $('#description').val();

	var ticketDescription = "User: " + user_email + " Comment: "+description;

    var postData =
                {
                    "summary":summary,
                    "description":ticketDescription
                }
    var dataString = JSON.stringify(postData);

	$('#register').attr('disabled', 'disabled')

    $.ajax({
            type: "POST",
            url: "/theme/symantec_lms/pages/createIssue.php",
            data: dataString,
            contentType: "application/json; charset=utf-8",
            success: function(data){
            	if(data.indexOf("id") > -1){
					$('#myModal, #notify-overlay').remove();
					SendAJAX("/local/game_api/game.php?action=feedbackReward&user=0&auth_key=12345&course="+getPageCourseID(), function ( f ){
						if(f=="{course}"){
							notifyMaxPointsFeedbackCourse();
						}
						else if(f=="{limit}"){
							notifyMaxPointsFeedback();
						}
						else{
							notifyPoints(f);
						}
					});
            	}
            	else {alert('There was an error sending your feedback. This error has been logged. Please send an email with your feedback, the page you were on, and your username to DL-NBU-SYMU@symantec.com');}
            },
            error: function(e){
            	alert('There was an error sending your feedback. This error has been logged. Please send an email with your feedback, the page you were on, and your username to DL-NBU-SYMU@symantec.com');
                console.log(e.message);
				$('#myModal, #notify-overlay').remove();
            }
    });

};

function getPageCourseID() {
	var course_id = "";
	var classList = $('body')[0].className.split(/\s+/);
					for (var i = 0; i < classList.length; i++) {
						if (classList[i].indexOf('course-') > -1 ) {
							course_id = classList[i].split('-')[1];
						}
					}
	return course_id;
}
