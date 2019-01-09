<?php
if (!defined('INCLUDED776')) die ('Fatal error.');

/* The most recent login by date */
//saving default visit as the first date on registration
if($action=='register' and isset($inss) and $inss==0){
$insMod=array($dbUserSheme['user_customlastvisit'][1]);
${$dbUserSheme['user_customlastvisit'][1]}=date('Y-m-d', strtotime(${$dbUserDate}));
updateArray($insMod, $Tu, $dbUserId, $insres);
}
/* --The most recent login by date */

?>