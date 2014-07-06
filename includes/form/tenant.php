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

    const STATUS = trueyou\Tenant_tbl::STATUS;

    private $db;

    public function __construct(MySQLDatabase $db, $sticky=false) {
        parent::__construct($sticky);
        $this->db = $db;
    }

    public function fetch() {
        $result = parent::fetch();

        $thumbnail = array(self::THUMB1, self::THUMB2, self::THUMB3, self::THUMB4, self::THUMB5, self::THUMB_HIGHLIGHT);
        foreach($thumbnail as $thumb) {
                $result[$thumb] = $_FILES[$thumb];
        }

        return $result;
    }

    public function form() { ?>
        <form action="../public/add_content.php?add=<?php echo Navigation::TENANT; ?>"
              enctype="multipart/form-data" method="post">
            Name (TH): <input type="text" name="<?php echo self::NAME_TH; ?>"
                              value="<?php echo $this->fields[self::NAME_TH]; ?>"><br />
            Name (EN): <input type="text" name="<?php echo self::NAME_EN; ?>"
                              value="<?php echo $this->fields[self::NAME_EN]; ?>"><br />

            Description:<br />
            <textarea name="<?php echo self::INFO; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::INFO]; ?></textarea><br/>
            WAP:<br />
            <textarea name="<?php echo self::WAP; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::WAP]; ?></textarea><br/>
            <?php
            $this->category();
            $this->thumbnail();
            echo $this->drop_down_menu(
                $this->db->get_enum(trueyou\Tenant_tbl::name(), trueyou\Tenant_tbl::STATUS),
                self::STATUS);
            echo $this->submit_bt('Add New Tenant');
            ?>

        </form>
    <?php }

    private function thumbnail() { ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        Thumbnail 1:<input type="file" name="<?php echo self::THUMB1?>"><br />
        Thumbnail 2:<input type="file" name="<?php echo self::THUMB2?>"><br />
        Thumbnail 3:<input type="file" name="<?php echo self::THUMB3?>"><br />
        Thumbnail 4:<input type="file" name="<?php echo self::THUMB4?>"><br />
        Thumbnail 5:<input type="file" name="<?php echo self::THUMB5?>"><br />
        Thumbnail Highlight:<input type="file" name="<?php echo self::THUMB_HIGHLIGHT?>"><br />
    <?php }

    private function status() { ?>

    <?php }

    private function drop_down_menu($list, $name, $multi_select=false) {
        $format_name = $name;
        if($multi_select) {
            $multi_select = "multiple";
            $format_name .= '[]';
        }

        $output = "<select name=\"{$format_name}\" {$multi_select}> ";

        foreach($list as $value) {
            $is_select = $this->menu_is_selected($name, $value);
            $output .= "<option value=\"{$value}\" {$is_select} >{$value}</option>";
        }
        $output .= "</select>";
        return $output;
    }

    private function menu_is_selected($field, $menu) {
        $selection = $this->fields[$field];
        if(!empty($selection)) {
            if(is_array($selection) && in_array($menu, $selection) || $selection === $menu)
                    return "selected";
        }

        return '';
    }

    protected function get_all_fields_name()
    {
        return array(
            self::NAME_TH, self::NAME_EN,
            self::ACCESS_CH, self::PRIORITY, self::TRUEYOU_CAT,
            self::INFO, self::WAP,
            //self::THUMB1, self::THUMB2, self::THUMB3, self::THUMB4, self::THUMB5,
            //self::THUMB_HIGHLIGHT,
            self::STATUS
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

    private function category()
    {
        $tbl = trueyou\Tenant_tbl::name();
        echo 'Access Channel: ' . '<br/>';
        echo $this->drop_down_menu(
                $this->db->get_enum($tbl, trueyou\Tenant_tbl::ACCESS_CH, true),
                self::ACCESS_CH, true
            ) . '<br />';

        echo 'Priority: ' . '<br/>';
        echo $this->drop_down_menu(
                $this->db->get_enum($tbl, trueyou\Tenant_tbl::PRIORITY),
                self::PRIORITY
            ) . '<br />';

        echo 'Categories: ' . '<br/>';
        echo $this->drop_down_menu(
                $this->db->get_enum($tbl, trueyou\Tenant_tbl::TUREYOU_CAT),
                self::TRUEYOU_CAT, true
            ) . '<br />';
    }
}

