<?php
if (!defined('INCLUDED776')) die ('Fatal error.');

/* Anti-guest addon */

$membersRule=20; //defines amount of posts, which registered member should have in order to bypass the addon rules. Setting to 0 disables checking of members.

$membersRuleDict=FALSE; //if TRUE, only forbidden words from the Dictionary are disallowed to post for members (but not Guests); FALSE if all links are disallowed for everyone

if( ($action=='ptopic' or $action=='pthread' or $action=='editmsg2' or (isset($_POST['prevForm']) and $_POST['prevForm']==1)) and ($user_id==0 or ($membersRule>0 and $user_id!=1 and $isMod==0 and $user_num_posts<=$membersRule) ) ) include ($pathToFiles.'addon_anti_guest.php');

/* --Anti-guest addon */

/* The most recent login by date */
if($user_id>0){
$currentDate=date('Y-m-d', $currentTime);
if($user_customlastvisit!=$currentDate){
$user_customlastvisit=$currentDate;
updateArray(array('user_customlastvisit'), $Tu, $dbUserId, $user_id);

if(isset($Tprm_users)) {
$lastvisit=$currentDate;
updateArray(array('lastvisit'), $Tprm_users, 'premod_id', $user_id);
}

}
}
/* --The most recent login by date */

/* Direct email addon */
$directEmailEnabled=TRUE;
$directEmailGuests=FALSE;
if($directEmailEnabled and $action=='userinfo') {
$fName=$pathToFiles.'lang/directemail_'.$lang.'.php';
if(file_exists($fName)) include($fName); else include($pathToFiles.'lang/directemail_eng.php');
}
if($directEmailEnabled and $action=='senddirect' and $genEmailDisable!=1) include($pathToFiles.'addon_directemail.php');
/* --Direct email addon */

/* most active users within given month */
if($action=='monthusers' or $action=='stats') include($pathToFiles.'addon_monthusers.php');
/* --most active users within given month */

/* Color Picker */
if($logged_admin==1 or $isMod==1){

if(($action=='' and isset($separateTopic) and $separateTopic==1) or $action=='vthread' or $action=='vtopic' or $action=='editmsg' or ($action=='pmail' and isset($_GET['step']) and ($_GET['step']=='massmail' or $_GET['step']=='sendmsg' or $_GET['step']=='viewmsg_inbox')) or ($action=='premodpanel' and isset($_GET['stepmod']) and ($_GET['stepmod']=='editmsg' or $_GET['stepmod']=='edittpc') ) ) include ($pathToFiles.'addon_bbcolor.php');

if($action=='vthread' or $action=='vtopic' or $action=='editmsg' or ($action=='pmail' and isset($_GET['step']) and ($_GET['step']=='massmail' or $_GET['step']=='sendmsg' or $_GET['step']=='viewmsg_inbox')) or ($action=='' and isset($firstPageTopicForm) and $firstPageTopicForm==1)){
$button_color_picker=<<<out
<a href="javascript:doPicker()" onmouseover="window.status='{$l_bb_color}'; return true" onmouseout="window.status=''; return true" onmousemove="pasteSel()" rel="nofollow"><img src="{$main_url}/img/button_color.gif" style="width:22px;height:22px" alt="{$l_bb_color}" title="{$l_bb_color}" /></a><img src="{$main_url}/img/p.gif" style="width:{$bbimgmrg}px;height:22px" alt="" />
out;

$color_picker_block=<<<out
<!--BBJSBUTTONS-->
<div id="colorpick" style="display:none;">
{$colorPicker}
</div>
<!--/BBJSBUTTONS-->
out;

$color_picker_js=<<<out
<script type="text/javascript">
<!--
var pickerShow;
pickerShow=false;
function doPicker(){
if(!pickerShow) { disp='block'; pickerShow=true; } else { disp='none'; pickerShow=false; }
document.getElementById('colorpick').style.display=disp;
}
//-->
</script> 
out;
}

}
/* --Color Picker */

/* Bulleted List */
if($action=='vthread' or $action=='vtopic' or $action=='editmsg' or $action=='pmail' or ($action=='' and isset($firstPageTopicForm) and $firstPageTopicForm==1)){
$button_list='<a href="javascript:paste_strinL(selektion,3,\'[list]\r\n\',\'\r\n[/list]\',\'\')" onmouseover="window.status=\'List\'; return true" onmouseout="window.status=\'\'; return true" onmousemove="pasteSel()" rel="nofollow"><img src="'.$main_url.'/img/button_list.gif" alt="List" title="List" style="width:22px;height:22px" /></a><img src="'.$main_url.'/img/p.gif" style="width:'.$bbimgmrg.'px;height:22px" alt="" />';
}
/* --Bulleted List */

