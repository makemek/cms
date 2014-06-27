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
	private function code() { ?>
		Campaign Code: <input type="text" name="camp_code" value=""></input><br />
		USSD: <input type="text" name="ussd" value=""></input><br />
		SMS: <input type="text" name="sms" value=""></input><br />

	<?php }

	private function card() { ?>
		Card: <br />
		<input type="checkbox" name="card" value="">No Card</input><br />
		<input type="checkbox" name="card" value="">Red Card</input><br />
		<input type="checkbox" name="card" value="">Black Card</input><br />

	<?php }

	private function date() { ?>
		Start date: <input type="date" name="start_date" value=""></input><br />
		Expire date: <input type="date" name="exp_date" value=""></input><br />

	<?php }

	public function form() { ?>
		<form action="new_content.php?form=<?php echo Navigation::PRIV; ?>" method="post">
			Privilage Information: <input type="text" name="info" value=""></input><br />
			<?php echo $this->code(); ?>
			<?php echo $this->date(); ?>
			<?php echo $this->card(); ?>
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}

class Branch implements Form
{
	// constants for calling outside the class

	public function form() { ?>
		<form action="add_branch.php" method="post">
			Branch Name: <input type="text" name="branch" value=""></input><br />
			Latitude: <input type="number" name="lat" value=""></input><br />
			Longtitude: <input type="number" name="long" value=""></input><br />
			Floor (if provided): <input type="number" name="floor1" value=""></input><br />
			Floor (if provided): <input type="number" name="floor2" value=""></input><br />
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}
?>