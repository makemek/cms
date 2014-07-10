<?php
require_once('form/form.php');

class Table {

    private $header;
    private $row;

    public $field_name = array();

    public function __construct($header, $row=null) {

        $this->header = $header;
        $this->row = $row;
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
                        echo "<td>$c</td>";
                    echo '</tr>';
                }
                ?>
            </tr>
        </table>

    <?php }

    private function get_html_attribute($row) {
        $dom = new DOMDocument();
        @$dom->loadHTML($row);
        $tag = $dom->getElementsByTagName('input');

        $item = $tag->item(0);
        if(is_object($item) && $item->hasAttributes()) {
            $name = $item->getAttribute('name');

            $name = str_replace('[]', '', $name);
            echo $name;

            if(!in_array($name, $this->field_name))
                $this->field_name[] = $name;
        }
    }

    public function add_row($row) {
        $this->get_html_attribute($row);
        $this->row[] = $row;
    }
}

class TableController
{
    private $tb;
    private $db;

    public function __construct(Table $tb, MySQLDatabase $db) {
        $this->tb = $tb;
        $this->db = $db;
    }

}