/* [[spoiler]] */

/* Responsive videos */
if( (isset($is_mobile) and $is_mobile and $action=='vthread') or (isset($_POST['prevForm']) and $_POST['prevForm']==1) ){
$responsiveMediaBlock=<<<out
<style>
.ytc {position:relative;padding-bottom:56.25%;height:0;overflow:hidden;} .ytc iframe,.ytc object,.ytc embed {position:absolute;top:0;left:0;width:100%;height:100%;}
</style>
out;
}
/* --Responsive videos */

/* Vimeo button */
if($action=='vthread' or $action=='vtopic' or $action=='editmsg' or $action=='pmail' or ($action=='' and isset($firstPageTopicForm) and $firstPageTopicForm==1)){
$button_vimeo=<<<out
<a href="javascript:paste_strinL(selektion,4,'[vimeo='+prompt('URL:','http://vimeo-url-here')+']','','')" onmouseover="window.status='{$l_bb_vimeo}'; return true" onmouseout="window.status=''; return true" onmousemove="pasteSel()" rel="nofollow"><img src="{$main_url}/img/button_vimeo.gif" style="width:22px;height:22px" alt="{$l_bb_vimeo}" title="{$l_bb_vimeo}" /></a><img src="{$main_url}/img/p.gif" style="width:{$bbimgmrg}px;height:22px" alt="" />
out;
}
/* --Vimeo button */

/* Youtube button */
if($action=='vthread' or $action=='vtopic' or $action=='editmsg' or $action=='pmail' or ($action=='' and isset($firstPageTopicForm) and $firstPageTopicForm==1)){
$button_youtube=<<<out
<a href="javascript:paste_strinL(selektion,4,'[youtube='+prompt('YouTube%20movie%20URL:','http://youtu.be/')+']','','')" onmouseover="window.status='{$l_bb_youtube}'; return true" onmouseout="window.status=''; return true" onmousemove="pasteSel()" rel="nofollow"><img src="{$main_url}/img/button_youtube.gif" style="width:22px;height:22px" alt="{$l_bb_youtube}" title="{$l_bb_youtube}" /></a><img src="{$main_url}/img/p.gif" style="width:{$bbimgmrg}px;height:22px" alt="" />
out;
}
/* --Youtube button */
function parseTopic(){
/* Unread Messages Indicator */
if($GLOBALS['user_id']==0) $GLOBALS['unreadicon']='';
else{

if(isset($GLOBALS['cols']) or (isset($GLOBALS['superStickyModule']) and isset($GLOBALS['colst'])) ){

if(!isset($GLOBALS['superStickyModule'])){
if($GLOBALS['action']=='') $chk=$GLOBALS['cols'][7]; else $chk=$GLOBALS['cols'][9];
}
else $chk=$GLOBALS['colst'][9];

if(!isset($GLOBALS['superStickyModule'])) $tid=$GLOBALS['cols'][0]; else $tid=$GLOBALS['colst'][0];
if( (!isset($GLOBALS['readTopics'][$tid]) and $chk>$GLOBALS['mslvPoint']) or (isset($GLOBALS['readTopics'][$tid]) and $chk>$GLOBALS['readTopics'][$tid] ) ) $GLOBALS['unreadicon']="&nbsp;&nbsp;<img src=\"{$GLOBALS['main_url']}/img/unread.gif\" style=\"width:8px;height:8px\" alt=\"Unread\" title=\"Unread\" />"; else $GLOBALS['unreadicon']='';

}

}
/* --Unread Messages Indicator */
}

/* Smilies addon */
if(($action=='vtopic' or $action=='vthread' or $action=='ptopic' or $action=='pthread' or $action=='editmsg' or $action=='editmsg2' or $action=='pmail')  or $action=='displaysmilies' or ($action=='premodpanel' and isset($_GET['stepmod']) and ($_GET['stepmod']=='editmsg' or $_GET['stepmod']=='edittpc') ) or (isset($_POST['prevForm']) and trim($_POST['postText'])!='') ) include ($pathToFiles.'addon_smilies.php');
/* --Smilies addon */

/* members list addon */
if(!isset($l_membersList)) $l_membersList='Members List';
if(isset($is_mobile) and $is_mobile) $mListBr=$brtag; else $mListBr='';
if($action=='memberslist') {
//Uncommenting the code below, you will allow only logged in members to view the members list
/*
if ($user_id<1){
$errorMSG=$l_signIn; 
echo load_header(); 
echo ParseTpl(makeUp('main_warning')); 
display_footer();
exit; 
}
*/
include($pathToFiles.'addon_memberslist.php');
}
/* --members list addon */

