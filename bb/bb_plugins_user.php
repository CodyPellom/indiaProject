<?php
if (!defined('INCLUDED776')) die ('Fatal error.');

/* Gender pref */

if($action=='registernew') {
if(isset($_POST['user_custom3'])) $user_custom3=(int)$_POST['user_custom3']+0; else $user_custom3=0;
}

elseif($action=='prefs'){
if(isset($userData[$dbUserSheme['user_custom3'][0]])) $user_custom3=(int)$userData[$dbUserSheme['user_custom3'][0]];
else $user_custom3=0;
}

elseif(($enableNewRegistrations and $action=='register') or ($enableProfileUpdate and $action=='editprefs')){
if(isset($_POST['user_custom3'])) $user_custom3=(int)$_POST['user_custom3']+0;
}

$genderDropDown=makeValuedDropDown($genders, 'user_custom3');

if($action=='prefs' or $action=='registernew' or $action=='editprefs' or $action=='register'){
if(!isset($l_gender)) $l_gender='Gender';
$genderForm=ParseTpl(makeUp('addon_gender_userform'));
}

/* --Gender pref */
?>