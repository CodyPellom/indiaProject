<?php
/*
addon_monthusers.php : statistics file for miniBB (most active users in a given month incl. admin).
This file is part of miniBB. miniBB is free discussion forums/message board software, supplied with no warranties.
Check COPYING file for more details.
Copyright (C) 2005-2018 Paul Puzyrev. www.minibb.com
Latest File Update: 2018-Jun-05
*/
if (!defined('INCLUDED776')) die ('Fatal error.');

if(isset($_GET['statMonth'])) $statMonth=abs((integer)$_GET['statMonth']+0); else $statMonth=1;
if(isset($_GET['statYear'])) $statYear=abs((integer)$_GET['statYear']+0); else $statYear=date('Y');
if(isset($_GET['limits'])) $limits=abs((integer)$_GET['limits']+0); else $limits=10;
if($limits>100) $limits=100;

$fName=$pathToFiles.'lang/monthusers_'.$lang.'.php';
if(file_exists($fName)) include($fName); else include($pathToFiles.'lang/monthusers_eng.php');

if($action=='stats'){
$month_users=ParseTpl(makeUp('addon_monthusers'));
}
else{

if($action=='monthusers') {
$title.=$l_mStatsUsers;
echo load_header();
}

/*
//if($user_id==0){ //only for registered members
if(!($user_id==1 or $isMod)){ //only for admin/mods
echo '<div align=center><table class=forums><tr><td class=caption3>Not available for you, sorry!</td></tr></table>';
return;
}
*/

$months=array();
$mnt=explode(':',$l_months);
for($i=0;$i<12;$i++) $months[$i+1]=$mnt[$i];
$monthsDropDown=makeValuedDropDown($months,'statMonth');

if($row=db_simpleSelect(0,$Tp,'post_time','','','','post_id asc',1)) $minYear=date('Y',strtotime($row[0]));
else $minYear=date('Y');

$years=array();
for($i=$minYear;$i<=date('Y');$i++) $years[$i]=$i;

$yearsDropDown=makeValuedDropDown($years,'statYear');

$limitsDropDown=makeValuedDropDown(array(5=>5,10=>10,20=>20,50=>50,100=>100),'limits');

$userBoxes = <<<out
<form class="formStyle" method="get" action="{$main_url}/{$indexphp}">
<table class="tbTransparentmb">

<tr><td>
<span class="txtNr">{$l_chooseMonth}<br /><br />{$monthsDropDown}&nbsp;{$yearsDropDown}&nbsp;{$l_stats_top}&nbsp;{$limitsDropDown}<br /><br /></span>
<input type="submit" value="{$l_submit}" class="inputButton" />
<input type="hidden" name="step" value="1" />
<input type="hidden" name="action" value="monthusers" />

</td></tr>
</table>
</form>
out;

if($action=='monthusers') echo <<<out

<table class="forumsmb">
<tr>
<td class="caption3">
out;

if(!(isset($is_mobile) and $is_mobile)) echo <<<out
<a href="{$main_url}/{$startIndex}" class="mnblnk">{$sitename}</a> / <a href="{$main_url}/{$indexphp}action=stats" class="mnblnk">{$l_stats}</a> / {$l_mStatsUsers}
out;
else echo <<<out
{$l_mStatsUsers}</td><td class="tbTransparentCell vTop"><span class="txtSm"><a href="{$main_url}/{$indexphp}action=stats" class="mnblnk">{$l_stats}</a></span>
out;

echo <<<out
</td>
</tr>
</table>

{$userBoxes}
out;

if(isset($_GET['step'])){

$tpl=makeUp('stats_bar');
$list_stats_aUsers='';

if($statMonth<10) $statMonth='0'.$statMonth;
$startDate="{$statYear}-{$statMonth}-01 00:00:00";
$endDate="{$statYear}-{$statMonth}-31 23:59:59";

$uSql="select poster_id, poster_name, count(*) as pcount from $Tp where poster_id!=0 and post_time>='{$startDate}' and post_time<='{$endDate}' group by poster_id order by pcount desc limit {$limits}";

if(($DB=='mysql' and $res=mysql_query($uSql) and mysql_num_rows($res)>0 and $cols=mysql_fetch_row($res)) OR ($DB=='mysqli' and $res=mysqli_query($mysqlink, $uSql) and mysqli_num_rows($res)>0 and $cols=mysqli_fetch_row($res))){

echo '<table class="forumsmb"><tr><td>';

do{
$val=$cols[2];
if(!isset($vMax)) $vMax=$val;
$stats_barWidth=round(100*($val/$vMax));
if($stats_barWidth>$stats_barWidthLim) $key='<a href="'.$indexphp.'action=userinfo&amp;user='.$cols[0].'" class="mnblnk">'.$cols[1].'</a>';
else{
$key2='<a href="'.$indexphp.'action=userinfo&amp;user='.$cols[0].'" class="mnblnk">'.$cols[1].'</a>';
$key='<a href="'.$indexphp.'action=userinfo&amp;user='.$cols[0].'" class="mnblnk">...</a>';
}
$list_stats_aUsers.=ParseTpl($tpl);
}
while( ($DB=='mysql' and $cols=mysql_fetch_row($res)) OR ($DB=='mysqli' and $cols=mysqli_fetch_row($res)) );
}

echo $list_stats_aUsers.'</td></tr></table>';

}

}

return;
?>