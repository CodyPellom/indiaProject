<?php
/*
addon_smilies.php : the Smilies add-on file for miniBB 2.
This file is a part of miniBB. miniBB is a free discussion forums/message board software, provided with no warranties.
Check COPYING file for more details.
Copyright (C) 2018 Paul Puzyrev. www.minibb.com
Graphics provided by the 3rd party (the author is unknown).
Latest File Update: 2018-Mar-11
*/

/* Options */
$dirname = 'smilies';
$splitRow=6;

/* Code */
if (!defined('INCLUDED776')) die ('Fatal error.');

$hackSmilies=1;

include($pathToFiles.'img/'.$GLOBALS['dirname'].'/smdesc.php');

function smileThis($aPost, $aEdit, $postText) {

if ($aPost) {
foreach($GLOBALS['smilies'] as $key=>$val) $postText=str_replace($key, "[img]".$GLOBALS['main_url']."/img/".$GLOBALS['dirname']."/".$val."[/img]", $postText);
}
elseif ($aEdit) {
foreach($GLOBALS['smilies'] as $key=>$val) $postText=str_replace("[img]".$GLOBALS['main_url']."/img/".$GLOBALS['dirname']."/".$val."[/img]", $key, $postText);
}

return $postText;
}

$disbbcode=(isset($_POST['disbbcode']) and $_POST['disbbcode']==1?1:0);
$dissmilies=(isset($_POST['dissmilies'])?$_POST['dissmilies']:'');

$aPost=($action=='ptopic' or $action=='pthread' or $action=='editmsg2' or $action=='pmail' or (isset($_POST['prevForm']) and $_POST['prevForm']==1) or ($action=='premodpanel' and isset($_POST['stepmod']) and ($_POST['stepmod']=='editmsg2' or $_POST['stepmod']=='edittpc2')) );

if($aPost and !$disbbcode and $dissmilies!='on') {
if(isset($_POST['postText'])) $_POST['postText']=smileThis($aPost, FALSE, $_POST['postText']);
}
elseif ($action=='displaysmilies') {

echo <<<out
<!doctype html>
<head>
<title>{$sitename}</title>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW" />
<meta name="viewport" content="width=device-width,initial-scale=1">
{$fontsCSS}
<link href="{$main_url}/css/{$skin}.css" type="text/css" rel="stylesheet" />
</head>
<body class="gbody">
{$brtag}
<table class="forums w100">
out;

$s=1;
$listedFile=array();
if(isset($is_mobile_browser) and $is_mobile_browser){
$onclickclose='self.close();';
}
else $onclickclose='self.focus();';

foreach($smilies as $key=>$val) {
if(!in_array($val, $listedFile)){
$listedFile[]=$val;
if($s==1) echo '<tr>';
echo "<td class=\"txtC\"><a href=\"#\" onclick=\"javascript:{$onclickclose}window.opener.paste_strinL('{$key}',3,'','',''); \"><img src=\"{$main_url}/img/{$dirname}/{$val}\" alt=\"{$key}\" title=\"{$key}\" /></a></td>\n";

$s++;
if($s>$splitRow) {
$s=1;
echo '</tr>';
}

}
}

if($s<=$splitRow and $s!=1){
for($i=$s; $i<=$splitRow; $i++){
echo '<td>&nbsp;</td>';
}
echo '</tr>';
}

echo '<tr><td colspan="'.$splitRow.'" class="txtC vmTP"><form action="#"><input type="button" onclick="self.close()" value="'.$l_smiliesClose.'" class="inputButton" /></form></td></tr></table></body></html>';
exit;
}

if($action=='vthread' or $action=='vtopic' or $action=='editmsg' or defined('NEW_TOPIC_FORM') or $action=='pmail'){

$smiliesFuncCode=makeUp('addon_smilies_func');
$smiliesImgCode=convertBBJS(ParseTpl(makeUp('addon_smilies_img')));
if(isset($is_mobile) and $is_mobile) $smiliesImgCode=$brtag.$smiliesImgCode;

}

?>