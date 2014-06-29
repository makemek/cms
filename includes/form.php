<?php
require_once('../includes/navigation.php');

abstract class Form
{
    protected $fields; // assoc array of name => value
    private $sticky = false;

    public function __construct($sticky=false) {
        $this->sticky = $sticky;
        $all_form_elem = $this->get_all_fields_name();
        foreach($all_form_elem as $elem_name) {
            if($this->is_submitted() && $this->is_sticky()) {
                $this->fields[$elem_name] = $_POST[$elem_name];
            }
            else
                $this->fields[$elem_name] = '';
        }
    }

    public abstract function form();
    protected abstract function get_all_fields_name();

    public function fetch() {
        if(!$this->is_submitted())
            return null;

        $result = array();

        foreach($this->fields as $name => $value) {
            $result[$name] = $_POST[$name];
        }

        return $result;
    }

    protected function submit_bt($name) {
        return "<input type=\"submit\" name=\"submit\" value=\"{$name}\" >";
    }

    public function is_submitted() {
        return isset($_POST['submit']);
    }

    public function is_sticky() {
        return $this->sticky;
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

    protected function get_all_fields_name()
    {
        // TODO: Implement get_all_fields_name() method.
    }
}

class Privilege extends Form
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

    protected function get_all_fields_name()
    {
        // TODO: Implement get_all_fields_name() method.
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
                           value="<?php echo $this->fields[self::BRANCH] ?>" maxlength="255">
            <br />

            Latitude: <input type="number" name="<?php echo self::LAT ?>"
                             value="<?php echo $this->fields[self::LAT]?>"
                             min="0" max="90" step="0.0001">
            Longitude: <input type="number" name="<?php echo self::LONG ?>"
                             value="<?php echo $this->fields[self::LONG]?>"
                             min="0" max="90" step="0.0001">
            <br />

            Floor (if provided): <input type="number" name="<?php echo self::FLOOR1 ?>"
                                        value="<?php echo $this->fields[self::FLOOR1]?>"
                                        min="0" max="999">
            Floor (if provided): <input type="number" name="<?php echo self::FLOOR2 ?>"
                                        value="<?php echo $this->fields[self::FLOOR2]?>"
                                        min="0" max="999">
            <br />
            <?php echo $this->submit_bt('Add New Branch') ?>
        </form>
    <?php }

    protected function get_all_fields_name() {
        return array(self::BRANCH, self::LAT, self::LONG, self::FLOOR1, self::FLOOR2);
    }
}
?>