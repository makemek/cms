<?php
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
require_once('../includes/form/tenant.php');
require_once('../includes/form/privilege.php');
include_once('../includes/layout/header.php');
session_start();


$db = new MySQLDatabase(DB_TRUEYOU);

$form = unserialize($_SESSION['form']);
$form->fetch();
if($form->is_exists($db)) {
    $_SESSION['error'] = $form->get_identifier() . " already exists.";
    redirect($_SESSION['link']);
}


$_SESSION['form'] = serialize($form);


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
<select size="20" name="source" id="source" style="width: 200px"  multiple>
    <?php
    $branch_attrib = trueyou\Branch_tbl::BRANCH;
    $branch_tbl = trueyou\Branch_tbl::name();

    // get branches that are not already add by tenant
    $query = "SELECT $branch_attrib FROM $branch_tbl ";
    $query .= "WHERE " . trueyou\Branch_tbl::BRANCH . " IN (";
    $query .= "SELECT " . trueyou\Tenant_branch_tbl::BNAME . " FROM ". trueyou\Tenant_branch_tbl::name();
    $query .= " WHERE " . trueyou\Tenant_branch_tbl::TENANT_NAME . " <> " . "'{$form->get_field(Tenant::NAME_EN)}'";
    $query .= ")";

    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_NUM))
        echo "<option value={$row[0]}>$row[0]</option>";
    ?>
</select>

<input type="button" id="add" value=">>">
<input type="button" id="remove" value="<<">

<!--TODO: Dynamically insert form here-->
<select size="20" name="target" id="target" width="300" style="width: 200px" multiple>

</select>

<hr />

<form id="form" action="new_content.php" method="POST">
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

    <input id="submit" type="submit" name="submit" value="submit" />

</form>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="javascript/selector.js" ></script>

<?php

include_once('../includes/layout/footer.php');