/* Unread Messages Indicator */

//options

$cLimitTopics=100; //how many read topics to store in a cookie or database. Cookie size limit is about 4 Kb of data incl. cookie name and time. Unread topics hold topic id and last post id, so it depends on how big IDs have topics and posts. With DB, this is not limited, however you must keep in mind as more records are in a table, as more slower it will be.

$unreadMsgMode=0; //1 means we will use mySQL for storing the data; 0 - cookies

$cookieexptoptime=time()+31536000; //1 year

$Tun_point='minibbtable_unreadpoint'; //table name if mySQL is used
$Tun_topics='minibbtable_unreadtopics'; //table name if mySQL is used

if($user_id>0) $resetReadLink="<a href=\"{$main_url}/{$indexphp}action=resetread\">Mark All Messages Read</a> {$l_sepr} ";
else $resetReadLink='';

$showIconInForums=FALSE; //TRUE or FALSE - will show the Unread icon also in forum lists; it will take 2 extra requests from DB. Currently works only for $unreadMsgMode=0; mode.

//end of options

if($user_id>0){

if($unreadMsgMode==0){
//cookies mode

if(!isset($_COOKIE[$cookiename.'_mslv'])) $mslvPoint=0;
else $mslvPoint=(int)$_COOKIE[$cookiename.'_mslv'];

if($action=='vthread' and $topicData[9]>$mslvPoint){

$currtopics=array();

if(!isset($_COOKIE[$cookiename.'_tread'])){
$treadVal=$topic.'-'.$topicData[9];
}
elseif(preg_match("#[0-9_-]+#", $_COOKIE[$cookiename.'_tread'])){
if(substr_count($_COOKIE[$cookiename.'_tread'], '_')==0) {
$q=explode('-', $_COOKIE[$cookiename.'_tread']);
$currtopics[$q[0]]=$q[1];
}
else {
$ct=explode('_', $_COOKIE[$cookiename.'_tread']);
foreach($ct as $cc){
$q=explode('-', $cc);
$currtopics[$q[0]]=$q[1];
}

//$currtopics=explode('_', $_COOKIE[$cookiename.'_tread']);

}

//store up to 100 topics
if(is_array($currtopics) and (!isset($currtopics[$topic]) or $currtopics[$topic]<$topicData[9]) and sizeof($currtopics)+1>$cLimitTopics) {

$f=sizeof($currtopics)-$cLimitTopics;

$newcurrtopics=array();

$ee=1;
foreach($currtopics as $key=>$val){
if($f>=$ee) {
$ee++;
continue;
}
else{
$newcurrtopics[]=$key.'-'.$val;
}
}

//for($i=sizeof($currtopics)-1; $i>=$f; $i--) 

$treadVal=implode('_', $newcurrtopics);

}
elseif(!isset($currtopics[$topic]) or $currtopics[$topic]<$topicData[9]){
$currtopics[$topic]=$topicData[9];
$newcurrtopics=array();
foreach($currtopics as $key=>$val) $newcurrtopics[]=$key.'-'.$val;
//for($i=0; $i<sizeof($currtopics); $i++) $newcurrtopics[]=$currtopics[$i].'-'.$currposts[$i];
$treadVal=implode('_', $newcurrtopics);
}
else $treadVal=-1;

}

if($treadVal>=0) {
setcookie($cookiename.'_tread', '', (time()-2592000), $cookiepath, $cookiedomain, $cookiesecure, TRUE);
setcookie($cookiename.'_tread', $treadVal, $cookieexptoptime, $cookiepath, $cookiedomain, $cookiesecure, TRUE);
}
}

if($action=='resetread'){

if($row=db_simpleSelect(0, $Tp, 'post_id', '', '', '', 'post_id DESC', 1)) $mslvPoint=$row[0]; else $mslvPoint=0;

setcookie($cookiename.'_mslv', '', (time()-2592000), $cookiepath, $cookiedomain, $cookiesecure, TRUE);
setcookie($cookiename.'_mslv', $mslvPoint, $cookieexptoptime, $cookiepath, $cookiedomain, $cookiesecure, TRUE);

setcookie($cookiename.'_tread', '', (time()-2592000), $cookiepath, $cookiedomain, $cookiesecure, TRUE);

header("{$rheader}{$main_url}/{$indexphp}");
exit;
}

if($action=='' or $action=='vtopic'){

$readTopics=array();

if(!isset($_COOKIE[$cookiename.'_tread']) or !preg_match("#[0-9_-]+#", $_COOKIE[$cookiename.'_tread'])) {}
else{
$currtopics=explode('_', $_COOKIE[$cookiename.'_tread']);

$ct=explode('_', $_COOKIE[$cookiename.'_tread']);
foreach($ct as $cc){
$q=explode('-', $cc);
$readTopics[$q[0]]=$q[1];
}

}

//print_r($readTopics);
//echo $mslvPoint;

if($showIconInForums){

$forumPosts=array();
$forumIcons=array();

if (isset($clForumsUsers)) $closedForums=getAccess($clForums, $clForumsUsers, $user_id); else $closedForums='n';
if ($closedForums!='n') {
$xtr=getClForums($closedForums,'where','','forum_id','and','!=');
$xtr2=getClForums($closedForums,'and','','forum_id','and','!=');
}
else {
$xtr='';
$xtr2='';
}

if($row=db_simpleSelect(0, $Tf, 'count(*)')) $forumsAmount=$row[0]; else $forumsAmount=0;

$uSql="select topic_last_post_id, forum_id, topic_id from {$Tt} where topic_last_post_id>'{$mslvPoint}' {$xtr2} order by topic_last_post_id desc";

if(($DB=='mysql' and $res=mysql_query($uSql) and mysql_num_rows($res)>0 and $row=mysql_fetch_row($res)) OR ($DB=='mysqli' and $res=mysqli_query($mysqlink, $uSql) and mysqli_num_rows($res)>0 and $row=mysqli_fetch_row($res))){
do{

if(!isset($forumPosts[$row[1]])){
if(!isset($readTopics[$row[2]]) or (isset($readTopics[$row[2]]) and $readTopics[$row[2]]<$row[0]) ) $forumPosts[$row[1]]="&nbsp;&nbsp;<img src=\"{$GLOBALS['main_url']}/img/unread.gif\" style=\"width:8px;height:8px\" alt=\"Unread\" title=\"Unread\" />";
}

if(sizeof($forumPosts)==$forumsAmount) break;

}
while( ($DB=='mysql' and $row=mysql_fetch_row($res)) OR ($DB=='mysqli' and $row=mysqli_fetch_row($res)) );
}

unset($xtr);
}

}

}//cookies mode

else{
//mysql mode

if($row=db_simpleSelect(0, $Tun_point, 'last_id', 'user_id', '=', $user_id)) $mslvPoint=$row[0]; else $mslvPoint=0;

if($action=='vthread' and $topicData[9]>$mslvPoint){

if($row=db_simpleSelect(0, $Tun_topics, 'post_id', 'topic_id', '=', $topic, '', '', 'user_id', '=', $user_id)) {
$sql_q="update {$Tun_topics} set post_id={$topicData[9]} where topic_id={$topic} and user_id={$user_id}";
if($DB=='mysql') mysql_query($sql_q);
elseif($DB=='mysqli') mysqli_query($mysqlink, $sql_q);
}
else{
$sql_q="insert {$Tun_topics} (topic_id, post_id, user_id) values ({$topic}, {$topicData[9]}, {$user_id})";
if($DB=='mysql') mysql_query($sql_q);
elseif($DB=='mysqli') mysqli_query($mysqlink, $sql_q);
}

//fix table limit
if($row=db_simpleSelect(0, $Tun_topics, 'count(*)', 'user_id', '=', $user_id)) $currStore=$row[0]; else $currStore=0;
if($currStore>$cLimitTopics){

$clm=$currStore;
if($row=db_simpleSelect(0, $Tun_topics, 'topic_id, post_id', 'user_id', '=', $user_id, 'post_id asc')) {
do{
$sql_q="delete from $Tun_topics where topic_id={$row[0]} and user_id=$user_id and post_id={$row[1]}";
if($DB=='mysql') mysql_query($sql_q);
elseif($DB=='mysqli') mysqli_query($mysqlink, $sql_q);
$clm--;
}
while($clm>$cLimitTopics and $row=db_simpleSelect(1));
}

}

}

if($action=='resetread'){

if($row=db_simpleSelect(0, $Tp, 'post_id', '', '', '', 'post_id DESC', 1)) $mslvPoint=$row[0]; else $mslvPoint=0;

$sql_q="delete from $Tun_topics where user_id=$user_id";
if($DB=='mysql') mysql_query($sql_q);
elseif($DB=='mysqli') mysqli_query($mysqlink, $sql_q);

if($row=db_simpleSelect(0, $Tun_point, 'last_id', 'user_id', '=', $user_id)) {
$sql_q="update {$Tun_point} set last_id={$mslvPoint} where user_id={$user_id}";
if($DB=='mysql') mysql_query($sql_q);
elseif($DB=='mysqli') mysqli_query($mysqlink, $sql_q);
}
else{
$sql_q="insert {$Tun_point} (last_id, user_id) values ({$mslvPoint}, {$user_id})";
if($DB=='mysql') mysql_query($sql_q);
elseif($DB=='mysqli') mysqli_query($mysqlink, $sql_q);
}

header("{$rheader}{$main_url}/{$indexphp}");
exit;
}

if($action=='' or $action=='vtopic'){

$readTopics=array();

if($row=db_simpleSelect(0, $Tun_topics, 'topic_id, post_id', 'user_id', '=', $user_id)){
do{
$readTopics[$row[0]]=$row[1];
}
while($row=db_simpleSelect(1));
}

//print_r($readTopics);
//echo $mslvPoint;

}

}//mysql mode

}//user_id>0


