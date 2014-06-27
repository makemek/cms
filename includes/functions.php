<?php
require_once('../includes/navigation.php');

function navigation() 
{
	$nav = Navigation::getInstance();
	$content = '<div id="navigation">';
	$content .= $nav->getContent();
	$content .= '</div>';
	return $content;
}
?>