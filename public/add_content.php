<title>Add new content</title>

<?php 
require_once('../includes/layout/header.php');
require_once('../includes/navigation.php');
require_once('../includes/form.php');
?>



<div id="main">
	<?php 
		$nav = Navigation::getInstance();

		$select = $_GET['add'];
		$nav->set_selected($select);

		echo $nav->getContent();
	?>

	<div id="page">
	<?php

		
		switch ($select) {
			case $nav->getMenu()['TENANT']:
				$tenant = new Tenant();
				$tenant->form();
				break;
			
			case $nav->getMenu()['PRIV']:
				$priv = new Privilage();
				$priv->form();
				break;

			case $nav->getMenu()['BRANCH']:
				$branch = new BRANCH();
				$branch->form();
				break;

			default:
				# code...
				break;
		}
		
	?>
	</div>
</div>

<?php include('../includes/layout/footer.php'); ?>