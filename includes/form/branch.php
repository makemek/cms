<?php
require_once('form.php');
require_once(__DIR__ . '/../database/table_config.php');

class Branch extends Form implements Record
{
    const BRANCH = trueyou\Branch_tbl::BRANCH;
    const LAT = trueyou\Branch_tbl::LATITUDE;
    const LONG = trueyou\Branch_tbl::LONGITUDE;

    public function form() { ?>
        <form action="../public/add_content.php?add=<?php echo Navigation::BRANCH; ?>" method="post">
            *Branch: <input type="text" name="<?php echo self::BRANCH ?>" required
                           value="<?php echo $this->fields[self::BRANCH] ?>" maxlength="255">
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
        return array(self::BRANCH);
    }

    public function get_associate_db_table()
    {
        return trueyou\Branch_tbl::name();
    }

    public function validate(MySQLDatabase $db)
    {
        $errors = array();

        if($this->is_exists($db, $this->get_associate_db_table(),
            trueyou\Branch_tbl::BRANCH, $this->get_field(self::BRANCH)) > 0) {
            $errors[] = $this->get_field(self::BRANCH) . " already exist!";
        }

        return $errors;
    }

    protected function get_all_numeric_fields()
    {
        return array(self::LAT, self::LONG);
    }
}
?>