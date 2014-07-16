<?php
require_once('form.php');
require_once(__DIR__ . '/../database/table_config.php');

class Branch extends Form implements Record
{
    const BRANCH_EN = trueyou\Branch_tbl::BRANCH_EN;
    const BRANCH_TH = trueyou\Branch_tbl::BRANCH_TH;
    const LAT = trueyou\Branch_tbl::LATITUDE;
    const LONG = trueyou\Branch_tbl::LONGITUDE;

    public function form() { ?>
        <form action="../public/add_content.php?add=<?php echo Navigation::BRANCH; ?>" method="post">
            *Branch TH: <input type="text" name="<?php echo self::BRANCH_TH ?>" required
                           value="<?php echo $this->fields[self::BRANCH_TH] ?>" maxlength="255"><br />

            Branch EN: <input type="text" name="<?php echo self::BRANCH_EN ?>" required
                               value="<?php echo $this->fields[self::BRANCH_EN] ?>" maxlength="255">
            <br />

            Latitude: <input type="number" name="<?php echo self::LAT ?>"
                             value="<?php echo $this->fields[self::LAT]?>"
                             min="0" max="90" step="0.0001">
            Longitude: <input type="number" name="<?php echo self::LONG ?>"
                              value="<?php echo $this->fields[self::LONG]?>"
                              min="0" max="90" step="0.0001">
            <br />

            <?php echo $this->submit_bt('Add New Branch') ?>
        </form>
    <?php }

    protected function get_all_string_fields() {
        return array(self::BRANCH_TH, self::BRANCH_EN);
    }

    public function get_associate_db_table()
    {
        return trueyou\Branch_tbl::name();
    }

    public function validate(MySQLDatabase $db)
    {
        $errors = array();

        if($this->is_exists($db, $this->get_associate_db_table(),
            trueyou\Branch_tbl::BRANCH_TH, $this->get_field(self::BRANCH_TH)) > 0) {
            $errors[] = $this->get_field(self::BRANCH_TH) . " already exist!";
        }

        return $errors;
    }

    protected function get_all_numeric_fields()
    {
        return array(self::LAT, self::LONG);
    }
}
?>