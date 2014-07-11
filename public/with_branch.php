<?php
session_start();
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
require_once('../includes/form/form.php');
require_once('../includes/form/form_processor.php');
require_once('../includes/table_form.php');
include_once('../includes/layout/header.php');


$db = new MySQLDatabase(DB_TRUEYOU);

$table = new Table();
$controller = new Priv_branch_controller($table, $db);
$table = $controller->read();

echo '<form action="with_branch.php" method="post" >';
$table->display();
echo '<input type="submit" name="submit" value="ADD" />';
echo '</form>';

echo '<pre>'; var_dump($_POST); echo '</pre>';
?>

<?php
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