<title>Add new content</title>
<?php include('../includes/layout/header.php'); ?>
<?php include('../includes/navigation.php'); ?>



<div id="main">
	<?php echo Navigation::getInstance()->getHTML(); ?>	

<?php if(!isset($_GET['add'])) { ?>
	<div id="page">
		<form action="add_content.php" method="post">
			Add: 
			<select name="add">
				<option value="tenant">Tenant</option>
				<option value="priv">Privilage</option>
				<option value="Branch">Branch</option>
			</select>
		<input type="submit" name="submit" value="GO"/>
		</form>
		<hr />
	</div>

<?php } else { 


}

?>

</div>

<?php include('../includes/layout/footer.php'); ?>