/* --Unread Messages Indicator */

/* Highlight button */
if($user_id>0){
$button_hl=<<<out
<a href="JavaScript:paste_strinL(selektion,3,'[hl]\r\n','\r\n[/hl]','')" onmouseover="window.status='List'; return true" onmouseout="window.status=''; return true" onmousemove="pasteSel()" rel="nofollow"><img src="{$main_url}/img/button_hl.gif" alt="Highlight" title="Highlight" style="width:22px;height:22px"/></a>&nbsp;&nbsp;
out;
}
else $button_hl='';
/* --Highlight button */

/* Gender Solution */

$genders=array(0=>'&nbsp;', '1'=>$l_genderMale, 2=>$l_genderFemale);

if($action=='vthread' or $action=='userinfo'){

function parseUserInfo_user_custom3($val){
if($GLOBALS['action']=='userinfo') {
if(isset($GLOBALS['genders'][$val]) and (int)$val!=0) return $GLOBALS['genders'][$val]; else return '';
}
else{
if($val!=0 and isset($GLOBALS['genders'][$val])) $ret="<img src=\"{$GLOBALS['main_url']}/img/icon_gender_{$val}.gif\" alt=\"{$GLOBALS['genders'][$val]}\" title=\"{$GLOBALS['genders'][$val]}\" style=\"width:7px;height:8px\" /> "; else $ret='';
return $ret;
}
}
}
/* --Gender Solution */

