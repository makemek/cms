<?php
// will be moved to add_content.php

/*
Data insertion will be performed on this page.
*/

include('../includes/layout/header.php');
require_once('../includes/form.php');
require_once('../includes/functions.php');
?>


<div id="main">	
	<?php echo navigation(); ?>

	<div id="page">
		<?php

		$branch = new Branch();

		if (!isset($_POST['submit']))
		{
			// display a form
			$branch->form();
		}
		else 
		{
			$branch = $_POST['branch'];
			$lat = $_POST['lat'];
			$long = $_POST['long'];
			$floor1 = $_POST['floor1'];
			$floor2 = $_POST['floor2'];

		}



		// get data


		// issue a query


		// insert to a database


		// redirect back to add_content.php
		?>
	</div>
</div>

<?php include('../includes/layout/footer.php'); ?>