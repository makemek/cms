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

    private function code() { ?>
        *Campaign Code: <input type="text" name="<?php echo self::CAMP_CODE ?>"
                              value="<?php echo $this->fields[self::CAMP_CODE]; ?>" required="">
        <br />

        *USSD: <input type="text" name="<?php echo self::USSD; ?>"
                     value="<?php echo $this->fields[self::USSD]; ?>" required="">
        <br />

        *SMS: <input type="text" name="<?php echo self::SMS ?>"
                    value="<?php echo $this->fields[self::SMS]; ?>" required="">

    <?php }

    private function card() { ?>
        <?php
        foreach($this->fields[self::CARD] as $opt) { ?>
            <input type="checkbox" name="<?php echo self::CARD . '[]'; ?>"
                   value="<?php echo $opt; ?>">
                <?php echo ucfirst(strtolower($opt)); ?>
            <br />
        <?php }

        ?>
        Show Card: <br />
        <select name="<?php echo self::SHOW_CARD; ?>">
            <?php
            foreach($this->fields[self::SHOW_CARD] as $value) {
                $displayTxt = ucfirst(strtolower($value));
                echo "<option value=\"{$value}\">{$displayTxt}</option>";
            }
            ?>
        </select>
    <?php }

    private function date() { ?>
        *Start date: <input type="date" name="<?php echo self::START_DATE; ?>"
                           value="<?php echo $this->fields[self::START_DATE];?>" required="">
        <br />

        *Expire date: <input type="date" name="<?php echo self::EXPIRE_DATE; ?>"
                            value="<?php echo $this->fields[self::EXPIRE_DATE]?>" required="">

    <?php }

    private function store() { ?>
        <select name="<?php echo self::OWNER; ?>">
            <?php
            foreach($this->fields[self::OWNER] as $opt)
                echo "<option value=\"{$opt}\" >{$opt}</option>";
            ?>
        </select>
    <?php }

    public function form() { ?>

        <form action="../public/with_branch.php" method="post">

            <!-- Args to send to with_branch.php -->
            <input type="hidden" name="type" value="priv" />
            <!------------------------------------->

            Privilege Information:<br />
            <textarea name="<?php echo self::INFO; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::INFO]; ?></textarea>
            <br />

            Condition:<br />
            <textarea name="<?php echo self::COND; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::COND]; ?></textarea>
            <br />

            <?php $this->code(); ?><br />
            <?php $this->date(); ?><br />
            Card:<br/> <?php $this->card(); ?><br />
            Owner: <?php $this->store(); ?><br />
            <?php echo $this->submit_bt('Add new privilege')?>
        </form>
    <?php }

    protected function get_all_string_fields()
    {
        return array(
            self::INFO,
            self::CAMP_CODE, self::USSD, self::SMS,
            self::START_DATE, self::EXPIRE_DATE,
            self::CARD, self::COND,
            self::SHOW_CARD,
            self::OWNER
        );
    }

    public function fetch() {
        if(!isset($_POST[self::CARD]))
            $_POST[self::CARD] = null;

        return parent::fetch();
    }

    public function get_associate_db_table()
    {
        return trueyou\Priv_tbl::name();
    }

    public function validate(MySQLDatabase $db)
    {
        $errors = array();
        if($this->is_exists($db, $this->get_associate_db_table(),
            trueyou\Priv_tbl::CAMP_CODE, $this->get_field(Privilege::CAMP_CODE)) > 0)
            $errors[] = $this->get_field(Privilege::CAMP_CODE) . " already exists!";

        if(count($this->get_field(self::CARD)) == 0)
            $errors[] = "Please select at least one card type";

        // TODO Implement the rest

        return $errors;
    }

    protected function get_all_numeric_fields()
    {
        return array();
    }
}