<title>Add new content</title>

<?php 
require_once('../includes/layout/header.php');
require_once('../includes/navigation.php');
require_once('../includes/form.php');
?>



<div id="main">
	<?php echo Navigation::getInstance()->getContent(); ?>	

	<div id="page">
	<?php
		$select = $_GET['add'];
		
		switch ($select) {
			case Navigation::TENANT:
				$tenant = new Tenant();
				$tenant->form();
				break;
			
			case Navigation::PRIV:
				$priv = new Privilage();
				$priv->form();
				break;

			case Navigation::BRANCH:
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