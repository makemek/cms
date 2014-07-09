<?php
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
include_once('../includes/layout/header.php');

$db = new MySQLDatabase(DB_TRUEYOU);
?>

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

<?php
//get from URL $_GET['store'] and $_GET['table']

function table_header(MySQLDatabase $db, $table) {
    $cols = $db->get_table_column_name($table);

    $output = '<tr>';
    $output .= "<th>Add</th>"; // checkbox column
    foreach($cols as $col)
        $output .= "<th>{$col}</th>";

    $output .= "<th>FLOOR1</th>";
    $output .= "<th>FLOOR2</th>";

    $output .= '</tr>';
    return $output;
}

if(isset($_GET['store'])) {
    $store = $_GET['store'];

    ?>

    <table style="width:300px">

        <?php
        echo table_header($db, trueyou\Branch_tbl::name());
        $query = "select * from branch where bname = (select bname from tenant_branch)";
        $result = $db->query($query);

        ?>

    </table>
<?php }

else {
    ?>

    <form action="with_branch.php">
        <table style="width:300px">
            <?php
            echo table_header($db, trueyou\Branch_tbl::name());

//            $query = "select * FROM branch JOIN tenant_branch AS tb on branch.bname = tb.bname";
            $query = "SELECT * FROM " . trueyou\Branch_tbl::name();
            $stmt = $db->prepare($query);
            $stmt->execute();

            echo 'Total Result: '.$stmt->rowCount().'<br/>';
            while($row = $stmt->fetch(PDO::FETCH_NUM)) {
                echo '<tr>';
                echo "<td><input type=\"checkbox\" name=\"$row[0]\"></td>";
                foreach($row as $col)
                    echo '<td>'.$col.'</td>';
                echo "<td><input type=\"number\" name=\"floor1[]\" min=\"0\" max=\"9999\"></td>";
                echo "<td><input type=\"number\" name=\"floor2[]\" min=\"0\" max=\"9999\"></td>";
                echo '</tr>';
            }
            ?>
        </table>
        <input type="submit" value="Add">
    </form>
<?php }

include_once('../includes/layout/footer.php');

class Table_form extends Form implements Record {

    private $header;
    private $row;

    private $db_table_name;

    const STRING_FIELD = 0;
    const NUMERIC_FIELD = 1;

    private $string_field = array();
    private $numeric_field = array();

    public function __construct($header, $row=null, $db_table_name) {
        $this->db_table_name = $db_table_name;

        $this->header = $header;
        $this->row = $row;
    }

    public function get_associate_db_table()
    {
        return $this->db_table_name;
    }

    public function fetch()
    {
        // TODO: Implement fetch() method.
    }

    public function form()
    {
        // TODO: Implement form() method.

    }
    protected function get_all_string_fields()
    {
        // TODO: Implement get_all_string_fields() method.
    }

    protected function get_all_numeric_fields()
    {
        // TODO: Implement get_all_numeric_fields() method.
    }

    protected function validate($input)
    {
        // TODO: Implement validate() method.
    }

    public function add_row($row, $has_input, $field_type) {
        if($has_input) {
            switch($field_type) {
                case self::STRING_FIELD:
                    $this->string_field[] = $field_type;
                    break;
                case self::NUMERIC_FIELD:
                    $this->numeric_field[] = $field_type;
                    break;

                default:
                    echo 'Incorrect field_type assume string type';
                    $this->string_field[] = $field_type;
            }
        }

        $this->row[] = $row;
    }
}


