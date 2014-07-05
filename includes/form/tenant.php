<?php
require_once('form.php');
require_once(__DIR__ . '/../database/table_config.php');

class Tenant extends Form implements Record
{
    const NAME_TH = trueyou\Tenant_tbl::NAME_TH;
    const NAME_EN = trueyou\Tenant_tbl::NAME_EN;

    const ACCESS_CH = trueyou\Tenant_tbl::ACCESS_CH;
    const PRIORITY = trueyou\Tenant_tbl::PRIORITY;
    const TRUEYOU_CAT = trueyou\Tenant_tbl::TUREYOU_CAT;

    const INFO = trueyou\Tenant_tbl::INFO;
    const WAP = trueyou\Tenant_tbl::WAP;

    const THUMB1 = trueyou\Tenant_tbl::THUMB1;
    const THUMB2 = trueyou\Tenant_tbl::THUMB2;
    const THUMB3 = trueyou\Tenant_tbl::THUMB3;
    const THUMB4 = trueyou\Tenant_tbl::THUMB4;
    const THUMB5 = trueyou\Tenant_tbl::THUMB5;
    const THUMB_HIGHLIGHT = trueyou\Tenant_tbl::THUMB_HIGHLIGHT;

    private $db;

    public function __construct(MySQLDatabase $db, $sticky=false) {
        parent::__construct($sticky);
        $this->db = $db;
    }

    public function form() { ?>
        <form action="../public/add_content.php?add=<?php echo Navigation::TENANT; ?>" method="post">
            Name (TH): <input type="text" name="<?php echo Tenant::NAME_TH ?>" value=""><br />
            Name (EN): <input type="text" name="<?php echo Tenant::NAME_EN ?>" value=""><br />

            Description: <input type="text" name="description" value=""><br />
            <input type="submit" name="submit" value="submit">
        </form>
    <?php }

    private function access_ch() { ?>
        <select name = <?php echo self::ACCESS_CH; ?> >
            <?php
            $enum = $this->db->get_enum(trueyou\Tenant_tbl::name(), trueyou\Tenant_tbl::ACCESS_CH);
            foreach($enum as $value) {
                $txt = ucfirst($value);
                echo "<option value=\"{$txt}\"></option>";
            }
            ?>
        </select>
    <?php }

    protected function get_all_fields_name()
    {
        return array(
            self::NAME_TH, self::NAME_EN,
            self::ACCESS_CH, self::PRIORITY, self::TRUEYOU_CAT,
            self::INFO, self::WAP,
            self::THUMB1, self::THUMB2, self::THUMB3, self::THUMB4, self::THUMB5,
            self::THUMB_HIGHLIGHT
        );
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