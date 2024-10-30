<?php
if ( !defined( 'ABSPATH' ) ) exit;

function bp_mymood_install() {
$mymood_moods = array('Afraid', 'Amazed', 'Angry', 'Annoyed', 'Anxious', 'Aroused', 'Ashamed', 'Accomplished', 'Aggravated', 'Alone', 'Amused', 'Apathetic', 'Awake', 'Accepted', 'Bored', 'Brave', 'Bewildered', 'Bitchy', 'Bittersweet', 'Blah', 'Blank', 'Blissful', 'Bouncy', 'Calm', 'Cold', 'Confused', 'Contented', 'Curious', 'Cheerful', 'Chipper', 'Complacent', 'Content', 'Cranky', 'Crappy', 'Crazy', 'Crushed', 'Cynical', 'Depressed', 'Disappointed', 'Disgusted', 'Distracted', 'Dark', 'Determined', 'Devious', 'Dirty', 'Discontent', 'Ditzy', 'Dorky', 'Drained', 'Drunk', 'Embarrassed', 'Excited', 'Ecstatic', 'Energetic', 'Enraged', 'Enthralled', 'Envious', 'Exanimate', 'Exhausted', 'Flirtations', 'Frustrated', 'Flirty', 'Full', 'Grumpy', 'Guilty', 'Geeky', 'Giddy', 'Giggly', 'Gloomy', 'Good', 'Grateful', 'Groggy', 'Grumpy', 'Guilty', 'Happy', 'Hot', 'Humbled', 'Humiliated', 'Hungry', 'Hurt', 'High', 'Hopeful', 'Hyper', 'Impressed', 'In awe', 'In love', 'Indignant', 'Interested', 'Intoxicated', 'Invincible', 'Indescribable', 'Indifferent', 'Infuriated', 'Irate',  'Jealous', 'Jubilant', 'Lonely', 'Lazy', 'Lethargic', 'Listless', 'Loved', 'Mean', 'Moody', 'Mad', 'Melancholy', 'Mellow', 'Mischievous', 'Moody', 'Morose', 'Nervous', 'Neutral', 'Naughty', 'Nerdy', 'Not Specified', 'Numb', 'Offended', 'Optimistic', 'Playful', 'Proud', 'Peaceful', 'Pessimistic', 'Pissed off', 'Pleased', 'Predatory', 'Quixotic', 'Relieved', 'Remorseful', 'Restless', 'Recumbent', 'Refreshed', 'Rejected', 'Rejuvenated', 'Relaxed', 'Relieved', 'Rushed', 'Sad', 'Sarcastic', 'Serious', 'Shocked', 'Shy', 'Sick', 'Sleepy', 'Stressed', 'Surprised', 'Satisfied', 'Silly', 'Smart', 'Thristy', 'Thankful', 'Tired', 'Touched', 'Uncomfortable', 'Weird', 'Worried');

update_option("bp_mymood_moods",$mymood_moods);
update_option("bp_mymood_icon_pack","default"); //dir of smiley set
update_option("bp_mymood_enable","yes"); //yes / no
update_option("bp_mymood_req","no"); //yes / no
update_option("bp_mymood_header_meta_show","yes"); //yes / no

update_option("bp_mymood_install","1"); 

}

if(get_option("bp_mymood_install") != "1") {
	bp_mymood_install();
}

?>