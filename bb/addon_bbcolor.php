<?php
/*
addon_bbcolor.php : color picker add-on for miniBB 2.
This file is part of miniBB. miniBB is free discussion forums/message board software, supplied with no warranties.
Check COPYING file for more details.
Copyright (C) 2007-2018 Paul Puzyrev. www.minibb.com
Latest File Update: 2018-Jun-06
*/

/* Options */
$splitRow=0;
if(!(isset($is_mobile) and $is_mobile)) {
$colorsArray=array('000000', '610B38', 'DF0101', '8A4B08', 'FF8000', '0B610B', '01DF01', '01DFD7', '08088A', '2E2EFE', '7401DF', 'DF01D7', '585858', 'BDBDBD', 'D0A9F5', 'A9D0F5');
$sq=20;
}
else {
$colorsArray=array('DF0101', 'FF8000', '0B610B', '01DF01', '08088A', '2E2EFE', 'DF01D7', '585858', 'BDBDBD', 'D0A9F5', 'A9D0F5');
$sq=23;
}


if(!isset($l_bb_color)) $l_bb_color='Color Picker';

/* Code */
if (!defined('INCLUDED776')) die ('Fatal error.');

if($splitRow==0){
$tbWidth=$sq*sizeof($colorsArray);
$tbHeight=$sq;
}
else{
$szc=sizeof($colorsArray);
$cols=floor($szc/$splitRow);
$tbWidth=$sq*$splitRow;
$tbHeight=$sq*$cols;
}

$colorPicker='';

$s=0;

foreach($colorsArray as $val) {

$colorPicker.=<<<out
<div style="width:{$sq}px;height:{$sq}px;cursor:crosshair;border:0px;background-color:#{$val};display:inline-block;cursor:crosshair;margin:0px;padding:0px" onclick="javascript:paste_strinL(selektion,3,'[font#{$val}]', '[/font]','');"></div>
out;

$s++;

if($splitRow>0 and $s>=$splitRow) {
$s=0;
$colorPicker.='<br />';
}

}

?>