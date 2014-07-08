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

    $output .= '</tr>';
    return $output;
}

if(isset($_GET['table']) && isset($_GET['store'])) {

    $table = $_GET['table'];
    $store = $_GET['store'];

    ?>

    <table style="width:300px">

        <?php
        echo table_header($db, $table);
        $query = "SELECT * FROM ? WHERE ";
        ?>

    </table>
<?php }

elseif(isset($_GET['table'])) {
    $table = $_GET['table'];
    ?>

    <form action="">
        <table style="width:300px">
            <?php
            echo table_header($db, $table);

            $query = "SELECT * FROM ".$table;
            $stmt = $db->prepare($query);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_NUM)) {
                echo '<tr>';
                echo "<td><input type=\"checkbox\" value=\"$row[1]\"></td>";
                foreach($row as $col)
                    echo '<td>'.$col.'</td>';
                echo '</tr>';
            }
            ?>
        </table>
        <input type="submit" value="Add">
    </form>
<?php }

include_once('../includes/layout/footer.php');


