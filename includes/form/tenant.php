<?php
require_once('form.php');
require_once(__DIR__ . '/../database/table_config.php');
require_once(__DIR__ . '/../element_factory.php');

class Tenant extends Form implements Record
{
    const NAME_TH = trueyou\Tenant_tbl::NAME_TH;
    const NAME_EN = trueyou\Tenant_tbl::NAME_EN;

    const ACCESS_CH = trueyou\Tenant_tbl::ACCESS_CH;
    const PRIORITY = trueyou\Tenant_tbl::PRIORITY;
    const TRUEYOU_CAT = trueyou\Tenant_tbl::TUREYOU_CAT;

    const INFO = trueyou\Tenant_tbl::INFO;
    const WAP = trueyou\Tenant_tbl::WAP;

    const STATUS = trueyou\Tenant_tbl::STATUS;

    private $thumb = array();

    public function __construct($sticky=false) {
        parent::__construct($sticky);
        foreach($this->get_thumbnail_const() as $t)
            $this->thumb[] = new Thumbnail($t);
    }

    private function get_thumbnail_const() {
        return array(
            trueyou\Tenant_tbl::THUMB1,
            trueyou\Tenant_tbl::THUMB2,
            trueyou\Tenant_tbl::THUMB3,
            trueyou\Tenant_tbl::THUMB4,
            trueyou\Tenant_tbl::THUMB5,
            trueyou\Tenant_tbl::THUMB_HIGHLIGHT);
    }

    public function fetch() {
        $result = parent::fetch();

        foreach($this->thumb as $thumb) {
                $result[$thumb->getName()] = $thumb->fetch();
        }

        $this->fields = $result;

        return $result;
    }

    public function form() { ?>
        <form action="../public/with_branch.php"
              enctype="multipart/form-data" method="post">

            <!-- Args to send to with_branch.php -->
            <input type="hidden" name="type" value="tenant" />
            <!------------------------------------->

            Name (TH): <input type="text" name="<?php echo self::NAME_TH; ?>"
                              value="<?php echo $this->fields[self::NAME_TH]; ?>"><br />
            *Name (EN): <input type="text" name="<?php echo self::NAME_EN; ?>"
                              value="<?php echo $this->fields[self::NAME_EN]; ?>" required=""><br />

            <hr />

            Description:<br />
            <textarea name="<?php echo self::INFO; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::INFO]; ?></textarea><br/>
            WAP:<br />
            <textarea name="<?php echo self::WAP; ?>"
                      rows="8" cols="30"><?php echo $this->fields[self::WAP]; ?></textarea><br/>

            <hr />

            <?php
            $this->thumbnail();
            echo '<hr />';
            $this->category();
            echo '<hr />';

            echo 'Status: ';
            echo ElementFactory::drop_down_menu($this->fields[self::STATUS], self::STATUS, 0);
            echo '<br />';

            echo $this->submit_bt('Add New Tenant');
            ?>

        </form>
    <?php }

    private function thumbnail() { ?>
<!--        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
has some weired problem serv not response when upload image-->
        <?php
        // note: Uploading image FAIL in PHPStorm IDE (works on WAMP)
        foreach($this->thumb as $t) {
            echo $t->getName() . ': ';
            echo $t->upload_form();
            echo '<br />';
        }

        ?>
    <?php }

    protected function get_all_string_fields()
    {
        return array(
            self::NAME_TH, self::NAME_EN,
            self::PRIORITY,
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
        echo "Access Channel <br />";
        echo ElementFactory::drop_down_menu($this->fields[self::ACCESS_CH], self::ACCESS_CH, 5, true) . '<br />';

        echo 'Catagory <br />';
        echo ElementFactory::drop_down_menu($this->fields[self::TRUEYOU_CAT], self::TRUEYOU_CAT, 0, true) . '<br />';

        echo 'Priority <br />';
        echo ElementFactory::drop_down_menu($this->fields[self::PRIORITY], self::PRIORITY, 0) . '<br />';

    }

    protected function get_all_numeric_fields()
    {
        return array(self::ACCESS_CH, self::TRUEYOU_CAT);
    }

    public static function is_exists($db, $identifier_val)
    {
        $query = "SELECT " . trueyou\Tenant_tbl::NAME_EN . " FROM " . trueyou\Tenant_tbl::name() .
            " WHERE " . trueyou\Tenant_tbl::NAME_EN . " = " . "'$identifier_val'";

        $result = $db->query($query);

        return $result->rowCount();
    }

    /**
     * @return string that use to identify a particular record.
     */
    public static function get_identifier()
    {
        return Tenant::NAME_EN;
    }
}

class Thumbnail implements Record
{
    private $name;

    public function __construct($name){
        $this->name = $name;
    }

    public function get_associate_db_table()
    {
        return trueyou\Tenant_tbl::name();
    }

    public function fetch()
    {
        $file = $_FILES[$this->name];
        //echo '<pre>'; print_r($file); echo '</pre>';

        switch($file['error']) {
            case UPLOAD_ERR_NO_FILE:
            case UPLOAD_ERR_PARTIAL:
                return '';
            case UPLOAD_ERR_OK:
                $success = move_uploaded_file($file['tmp_name'], UPLOAD_DIR . '/' . $file['name']);
                if($success)
                    return $file['name'];
                else
                    return die('Something wrong!');
            default:
                return '';
        }
    }

    public function upload_form() {
        $name = $this->getName();
        return "<input type='file' name=\"{$name}\" accept='image/*'>";
    }

    public function getName() {
        return $this->name;
    }

    public static function is_exists($db, $identifier_val)
    {
        // TODO: Implement is_exists() method.
    }

    /**
     * @return string that use to identify a particular record.
     */
    public static function get_identifier()
    {
        // TODO: Implement get_identifier() method.
    }
}