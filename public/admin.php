<title>Makemek</title>
<?php include('../includes/layout/header.php'); ?>
<?php include('../includes/navigation.php'); ?>


<div id="main">
	<div id="navigation">
		&nbsp;
		<?php echo $nav = Navigation::getInstance()->getHTML(); ?>
	</div>

	<div id="page">
		<p>Welcome to Admin page</p>
	</div>
</div>


<?php include('../includes/layout/footer.php'); ?>