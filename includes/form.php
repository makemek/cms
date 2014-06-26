<?php
require_once('../includes/navigation.php');

interface Form
{
	public function form();

}

class Tenant implements Form
{
	public function form() { ?>
		<form action="new_content.php?form=<?php echo Navigation::TENANT; ?>" method="post">
			Title: <input type="text" name="title" value=""></input><br />
			Description: <input type="text" name="description" value=""><br />
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}

class Privilage implements Form
{
	public function form() { ?>
		<form action="new_content.php?form=<?php echo Navigation::PRIV; ?>" method="post">
			Privilage Information: <input type="text" name="info" value=""></input><br />
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}

class Branch implements Form
{
	public function form() { ?>
		<form action="new_content.php?form=<?php echo Navigation::BRANCH; ?>" method="post">
			Branch Name: <input type="text" name="branch" value=""></input><br />
			Latitude: <input type="number" name="lat" value=""></input><br />
			Longtitude: <input type="number" name="lat" value=""></input><br />
			Floor (if provided): <input type="number" name="lat" value=""></input><br />
			Floor (if provided): <input type="number" name="lat" value=""></input><br />
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}
?>