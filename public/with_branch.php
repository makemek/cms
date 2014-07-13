<?php
session_start();
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
require_once('../includes/form/form.php');
require_once('../includes/form/form_processor.php');
require_once('../includes/table_form.php');
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
<select size="20" name="source" id="source" width="300" style="width: 200px"  multiple>
    <?php
    $query = "SELECT " . trueyou\Branch_tbl::BRANCH . " FROM " . trueyou\Branch_tbl::name() .
        " ORDER BY " . trueyou\Branch_tbl::BRANCH . " ASC";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_NUM))
        echo "<option value={$row[0]}>$row[0]</option>";
    ?>
</select>

<input type="button" id="add" value=">>">
<input type="button" id="remove" value="<<">

<select size="20" name="target" id="target" width="300" style="width: 200px" multiple>

</select>

<hr />

<form id="form" action="with_branch.php" method="POST">
    <table id="table">
        <thead>
        <tr>
            <th>Branch</th>
            <th>Floor1</th>
            <th>Floor2</th>
        </tr>
        </thead>


        <tbody id="tableBody">

        </tbody>
    </table>

    <input id="submit" type="submit" value="submit" />

</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="javascript/selector.js" ></script>

<?php
var_dump($_POST);
////get from URL $_GET['store'] and $_GET['table']
//
//function table_header(MySQLDatabase $db, $table) {
//    $cols = $db->get_table_column_name($table);
//
//    $output = '<tr>';
//    $output .= "<th>Add</th>"; // checkbox column
//    foreach($cols as $col)
//        $output .= "<th>{$col}</th>";
//
//    $output .= "<th>FLOOR1</th>";
//    $output .= "<th>FLOOR2</th>";
//
//    $output .= '</tr>';
//    return $output;
//}
//
//

include_once('../includes/layout/footer.php');