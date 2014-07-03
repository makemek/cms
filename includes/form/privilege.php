<?php
require_once('form.php');
require_once(__DIR__ . '/../database/table_config.php');

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

        <form action="../public/add_content.php?add=Privilege" method="post">
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