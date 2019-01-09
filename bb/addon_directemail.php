<?php
/*
addon_email2.php : plug-in for direct sending mails in miniBB 2.
This file is part of miniBB. miniBB is free discussion forums/message board software, supplied with no warranties.
Check COPYING file for more details. 
Copyright (C) 2004,2006-2008, 2017 Paul Puzyrev. www.minibb.com
Latest File Update: 2017-Feb-21
*/

if (!defined('INCLUDED776')) die ('Fatal error.');

if(!isset($directEmailEnabled) or !$directEmailEnabled) die('');
if($user_id==0 and !$directEmailGuests) die('');

$fName=$pathToFiles.'lang/directemail_'.$lang.'.php';
if(file_exists($fName)) include($fName); else include($pathToFiles.'lang/directemail_eng.php');

if(isset($_GET['user'])) $user=(integer)$_GET['user']+0; elseif(isset($_POST['user'])) $user=(integer)$_POST['user']+0; else $user=0;
if(isset($_GET['reportPost'])) $reportPost=(integer)$_GET['reportPost']+0; elseif(isset($_POST['reportPost'])) $reportPost=(integer)$_POST['reportPost']+0; else $reportPost=0;

if($user!=$user_id and $rrr=db_simpleSelect(0, $Tu, "{$dbUserId}, {$dbUserSheme['user_email'][1]}, {$dbUserSheme['username'][1]}", $dbUserId,'=',$user)) {

$userMail=$rrr[1];
$userNick=$rrr[2];

$title=$title.$l_sendMsg2.' '.$userNick;

if(!isset($_POST['senddirect2'])){

if($user_id==1) $email=$admin_email;
elseif($user_id!=0) {$email=db_simpleSelect(0, $Tu, "{$dbUserSheme['user_email'][1]}", $dbUserId,'=',$user_id);$email=$email[0];}
else $email='';

$warning='';

if($reportPost!=0){
if($row=db_simpleSelect(0, $Tp, 'post_id, topic_id, forum_id, post_text', 'post_id', '=', $reportPost)){
$forum=$row[2];
$topic=$row[1];

if(isset($mod_rewrite) and $mod_rewrite) $urlp=addTopicURLPage(genTopicURL($main_url, $row[2], '#GET#', $row[1], '#GET#'), $page)."#msg{$reportPost}";
else $urlp=addGenURLPage("{$main_url}/{$indexphp}action=vthread&amp;forum={$row[2]}&amp;topic={$row[1]}", $page)."#msg{$reportPost}";

//require_once($pathToFiles.'bb_codes.php');
$row[3]=strip_tags(str_replace('<br />', "\n", $row[3]));

$question=<<<out
{$l_sendReport}

{$row[3]}

{$urlp}
out;
}

}

echo load_header();
echo ParseTpl(makeUp('addon_directemail'));
}

else{
/* check for all fields */
$email=(isset($_POST['email'])?trim($_POST['email']):'');
$question=(isset($_POST['question'])?trim($_POST['question']):'');

if($email!='' and $question!=''){

if(!isset($user_usr) or $user_usr=='') $user_usr='N/A';
$msg=ParseTpl(makeUp('email_direct_mode'));
$sub=explode('SUBJECT>>', $msg); $sub=explode('<<', $sub[1]); $msg=trim($sub[1]); $sub=$sub[0];
$msg=stripslashes($msg);
sendMail($userMail, $sub, $msg, $reply_to_email, $reply_to_email);

$errorMSG=$l_sendSent;
if($reportPost!=0 and isset($_POST['forum']) and isset($_POST['topic'])){
$forum=(integer)$_POST['forum']+0;
$topic=(integer)$_POST['topic']+0;

if(isset($mod_rewrite) and $mod_rewrite) $urlp=addTopicURLPage(genTopicURL($main_url, $forum, '#GET#', $topic, '#GET#'), $page)."#msg{$reportPost}";
else $urlp=addGenURLPage("{$main_url}/{$indexphp}action=vthread&amp;forum={$forum}&amp;topic={$topic}", $page)."#msg{$reportPost}";
$correctErr="<a href=\"{$urlp}\">{$l_msgBack}</a>";
}
else $correctErr='';
echo load_header();
echo ParseTpl(makeUp('main_warning'));
}
else {
$warning=$l_sendMailWarn;
echo load_header();
echo ParseTpl(makeUp('addon_directemail'));
}

} //isset senddirect2

} //user exists

else {
$errorMSG=$l_accessDenied;
echo load_header();
echo ParseTpl(makeUp('main_warning'));
}

?>