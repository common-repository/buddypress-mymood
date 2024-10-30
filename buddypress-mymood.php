<?php
if ( !defined( 'ABSPATH' ) ) exit;

include(BP_MYMOOD_DIR."/install.php");
require( dirname( __FILE__ ) . '/buddypress-mymood_admin.php' );

if(get_option("bp_mymood_enable") == "yes"): //dont load all code is plugin not enable
	


add_action("wp_head","bp_mymood_head"); 
function bp_mymood_head() {
	echo '<link rel="stylesheet" id="bp-default-main-css""  href="'.BP_MYMOOD_PATH.'/style.css" type="text/css"" media="all"" />';
}

add_action("bp_activity_post_form_options","output_bp_mymood_option");
/* add MyMood option in Post Activty Form */
function output_bp_mymood_option() {
	$moods = get_option("bp_mymood_moods");
	
	$html = '<div class="bp-mymood-option"> <div class="bp-mymood-mood"><label for="mymood_mood"> Mood : </label> <select name="mymood_mood" class="mymood-moods-input"><option value=""></option>';
	foreach($moods as $m) {
		$html = $html.'<option value="'.$m.'">'.$m.'</option>';
	}
	$html = $html.'</select></div>';
	$html = $html.'<a href="javascript:;" class="bp-mymood-smiley" title="Choose Smiley" id="bp-mymood-smiley"><img src="'.BP_MYMOOD_PATH.'/images/smiley.png" alt="smiley" /></a> 
	<input type="hidden" name="bp-mymood-smiley" id="bp-mymood-smiley-input"" value=""/> 
	<input type="hidden" name="bp-mymood-validate" value="1"/> 
	<div class="clear"></div>
	<div id="bp-mymood-smiley-popup" style="display:none">';
	
	foreach(bp_mymood_get_smiley() as $smiley => $url) {
		$html = $html.'<img src="'.$url.'" rel="'.$smiley.'" alt="Smiley" />';
	}
		
	$html = $html.'</div>';
	$html = $html.'<div class="clear"></div>';
	$html = $html.'</div>';
	$html = str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$html), "\0..\37'\\"))); 
	echo '
	<script type="text/javascript">
	<!--
	jQuery("#whats-new").after("'.$html.'");	
	jQuery("#bp-mymood-smiley").click(function() {
	jQuery("#bp-mymood-smiley-popup").slideToggle(500);
	});
	jQuery("#bp-mymood-smiley-popup").find("img").each(function() {
	var img_val = jQuery(this).attr("rel");
	var img = jQuery(this).attr("src");
	jQuery(this).click(function(){
	jQuery("#bp-mymood-smiley").find("img").attr("src",img);
	jQuery("#bp-mymood-smiley-input").val(img_val);
	jQuery("#bp-mymood-smiley").click();
	});
	
	});
	
	//remove ajax post if any trick
	jQuery(document).ready( function() { setTimeout(function() {  jQuery("input#aw-whats-new-submit").unbind("click"); },500); });
	
	//-->
	</script>
	';
}

add_action("bp_activity_before_save","bp_mymood_update_validation");

function bp_mymood_update_validation($p) {

 $mood = $_POST["mymood_mood"];
 $smiley = $_POST["bp-mymood-smiley"];

 if($_POST["bp-mymood-validate"] != "1") {
 	echo '<div id="message" class="error" style="display: block; "><p>Oops MyMood Got too Confused !.</p></div>';
	exit;
 }

 if(get_option("bp_mymood_req") != "yes") {
 	if($mood == "" and $smiley == "") {
		return true;
	}
 } 
 
 if(empty($mood)) {
 	bp_core_add_message( __( 'Please select your mood.', 'buddypress' ), 'error' );
	bp_core_redirect( wp_get_referer() );
 	return false;
 }
 $moods = get_option("bp_mymood_moods");
 if(!in_array($mood,$moods)) {
 	bp_core_add_message( __( 'You have selected invalid mood try again.', 'buddypress' ), 'error' );
	bp_core_redirect( wp_get_referer() );
 	return false;
 }	

 if(!is_smiley_exists($smiley)) {
	bp_core_add_message( __( 'The smiley you have selected is not found.', 'buddypress' ), 'error' );
	bp_core_redirect( wp_get_referer() );
	return false;
 }
	
 return true;
			
}



