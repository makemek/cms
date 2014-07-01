<?php
// will be moved to add_content.php

/*
Data insertion will be performed on this page.
*/

include('../includes/layout/header.php');
require_once('../includes/form.php');
require_once('../includes/functions.php');
require_once('../includes/database/database.php');
?>


<div id="main">	
	<?php echo navigation(); ?>

	<div id="page">
		<?php

		$branch = new Branch(true);
        $branch->form();

        if($branch->is_submitted()) {
            // get data
            $input = $branch->fetch();

            // issue a query
            $db = new MySQLDatabase(DB_TRUEYOU);
            $query = "INSERT INTO branch"  . '(BNAME, LATITUDE, LONGITUDE, FLOOR1, FLOOR2) ' .
                'VALUES(?, ?, ?, ?, ?)';
            echo $query . '<br />';
            $stmt = $db->prepare($query);

            //$input[Branch::BRANCH] = null;

            echo '<pre>'; echo print_r($input); echo '</pre>';


		    // insert to a database
            $stmt->execute(array(
                $input[Branch::BRANCH],
                $input[Branch::LAT],
                $input[Branch::LONG],
                $input[Branch::FLOOR1],
                $input[Branch::FLOOR2]
            ));


            // display message
            echo 'Row(s) affected: ' . $stmt->rowCount();

            // redirect back to add_content.php
        }
		?>
	</div>
</div>

<?php include('../includes/layout/footer.php'); ?>