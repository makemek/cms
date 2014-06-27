<?php
require_once('../includes/navigation.php');

interface Form
{
	public function form();
	//public function evaluate(); // fetch entered form
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
	const BRANCH = 'branch';
	const LAT = 'lat';
	const LONG = 'long';
	const FLOOR1 = 'floor1';
	const FLOOR2 = 'floor2';

	public function form() { ?>
		<form action="new_content.php?form=<?php echo Navigation::BRANCH; ?>" method="post">
			Branch Name: <input type="text" name="<?php BRANCH ?>" value=""></input><br />
			Latitude: <input type="number" name="<?php LAT ?>" value=""></input><br />
			Longtitude: <input type="number" name="<?php LONG ?>" value=""></input><br />
			Floor (if provided): <input type="number" name="<?php FLOOR1 ?>" value=""></input><br />
			Floor (if provided): <input type="number" name="<?php FLOOR2 ?>" value=""></input><br />
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}
?>