<?php
require_once('../includes/database/table_config.php');

//TODO Add session to validate form

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
    protected abstract function validate($input);

    public function fetch() {
        if(!$this->is_submitted())
            return null;

        $result = array();

        foreach($this->fields as $name => $value) {
//            if(!empty($_POST[$name]))
                $result[$name] = $_POST[$name];
//            else
//                $result[$name] = null;
        }

        $this->validate($result);

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
        <form action="../../public/add_content.php?add=Tenant" method="post">
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
        return trueyou\Tenant_tbl::name();
    }

    protected function validate($input)
    {
        // TODO: Implement validate() method.
    }
}

class Privilege extends Form implements Record
{
    // --- Code Region --- //
    const CAMP_CODE = trueyou\Priv_tbl::CAMP_CODE;
    const USSD = trueyou\Priv_tbl::USSD;
    const SMS = trueyou\Priv_tbl::SMS;
    // ------------------- //

    // --- Card Region --- //
    const CARD = trueyou\Priv_tbl::CARD;
    const SHOW_CARD = trueyou\Priv_tbl::SHOW_CARD;
    // ------------------- //

    // --- Date Region --- //
    const START_DATE = trueyou\Priv_tbl::START_DATE;
    const EXPIRE_DATE = trueyou\Priv_tbl::EXPIRE_DATE;
    // ------------------- //

    // --- Privilege Region --- //
    const INFO = trueyou\Priv_tbl::TITLE;
    const COND = trueyou\Priv_tbl::CONDITION;
    const OWNER = trueyou\Priv_tbl::STORE;
    // ------------------------ //

    // members //
    private $db;

    public function __construct(MySQLDatabase $db, $sticky=false) {
        parent::__construct($sticky);
        $this->db = $db;
    }

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
        $no_card = 'NO CARD';
        $red_card = 'RED';
        $black_card = 'BLACK';

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

        Show Card: <br />
        <select name="<?php echo self::SHOW_CARD; ?>">
<!--            <option value="No">No</option>-->
<!--            <option value="Show">Show</option>-->
<!--            <option value="Required">Required</option>-->
            <?php
            $enum = $this->db->get_enum(trueyou\Priv_tbl::name(), trueyou\Priv_tbl::SHOW_CARD);
            foreach($enum as $value) {
                $displayTxt = ucfirst(strtolower($value));
                echo "<option value=\"{$value}\">{$displayTxt}</option>";
            }
            ?>
        </select>
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

        <form action="../../public/add_content.php?add=Privilege" method="post">
           Privilege Information:<br />
            <textarea name="<?php echo self::INFO; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::INFO]; ?></textarea>
            <br />

           Condition:<br />
            <textarea name="<?php echo self::COND; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::COND]; ?></textarea>
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
            self::INFO,
            self::CAMP_CODE, self::USSD, self::SMS,
            self::START_DATE, self::EXPIRE_DATE,
            self::CARD, self::COND,
            self::SHOW_CARD
//            self::STORE
            );
    }

    public function fetch() {
        if(!isset($_POST[self::CARD]))
//            unset($this->fields[self::CARD]);
            $_POST[self::CARD] = null;

//        return parent::fetch();

        // for testing
        $result = parent::fetch();
//        $result[self::SHOW_CARD] = 'NO';
        $result[self::OWNER] = 'test';
        return $result;
    }

    public function get_associate_db_table()
    {
        return trueyou\Priv_tbl::name();
    }

    protected function validate($input)
    {
        // TODO: Implement validate() method.
    }
}

class Branch extends Form implements Record
{
    const BRANCH = trueyou\Branch_tbl::BRANCH;
    const LAT = trueyou\Branch_tbl::LATITUDE;
    const LONG = trueyou\Branch_tbl::LONGITUDE;
    const FLOOR1 = trueyou\Branch_tbl::FLOOR1;
    const FLOOR2 = trueyou\Branch_tbl::FLOOR2;

    public function form() { ?>
        <form action="../../public/add_content.php?add=Branch" method="post">
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
        return trueyou\Branch_tbl::name();
    }

    protected function validate($input)
    {
//        if(empty($input[self::BRANCH]))
//            $_SESSION['error'][] = 'Branch cannot be empty';
    }
}
?>