<title>
    <?php
    if(isset($_GET['add']))
        echo "Add New {$_GET['add']}";
    else
        echo "Add New Content";
    ?>
</title>

<?php 
require_once('../includes/layout/header.php');
require_once('../includes/functions.php');
require_once('../includes/form/form.php');
require_once('../includes/database/database.php');
require_once('../includes/form/form_processor.php');
?>



<div id="main">
	<?php
        $nav = new Navigation();
		echo navigation($nav);
		$select = $_GET['add'];
	?>

	<div id="page">
	<?php

        $add_content = $nav->getMenu()['Add Content'];
        $db = new MySQLDatabase(DB_TRUEYOU);
        $form = null;

		switch ($select) {
			case $add_content['Tenant']->getName():
				$form = new Tenant(true);
//                $add_content['Tenant']->set_selected(true);
				break;

			case $add_content['Privilege']->getName():
				$form = new Privilege($db, true);
//                $add_content['Privilege']->set_selected(true);
				break;

			case $add_content['Branch']->getName():
				$form = new Branch(true);
//                $add_content['Branch']->set_selected(true);
				break;

            default:
                die("{$select} did not match any menu");
		}

    $form->form();

    if($form->is_submitted()) {
        $controller = new FormProcessor($form, $db);
        $controller->execute();
    }


	?>
	</div>
</div>

<?php include('../includes/layout/footer.php'); ?>