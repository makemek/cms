<?php
require_once('../includes/navigation.php');

interface Form
{
	public function form();
}

class Tenant implements Form
{
	public function form() { ?>
		<form action="..public/add_tenant.php" method="post">
			Title: <input type="text" name="title" value=""><br />
			Description: <input type="text" name="description" value=""><br />
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}

class Privilage implements Form
{
	private function code() { ?>
		Campaign Code: <input type="text" name="camp_code" value=""><br />
		USSD: <input type="text" name="ussd" value=""><br />
		SMS: <input type="text" name="sms" value=""><br />

	<?php }

	private function card() { ?>
		Card: <br />
		<input type="checkbox" name="card" value="">No Card<br />
		<input type="checkbox" name="card" value="">Red Card<br />
		<input type="checkbox" name="card" value="">Black Card<br />

	<?php }

	private function date() { ?>
		Start date: <input type="date" name="start_date" value=""><br />
		Expire date: <input type="date" name="exp_date" value=""><br />

	<?php }

	public function form() { ?>
		<form action="../public/add_priv.php; ?>" method="post">
			<label for="info">Privilage Information:</label> <input type="text" name="info" value=""><br />
			<?php $this->code(); ?>
			<?php $this->date(); ?>
			<?php $this->card(); ?>
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}

class Branch implements Form
{
	// constants for calling outside the class

	public function form() { ?>
		<form action="../public/add_branch.php" method="post">
            Branch: <input type="text" name="branch" value=""><br />
            Latitude: <input type="number" name="lat" value=""><br />
			Longitude: <input type="number" name="long" value=""><br />
			Floor (if provided): <input type="number" name="floor1" value=""><br />
			Floor (if provided): <input type="number" name="floor2" value=""><br />
			<input type="submit" name="submit" value="submit">
		</form>
	<?php }
}
?>