/* Displaying the most recent login under the profile */
if($action=='userinfo'){

function parseUserInfo_user_customlastvisit($val){

$dateFormatTmp=$GLOBALS['dateFormat'];
$GLOBALS['dateFormat']=$GLOBALS['dateOnlyFormat'];

if(isset($GLOBALS['timeDiff'])) $timeDiffTmp=$GLOBALS['timeDiff']; else $timeDiffTmp=0;
$GLOBALS['timeDiff']=0;
$todayTmp=$GLOBALS['today']; $yesterdayTmp=$GLOBALS['yesterday'];
$currentTime=time();
$GLOBALS['today']=date('Y-m-d', $currentTime);
$GLOBALS['yesterday']=date('Y-m-d', $currentTime-86400);

if($val!='0000-00-00') {

if(!defined('DISABLE_CONVERT_DATE_BACK')) define('DISABLE_CONVERT_DATE_BACK', 1);

if(isset($GLOBALS['l_backLessTimes'])){
$l_backLessTimes_tmp=$GLOBALS['l_backLessTimes'];
}
else unset($l_backLessTimes_tmp);
$GLOBALS['l_backLessTimes']=array();

$datt=convert_date($val);

if(isset($l_backLessTimes_tmp)) $GLOBALS['l_backLessTimes']=$l_backLessTimes_tmp;
else unset($GLOBALS['l_backLessTimes']);

if(substr($datt, 0, strlen($GLOBALS['l_today']))==$GLOBALS['l_today']) $datt=$GLOBALS['l_today'];
if(substr($datt, 0, strlen($GLOBALS['l_yesterday']))==$GLOBALS['l_yesterday']) $datt=$GLOBALS['l_yesterday'];

if(substr_count($datt, ',')>0){
$ret=explode(',', $datt);
$retDate=str_replace(',', '', $ret[0]);
}
else $retDate=$datt;
}
else $retDate='';

$GLOBALS['timeDiff']=$timeDiffTmp;
if($GLOBALS['timeDiff']==0) unset($GLOBALS['timeDiff']);
$GLOBALS['today']=$todayTmp;
$GLOBALS['yesterday']=$yesterdayTmp;
$GLOBALS['dateFormat']=$dateFormatTmp;

return $retDate;
}

}
/* --Displaying the most recent login under the profile */

?>