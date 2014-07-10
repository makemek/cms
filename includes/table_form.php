<?php
require_once('form/form.php');
require_once('form/form_processor.php');

class Table {

    private $header;
    private $row;

    public $field_name = array();

    public function __construct($header=array(), $row=array()) {

        $this->header = $header;
        $this->row = $row;
    }

    public function setHeader($header) {
        $this->header = $header;
    }

    public function fetch()
    {
        $result = array();
        foreach($this->field_name as $name) {
            if(isset($_POST[$name]))
                $result[$name] = $_POST[$name];
        }

        return $result;
    }

    private function style() { ?>
        <style>
            table,th,td
            {
                border:1px solid black;
                border-collapse:collapse;
            }
            th,td
            {
                padding:5px;
            }
        </style>
    <?php }


    public function display() { ?>
        <?php $this->style(); ?>
        <table>
            <tr>
                <?php
                foreach($this->header as $col)
                    echo "<th>{$col}</th>"
                ?>
            </tr>

            <tr>
                <?php
                foreach($this->row as $col)
                {
                    echo '<tr>';
                    foreach($col as $c)
                        echo "<td>{$c}</td>";
                    echo '</tr>';
                }
                ?>
            </tr>
        </table>

    <?php }

    public function add_row($row) {
        $this->row[] = $row;
    }
}

abstract class Table_controller implements CRUD
{
    protected $assoc_table;

    public static function get_html_attribute($html, $attrib, $tag)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $tag = $dom->getElementsByTagName($attrib);

        $item = $tag->item(0);
        if(is_object($item) && $item->hasAttributes()) {
            $name = $item->getAttribute($tag);

            $name = str_replace('[]', '', $name);

            return $name;
        }

        return null;
    }
}

use trueyou\Branch_tbl as branch_tbl;

class Priv_branch_controller extends Table_controller
{
    private $tb;
    private $db;

    public function __construct(Table $tb, MySQLDatabase $db) {
        $this->tb = $tb;
        $this->db = $db;
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function read()
    {
        // table header
        $this->tb->setHeader(array('Add', 'Branch', 'Floor1', 'Floor2'));

        $add_cb = '<input type="checkbox" name="add[]" />';
        $f1 = '<input type="number" name="floor1" min="0" max="9999" />';
        $f2 = '<input type="number" name="floor2" min="0" max="9999" />';

        $query = "SELECT * FROM " . branch_tbl::name() . " ORDER BY " . branch_tbl::BRANCH . " ASC";
        $result = $this->db->query($query);
        echo "Total Result: " . $result->rowCount() . '<br />';
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->tb->add_row(array($add_cb, $row[branch_tbl::BRANCH], $f1, $f2));
        }

        return $this->tb;
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

}

class Tenant_branch_controller extends Table_controller
{

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function read()
    {
        // TODO: Implement read() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}