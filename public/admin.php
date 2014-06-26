<title>Makemek</title>
<?php include('../includes/layout/header.php'); ?>
<?php include('../includes/navigation.php'); ?>

<?php
	$nav = new Navigation('navigation');
	echo $nav->getHTML();
?>

<?php include('../includes/layout/footer.php'); ?>