<?php
if (!defined('INCLUDED776')) die ('Fatal error.');
/*
	-----------------------------------------------
	Anti-Spam filtering protection addon
	Author: lime (as_ziggy@yahoo.com)
	Developing: Paul Puzyrev / miniBB.com
	Release date: October 24, 2006
	Most recent update: December 6, 2018
	Description: Forbid guests and newcomers to post urls, links, email addresses and specified dictionary words
	-----------------------------------------------
*/

//	Forbidden spam elements declared (CONFIGURABLE SECTION)
//	-----------------------------------------------------------------------
if(isset($membersRuleDict) and $membersRuleDict and $user_id>1) $anti_guest_terms=array(); else $anti_guest_terms=array('www.','http://','https://','[url', '@', '.com', '.net', '.info', '.org', '.ru');
//	-----------------------------------------------------------------------

	if(isset($_POST['topicTitle'])) $topicTitle=$_POST['topicTitle']; else $topicTitle='';
	if(isset($_POST['postText'])) $postText=$_POST['postText']; else $postText='';
	$guest_offence=0;
	$checkedText=operate_string($topicTitle).operate_string($postText);
	
	//fix to not include the original forum or website URL
	$checkedText=preg_replace(array("#http[s]*://".$main_url."#is", "#\[url=".$main_url."#is", "#\[urlc=".$main_url."#is", "#\[img\]".$main_url."#is", "#\[imgs\]".$main_url."#is", "#\[imgs=".$main_url."#is", "#\[img=".$main_url."#is", "#".$main_url."#is"), '', $checkedText);

	if(isset($site_url)) $checkedText=preg_replace(array("#http[s]*://".$site_url."#is", "#\[url=".$site_url."#is", "#\[urlc=".$site_url."#is", "#\[img\]".$site_url."#is", "#\[imgs\]".$site_url."#is", "#\[imgs=".$site_url."#is", "#\[img=".$site_url."#is", "#".$site_url."#is"), '', $checkedText);
	
if(sizeof($anti_guest_terms)>0){
		foreach($anti_guest_terms as $v){
			if(substr_count(strtolower_unicode($checkedText), strtolower_unicode($v))>0){
				$guest_offence=1;
				break;
			}
		}
}

	if($guest_offence==0){
	//check for dictionary, if no URLs found
	include($pathToFiles.'addon_anti_guest_dict.php');
		foreach($forbidden_text as $v){
			if(substr_count(strtolower_unicode($checkedText), strtolower_unicode($v))>0){
				$guest_offence=2;
				$found_word=$v;
				break;
			}
		}
	
	}

	//If forbidden term is detected in a post, show warning page
	if($guest_offence>0){
		//Setting warning page variables

		$errorMSG=$anti_guest_title;
		$title.=$anti_guest_title;

		$displayFormElements=array('topicTitle'=>1, 'postText'=>1);

		if($guest_offence==1) $antiWarn=$anti_guest_msg;
		elseif($guest_offence==2) $antiWarn=str_replace('{FORBIDDEN_WORD}', $found_word, $anti_guest_dict);

		if($membersRule>0) $antiWarn.=str_replace('{POSTS_REQUIRED}', $membersRule, $anti_guest_rule1);
		else $antiWarn.=$anti_guest_rule2;

		if(isset($_POST['prevForm']) and (integer)$_POST['prevForm']+0==1){
		unset($_POST['topicTitle']);
		$_POST['postText']=$antiWarn;
		//exclude condition for preview
		}

		else{
		$l_postholdRepeat=$l_editPost;

		include($pathToFiles.'bb_func_posthold.php');

		//Loading header & warning page
		echo load_header();
		echo ParseTpl(makeUp('main_posthold'));
    display_footer();
		exit;
		}
	}
?>