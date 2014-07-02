<?php
// will be moved to add_content.php

/*
Data insertion will be performed on this page.
*/

include('../includes/layout/header.php');
require_once('../includes/form.php');
require_once('../includes/functions.php');
require_once('../includes/database/database.php');
require_once('../includes/form_processor.php');
?>


<div id="main">	
	<?php echo navigation(); ?>

	<div id="page">
		<?php

//        if($branch->is_submitted()) {
//            // get data
//            $input = $branch->fetch();
//
//            // issue a query
//            $db = new MySQLDatabase(DB_TRUEYOU);
//            $query = "INSERT INTO branch"  . '(BNAME, LATITUDE, LONGITUDE, FLOOR1, FLOOR2) ' .
//                'VALUES(?, ?, ?, ?, ?)';
//            echo $query . '<br />';
//            $stmt = $db->prepare($query);
//
//		    // insert to a database
//            $stmt->execute(array(
//                $input[Branch::BRANCH],
//                $input[Branch::LAT],
//                $input[Branch::LONG],
//                $input[Branch::FLOOR1],
//                $input[Branch::FLOOR2]
//            ));
//
//
//            // display message
//            echo $stmt->rowCount() . 'Row(s) affected.';
//
//            // redirect back to add_content.php
//        }


        $form = new Branch();
        $form->form();
        if($form->is_submitted()) {
            $db = new MySQLDatabase(DB_TRUEYOU);
            $controller = new FormProcessor($form, $db);
            $row_affected = $controller->execute();
            echo $row_affected;
        }
		?>
	</div>
</div>

<?php include('../includes/layout/footer.php'); ?>