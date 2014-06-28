<?php
require_once('../includes/navigation.php');

abstract class Form
{
    private $fields; // assoc array of name => value
    protected $sticky = false;

    public function __construct() {
        $this->fields = $this->form_values($this->fields);
    }

    public abstract function form();
    protected abstract function form_values($fields);

    public function fetch() {
        if(!isset($_POST['submit']))
            return null;

        $result = array();

        foreach($this->fields as $name => $value) {
            $input = $_POST[$name];
            $result[$name] = $input;

            if($this->sticky)
                $this->fields[$name] = $input;
        }

        return $result;
    }

    protected function submit_bt($name) {
        return "<input type=\"submit\" name=\"submit\" value=\"{$name}\"";
    }

    public function setStickyForm($is_sticky) {
        $this->sticky = $is_sticky;
    }

    protected function getValue($key) {
        return $this->fields[$key];
    }
}

class Tenant extends Form
{
    public function form() { ?>
        <form action="..public/add_tenant.php" method="post">
            Title: <input type="text" name="title" value=""><br />
            Description: <input type="text" name="description" value=""><br />
            <input type="submit" name="submit" value="submit">
        </form>
    <?php }

    public function form_values($fields)
    {
        // TODO: Implement form_values() method.
    }
}

class Privilage extends Form
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

    public function form_values($fields)
    {
        $fields['branch'] = '';
    }
}

class Branch extends Form
{
    const BRANCH = 'branch';
    const LAT = 'lat';
    const LONG = 'long';
    const FLOOR1 = 'floor1';
    const FLOOR2 = 'floor2';

    public function form() { ?>
        <form action="../public/add_branch.php" method="post">
            Branch: <input type="text" name="<?php echo self::BRANCH ?>"
                           value="<?php $this->getValue(self::BRANCH)?>"><br />
            Latitude: <input type="number" name="<?php echo self::LAT ?>"
                             value="<?php $this->getValue(self::LAT)?>"><br />
            Longitude: <input type="number" name="<?php echo self::LONG ?>"
                              value="<?php $this->getValue(self::LONG)?>"><br />
            Floor (if provided): <input type="number" name="<?php echo self::FLOOR1 ?>"
                                        value="<?php $this->getValue(self::FLOOR1)?>"><br />
            Floor (if provided): <input type="number" name="<?php echo self::FLOOR2 ?>"
                                        value="<?php $this->getValue(self::FLOOR2)?>"><br />
            <input type="submit" name="submit" value="submit">
        </form>
    <?php }

    public function form_values($fields)
    {
        $fields[self::BRANCH] = '';
        $fields[self::LAT] = '';
        $fields[self::LONG] = '';
        $fields[self::FLOOR1] = '';
        $fields[self::FLOOR2] = '';

        return $fields;
    }
}
?>