add_action("bp_activity_after_save","bp_mymood_update");

 function bp_mymood_update($p) {

 $mood = $_POST["mymood_mood"];
 $smiley = $_POST["bp-mymood-smiley"];
 
bp_activity_update_meta($p->id,"mymood_mood",$_POST["mymood_mood"]);
bp_activity_update_meta($p->id,"mymood_smiley",$_POST["bp-mymood-smiley"]);

 return true;
			
}

add_action("bp_activity_entry_content","bp_mymood_output_activity_post");
function bp_mymood_output_activity_post() {
	$id = bp_get_activity_id();
	
	if(bp_activity_get_meta($id,"mymood_mood") != ""):
	echo '<div class="bp-mymood-activity-post">
	<span class="mood"><strong>Mood</strong> : '.bp_activity_get_meta($id,"mymood_mood").'</span>';
	
	if(is_smiley_exists(bp_activity_get_meta($id,"mymood_smiley"))) {
	echo '<img src="'.BP_MYMOOD_PATH.'/smileys/'.smiley_dir().'/'.bp_activity_get_meta($id,"mymood_smiley").'" class="smiley"/>';
	} 
	echo '</div>';
	endif;
}
add_filter( 'bp_before_member_header_meta', 'bp_mymood_output_member_meta' );
function bp_mymood_output_member_meta() {

	if(get_option("bp_mymood_header_meta_show") != "yes") {
		return false;
	}
	
	$userId = bp_displayed_user_id();
	$activity = get_usermeta( $userId, 'bp_latest_update' );
	if(empty($activity)) {
		return FALSE;
	}
	if(bp_activity_get_meta($activity["id"],"mymood_mood") != ""):
	
	echo '<span class="bp-mymood-member-meta activity-'.$activity.'">';
	echo '<span class="mood"><strong>Mood</strong> : '.bp_activity_get_meta($activity["id"],"mymood_mood").'</span>';
	
	if(is_smiley_exists(bp_activity_get_meta($activity["id"],"mymood_smiley"))) {
	echo '<img src="'.BP_MYMOOD_PATH.'/smileys/'.smiley_dir().'/'.bp_activity_get_meta($activity["id"],"mymood_smiley").'" class="smiley"/>';
	} 
	
	echo '</span>';
	
	endif;
}


function bp_mymood_get_smiley() {

	$smileys = scandir(BP_MYMOOD_DIR."/smileys/".smiley_dir());
	$smiley_array = array();
	foreach($smileys as $smileys) {
	$ext = explode(".",$smileys);
	$ext = end($ext);
	$ext =  strtoupper($ext);
	if($ext == "PNG" || $ext == "JPG" || $ext == "JPEG" || $ext == "GIF") {
		$smiley_array[$smileys] = BP_MYMOOD_PATH."/smileys/".smiley_dir()."/".$smileys;
	}
	}
	return $smiley_array;
}

function is_smiley_exists($smiley) {

	 if(empty($smiley)){
		return false;
	 }
	
  if(!file_exists(BP_MYMOOD_DIR."/smileys/".smiley_dir()."/".$smiley)) {
	return false;
 }
 	return true;
}

function smiley_dir() {
	
	if(get_option("bp_mymood_icon_pack") == "") {
		$smiley_dir = "default";
	} else {
		$smiley_dir = get_option("bp_mymood_icon_pack");
	}
	if(!file_exists(BP_MYMOOD_DIR."/smileys/".$smiley_dir)) {
		$smiley_dir = "default";
	}
 	return $smiley_dir;
}


endif; //if(get_option("bp_mymood_enable") == "yes")
?>