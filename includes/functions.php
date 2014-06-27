<?php
require_once('../includes/navigation.php');

function navigation() 
{
	$nav = Navigation::getInstance();

	if(isset($_GET['add'])) {
		$select = $_GET['add'];
		$nav->set_selected($select);
	}

	return $nav->getContent();
}
?>