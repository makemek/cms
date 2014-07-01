<?php
require_once('../includes/navigation.php');

abstract class Form
{
    protected $fields; // assoc array of name => value
    private $sticky = false;

    public function __construct($sticky=false) {
        $this->sticky = $sticky;
        $all_form_elem = $this->get_all_fields_name();
        if(!$all_form_elem) {
            echo "<strong>Warning: Please define field's name for this form.</strong>";
            return;
        }
        foreach($all_form_elem as $elem_name) {
            if($this->is_submitted() && $this->is_sticky() && isset($_POST[$elem_name])) {
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
            if(!empty($_POST[$name]))
                $result[$name] = $_POST[$name];
            else
                $result[$name] = null;
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

interface Record {
    public function get_associate_db_table();
    public function fetch();
}

class Tenant extends Form implements Record
{
    public function form() { ?>
        <form action="..public/add_tenant.php" method="post">
            Title: <input type="text" name="title" value=""><br />
            Description: <input type="text" name="description" value=""><br />
            <input type="submit" name="submit" value="submit">
        </form>
    <?php }

    protected function get_all_fields_name()
    {
        // TODO: Implement get_all_fields_name() method.
    }

    public function get_associate_db_table()
    {
        return TrueYouDB::TENANT_TBL;
    }
}

class Privilege extends Form implements Record
{
    // --- Code Region --- //
    const CAMP_CODE = 'camp_code';
    const USSD = 'ussd';
    const SMS = 'sms';
    // ------------------- //

    // --- Card Region --- //
    const CARD = 'card';
    // ------------------- //

    // --- Date Region --- //
    const START_DATE = 'start_date';
    const EXPIRE_DATE = 'exp_date';
    // ------------------- //

    // --- Privilege Region --- //
    const INFO = 'info';
    // ------------------------ //

    private function code() { ?>
        Campaign Code: <input type="text" name="<?php echo self::CAMP_CODE ?>"
                              value="<?php echo $this->fields[self::CAMP_CODE]; ?>">
        <br />

        USSD: <input type="text" name="<?php echo self::USSD; ?>"
                     value="<?php echo $this->fields[self::USSD]; ?>">
        <br />

        SMS: <input type="text" name="<?php echo self::SMS ?>"
                     value="<?php echo $this->fields[self::SMS]; ?>">
        <br />

    <?php }

    private function box_is_checked($checkbox) {
        $card = $this->fields[self::CARD];
        if(isset($card) && !empty($card))
            if(in_array($checkbox, $this->fields[self::CARD]))
                return "checked=\"checked\"";

        return '';
    }

    private function card() { ?>
        <?php
        // value must match what is defined in a db's table
        $no_card = 'no card';
        $red_card = 'red card';
        $black_card = 'black card';

        ?>
        Card: <br />
        <input type="checkbox" name="<?php echo self::CARD . '[]'; ?>"
               value="<?php echo $no_card ?>"
               <?php echo $this->box_is_checked($no_card)?> >No Card
        <br />

        <input type="checkbox" name="<?php echo self::CARD . '[]'; ?>"
               value="<?php echo $red_card ?>"
               <?php echo $this->box_is_checked($red_card)?> >Red Card
        <br />

        <input type="checkbox" name="<?php echo self::CARD . '[]'; ?>"
               value="<?php echo $black_card ?>"
               <?php echo $this->box_is_checked($black_card)?> >Black Card
        <br />
    <?php }

    private function date() { ?>
        Start date: <input type="date" name="<?php echo self::START_DATE; ?>"
                           value="<?php echo $this->fields[self::START_DATE];?>">
        <br />

        Expire date: <input type="date" name="<?php echo self::EXPIRE_DATE; ?>"
                           value="<?php echo $this->fields[self::EXPIRE_DATE]?>">
        <br />

    <?php }

    public function form() { ?>

        <form action="../public/add_branch.php" method="post">
           Privilege Information: <input type="text" name="<?php echo self::INFO; ?>"
                                         value="<?php echo $this->fields[self::INFO]; ?>">
            <br />
            <?php $this->code(); ?>
            <?php $this->date(); ?>
            <?php $this->card(); ?>
            <input type="submit" name="submit" value="submit">
        </form>
    <?php }

    protected function get_all_fields_name()
    {
        return array(
            self::CAMP_CODE, self::USSD, self::SMS,
            self::CARD,
            self::START_DATE, self::EXPIRE_DATE,
            self::INFO);
    }

    public function fetch() {
        if(!isset($_POST[self::CARD]))
            unset($this->fields[self::CARD]);

        return parent::fetch();
    }

    public function get_associate_db_table()
    {
        return TrueYouDB::PRIVILEGE_TBL;
    }
}

class Branch extends Form implements Record
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

    public function get_associate_db_table()
    {
        return TrueYouDB::BRANCH_TBL;
    }
}
?>