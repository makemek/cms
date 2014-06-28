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
        $branch->setStickyForm(true);
        $branch->form();

		// get data
        $input = $branch->fetch();

		// issue a query


		// insert to a database


		// redirect back to add_content.php
		?>
	</div>
</div>

<?php include('../includes/layout/footer.php'); ?>