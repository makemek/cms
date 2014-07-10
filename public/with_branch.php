<?php
session_start();
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
require_once('../includes/form/form.php');
require_once('../includes/form/form_processor.php');
require_once('../includes/table_form.php');
include_once('../includes/layout/header.php');


$db = new MySQLDatabase(DB_TRUEYOU);

if(isset($_POST['type']))
{
    switch($_POST['type'])
    {
        case 'tenant':
            $form = new Tenant($db, true);
            break;
        case 'priv':
            $form = new Privilege($db, true);
            break;

        default:
            redirect('admin.php');
    }
}
//var_dump($form);


$table = new Table();
$table->display();
$controller = new Priv_branch_controller($table, $db);
$table = $controller->read();
echo '<form action="with_branch.php" method="get" >';
$table->display();
echo '<input type="submit" name="submit" value="ADD" />';
echo '</form>';
//var_dump($table);

$p = new Privilege($db);
$priv = new Priv_form_controller($p, $db);
$priv->read()->form();
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

//if(isset($_GET['store'])) {
//    $store = $_GET['store'];
//
//    ?>
<!---->
<!--    <table style="width:300px">-->
<!---->
<!--        --><?php
//        echo table_header($db, trueyou\Branch_tbl::name());
//        $query = "select * from branch where bname = (select bname from tenant_branch)";
//        $result = $db->query($query);
//
//        ?>
<!---->
<!--    </table>-->
<?php //}
//
//else {
//   $table = new Table_form(array('asdf'));
//   $table->add_row('<input name="rew[]" value="thing" />');
//    ?>
<!---->
<!--    <form action="with_branch.php">-->
<!--        <table style="width:300px">-->
<!--            --><?php
//            echo table_header($db, trueyou\Branch_tbl::name());
//
////            $query = "select * FROM branch JOIN tenant_branch AS tb on branch.bname = tb.bname";
//            $query = "SELECT * FROM " . trueyou\Branch_tbl::name();
//            $stmt = $db->prepare($query);
//            $stmt->execute();
//
//            echo 'Total Result: '.$stmt->rowCount().'<br/>';
//            while($row = $stmt->fetch(PDO::FETCH_NUM)) {
//                echo '<tr>';
//                echo "<td><input type=\"checkbox\" name=\"$row[0]\"></td>";
//                foreach($row as $col)
//                    echo '<td>'.$col.'</td>';
//                echo "<td><input type=\"number\" name=\"floor1[]\" min=\"0\" max=\"9999\"></td>";
//                echo "<td><input type=\"number\" name=\"floor2[]\" min=\"0\" max=\"9999\"></td>";
//                echo '</tr>';
//            }
//            ?>
<!--        </table>-->
<!--        <input type="submit" value="Add">-->
<!--    </form>-->
<?php //}

include_once('../includes/layout/footer.php');



