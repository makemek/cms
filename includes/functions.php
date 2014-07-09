<?php
require_once('../includes/navigation.php');

function navigation($nav)
{
	$content = '<div id="navigation">';
	$content .= $nav->getContent();
	$content .= '</div>';
	return $content;
}

function redirect($url)
{
    header('Location: '. $url);
    die();
}
