<?php
if ( !defined( 'ABSPATH' ) ) exit;

add_action('admin_menu', 'bp_mymood_admin_option');
function bp_mymood_admin_option() {
  add_options_page('BuddyPress MyMood Options','BuddyPress MyMood', 7,__FILE__, 'bp_mymood_adminpanel');
}



function bp_mymood_adminpanel() {  ?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>

<h2>BuddyPress MyMood (1.0) <?php _e("Settings"); ?></h2>
<div style="clear:both"></div>
<?php

if(isset($_GET["delete_mood"])) {
$moods = get_option("bp_mymood_moods");
$mood_key = array_keys($moods,$_GET["delete_mood"]);
unset($moods[$mood_key[0]]);
update_option("bp_mymood_moods",$moods);
echo '<div class="updated"><p><b>'.$_GET["delete_mood"].'</b> has been deleted, <a href="?page='.$_GET["page"].'">Click here</a> to go back.</p></div>';
return true;	
} 

if(isset($_POST[Update])) {

if($_POST["bp_mymood_enable"] == "yes") {
	update_option('bp_mymood_enable',"yes");
} else {
	update_option('bp_mymood_enable',"no");
}

if($_POST["bp_mymood_req"] == "yes") {
	update_option('bp_mymood_req',"yes");
} else {
	update_option('bp_mymood_req',"no");
}

if($_POST["bp_mymood_header_meta_show"] == "yes") {
	update_option('bp_mymood_header_meta_show',"yes");
} else {
	update_option('bp_mymood_header_meta_show',"no");
}


_e('<div id="message" class="updated fade">
  <p>
    <strong>Status saved.</strong>
  </p>
</div>');
} 

?>

<div class="postbox-container" style="width:70%">


<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="form-table">

<tr valign="top">
<th scope="row">Enable :</th>
<td>
<label><input name="bp_mymood_enable" type="checkbox" value="yes" <?php if(get_option("bp_mymood_enable") == "yes"): ?> checked="checked" <?php endif; ?>> If checked then BuddyPress MyMood will not show anywhere on your site.</label>
</td>
</tr>

<tr valign="top">
<th scope="row">Mood Requred :</th>
<td>
<label><input name="bp_mymood_req" type="checkbox" value="yes" <?php if(get_option("bp_mymood_req") == "yes"): ?> checked="checked" <?php endif; ?>> If checked then member will be forced to updated his/her mood with every status.</label>
</td>
</tr>

<tr valign="top">
<th scope="row">Mood on Profile Head :</th>
<td>
<label><input name="bp_mymood_header_meta_show" type="checkbox" value="yes" <?php if(get_option("bp_mymood_header_meta_show") == "yes"): ?> checked="checked" <?php endif; ?>> If checked then latest mood (if any) will be shown on member profile header near name.</label>
</td>
</tr>
  
  <tr>
    <td height="26">&nbsp;</td>
    <td>
      <input type="submit" name="Update" class="button-primary" value="Update" />
    </td>
  </tr>
</table></form>

<?php

if(isset($_POST["bp_mymood_mood"])) {
	$moods = get_option("bp_mymood_moods");
	$moods_lower = array();
	foreach($moods as $m) {
		$moods_lower[] = strtolower($m);
	}
	if(in_array(trim(strtolower($_POST["bp_mymood_mood"])),$moods_lower)) {
		echo '<div class="error"><p><b>'.$_POST["bp_mymood_mood"].'</b> is already added.</p></div>';
	} else {
		$moods[] = trim($_POST["bp_mymood_mood"]);
		update_option("bp_mymood_moods",$moods);
		echo '<div class="updated"><p><b>'.$_POST["bp_mymood_mood"].'</b> mood added.</p></div>';
	}
}

?>


<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<table class="form-table">
<tr valign="top">
<th scope="row"><label>Add Mood :</label></th>
<td><input name="bp_mymood_mood" type="text" value="" class="regular-text">
<span class="description">Add Mood into the list below.</span>
</td>
</tr>

<tr>
    <td height="26">&nbsp;</td>
    <td>
      <input type="submit" name="Update" class="button-primary" value="Add" />
    </td>
  </tr>
<tr valign="top">
<th scope="row">Manage Moods :</th>
<td>
<?php
$moods = get_option("bp_mymood_moods");
foreach($moods as $mood) {
	echo '<span class="bp-mymood-mood"> '.$mood.' <a href="?page='.$_GET["page"].'&delete_mood='.$mood.'" title="delete this mood">x</a></span> ';
}
?>
</td>
</tr>

 
</table></form>


</div></div>

<style>
.bp-mymood-mood {
	padding:5px;
	background:#4d7306;
	color:white;
	display:block;
	float:left;
	margin:4px;
		-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
height:20px;
	}
.bp-mymood-mood a {
	padding:5px;
	background:gray;
	color:white;
	text-decoration:none;
		-webkit-border-radius: 5px;
-moz-border-radius: 5px;
border-radius: 5px;
height:20px;
}	
	
</style>



<!-- NEWS -->

<?php 
if(get_option("bp_mymood_news") == "") {
$news = wp_remote_fopen("http://webgarb.com/fetch_news/buddypress_mymood_news.php?ver=1.0");
update_option("bp_mymood_news",$news);
update_option("bp_mymood_news_date",date("Y-m-d",strtotime("+2 day")));
}
$extime = strtotime(get_option("bp_mymood_news_date"));
$nowtime = strtotime(date("Y-m-d"));
if($nowtime > $extime) {
$news = wp_remote_fopen("http://webgarb.com/fetch_news/buddypress_mymood_news.php?ver=1.0");
update_option("bp_mymood_news",$news);
update_option("bp_mymood_news_date",date("Y-m-d",strtotime("+2 day")));
}

?>
<div class="postbox-container" style="width:28%">

 <center>
 <a href="http://webgarb.com/?s=MymoodBuddyPress+MyMood" target="_blank" title="BuddyPress MyMood"><img src="<?php echo BP_MYMOOD_PATH."/logo.png"; ?>" border="0">
 </a> 
 </center>
 
<?php 
echo get_option("mymood_news"); 
?>
</div>
<div class="clear"></div>

<!-- NEW END -->



<h3>Need Help ? Visit <a href="http://webgarb.com/?s=MymoodBuddyPress+MyMood">BuddyPress MyMood</a> HomePage <a href="http://webgarb.com/?s=BuddyPress+MyMood">http://webgarb.com/?s=BuddyPress+MyMood</a></h3>

<p>Need a  Basic MyMood plugin for WordPress user ? Checkout Basic <a href="http://webgarb.com/?s=MyMood">MyMood</a> plugin visit : <a href="http://webgarb.com/?s=MyMood">http://webgarb.com/?s=MyMood</a></p>

<span class="description"><a href="http://webgarb.com/?s=BuddyPress+MyMood">BuddyPress MyMood</a> &copy; Copyright 2009 - 2010 <a href="http://webgarb.com">Webgarb.com</a>. MyMood Contain Graphic Smiley are property of their respective owner.<br />
</span>

<?php
} //End admin panel
?>