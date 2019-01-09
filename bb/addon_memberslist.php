<?php
/*
addon_memberslist.php : Member List add-on for miniBB.
This file is part of miniBB. miniBB is free discussion forums/message board software, supplied with no warranties.
Check COPYING file for more details.
Copyright (C) 2004-2018 Paul Puzyrev. www.minibb.com
Latest File Update: 2018-Apr-25
*/

if (!defined('INCLUDED776')) die ('Fatal error.');
if (!defined('NOFOLLOW')) $nof=' rel="nofollow"'; else $nof='';

/* Get list */
$morder=(isset($_GET['morder'])?operate_string($_GET['morder']):'username');
$memberSearch=(isset($_GET['memberSearch'])?operate_string($_GET['memberSearch']):'');
$memberSearchVal=(isset($_GET['memberSearchVal'])?$_GET['memberSearchVal']:'');

if($morder=='user_id') $dbUserSheme[$morder][1]=$dbUserId;
if(!isset($dbUserSheme[$morder])) $morder='username';

$memberFieldsDropDown=makeValuedDropDown(array('username'=>$l_usrInfo[1], $dbUserId=>'ID', 'user_from'=>$l_usrInfo[8]), 'memberSearch');

$uniC='';$uniV='';$uniF='';
if($memberSearchVal!='') {

$uniV=$memberSearchVal=operate_string($memberSearchVal);

if($memberSearch=='username' or $memberSearch=='user_from') {
$uniV='%'.operate_string($memberSearchVal).'%';
$uniC=' like ';
}
else {
$uniV=operate_string($memberSearchVal); 
$uniC='=';
}

$uniF=$dbUserSheme['username'][1];
if($memberSearch!='') {
if (isset($dbUserSheme[$memberSearch])) $uniF=$dbUserSheme[$memberSearch][1];
elseif($memberSearch==$dbUserId) $uniF=$dbUserId;
}

}

if(isset($is_mobile) and $is_mobile) $isMobileHd=TRUE; else $isMobileHd=FALSE;

if($memberSearchVal!=''){
$searchBackLink="&nbsp;<a href=\"{$main_url}/{$indexphp}action=memberslist\" class=\"mnblnk\">{$l_back}</a>";
}

/* Restricting from viewing inactive accounts */
if($uniC==''){
$uniF=$dbUserAct; $uniC='='; $uniV='1';
$uniF2=''; $uniC2=''; $uniV2='';
}
else{
$uniF2=$dbUserAct; $uniC2='='; $uniV2='1';
}

if($rs=db_simpleSelect(0,$Tu,'count(*)',$uniF, $uniC, $uniV, '', '', $uniF2, $uniC2, $uniV2)) $numUsers=$rs[0]; else $numUsers=0;
$makeLim=makeLim($page,$numUsers,$viewmaxsearch);
$pageNav=pageNav($page,$numUsers,"{$main_url}/{$indexphp}action=memberslist&amp;morder={$morder}&amp;memberSearch={$memberSearch}&amp;memberSearchVal={$memberSearchVal}",$viewmaxsearch,FALSE);

if($row=db_simpleSelect(0, $Tu,"{$dbUserId}, {$dbUserSheme['username'][1]}, {$dbUserSheme['user_email'][1]}, {$dbUserSheme['user_icq'][1]}, {$dbUserSheme['user_website'][1]}, {$dbUserSheme['user_from'][1]}, {$dbUserSheme['user_viewemail'][1]}, {$dbUserDate}, {$dbUserSheme['num_posts'][1]}", $uniF, $uniC, $uniV, "({$dbUserSheme[$morder][1]}=''), {$dbUserSheme[$morder][1]} ASC, {$dbUserDate} DESC", $makeLim, $uniF2, $uniC2, $uniV2)){
$cell=makeUp('addon_members_cell');
$memberList='';
$aa=-1;
do{
if($aa<0) $bg='tbCel1'; else $bg='tbCel2';
$aa=-$aa;

$userId=$row[0];
$username="<a href=\"{$indexphp}action=userinfo&amp;user={$row[0]}\" class=\"mnblnk\">$row[1]</a>";
$user_icq=$row[3];

$user_website='';
if(trim($row[4])!='') {
if(!$isMobileHd) $user_website="<a href=\"{$row[4]}\" target=\"_blank\"{$nof} class=\"mnblnk\">".wordwrap($row[4],30,$brtag,1)."</a>";
else $user_website="<a href=\"{$row[4]}\" target=\"_blank\"{$nof} class=\"mnblnk\">".$l_usrInfo[6]."</a>";
}

$user_from=$row[5];
$user_regdate=convert_date($row[7]);
if($row[6]!=0) $user_email=$row[2]; else $user_email='&nbsp;';

if($isMobileHd){
$rem=array();
if($user_website=='' and $user_from=='') $rem[]='fromwebsite';
else{
if($user_website=='') $rem[]='website';
if($user_from=='') $rem[]='from';
}
if($user_icq=='') $rem[]='im';

if(sizeof($rem)>0){
$rArr=array();
foreach($rem as $val){
$rArr[]="#<!--ML_".$val."-->(.+?)<!--/ML_".$val."-->#is";
}
}

$cell=preg_replace($rArr, '', $cell);

if($row[8]==0) $uIcon='t.gif'; else $uIcon='s.png';
$uIcon="<img src=\"{$main_url}/img/{$uIcon}\" alt=\"{$l_stats_numPosts}: {$row[8]}\" title=\"{$l_stats_numPosts}: {$row[8]}\" />";
}

$memberList.=ParseTpl($cell);
}
while($row=db_simpleSelect(1));
}

if(!isset($memberList) or $memberList=='') {
if($isMobileHd) $anc='#searchml'; else $anc='';
$errorMSG=$l_searchFailed;
$correctErr="<a href=\"{$main_url}/{$indexphp}action=memberslist{$anc}\" class=\"mnblnk\">{$l_back}</a>";
}

$title=$title.$l_membersList;
echo load_header();

if(isset($memberList) and $memberList!=''){
$mainTpl=makeUp('addon_members');
$stxtR=' txtR';
if($pageNav=='') {
$mainTpl=preg_replace("#<!--pageNav-->(.*?)<!--/pageNav-->#is", '', $mainTpl);
$stxtR='';
}
}
else{
$mainTpl=makeUp('main_warning');
}

echo ParseTpl($mainTpl);

?>