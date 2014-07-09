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
        echo table_header($db, $table);
        $query = "SELECT * FROM ? WHERE ";
        ?>

    </table>
<?php }

else {
    ?>

    <form action="">
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
                echo "<td><input type=\"checkbox\" value=\"$row[0]\"></td>";
                foreach($row as $col)
                    echo '<td>'.$col.'</td>';
                echo "<td><input type=\"text\" name=\"floor1[]\"</td>";
                echo "<td><input type=\"text\" name=\"floor2[]\"</td>";
                echo '</tr>';
            }
            ?>
        </table>
        <input type="submit" value="Add">
    </form>
<?php }

include_once('../includes/layout/footer.php');


