<?php
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
require_once('../includes/form/tenant.php');
require_once('../includes/form/privilege.php');
require_once('../includes/session_config.php');
include_once('../includes/layout/header.php');
session_start();

function generateQuery($type, Form $form) {
    $query = '';
    switch($type) {
        case trueyou\Tenant_tbl::name():
            $query = "SELECT " . trueyou\Branch_tbl::BRANCH_TH . " FROM " . trueyou\Branch_tbl::name();
            $query .= " WHERE " . trueyou\Branch_tbl::BRANCH_TH . " NOT IN (";
            $query .= "SELECT " . trueyou\Tenant_branch_tbl::BNAME . " FROM ". trueyou\Tenant_branch_tbl::name();
            $query .= " WHERE " . trueyou\Tenant_branch_tbl::TENANT . " = " . "'{$form->get_field(Tenant::NAME_EN)}'";
            $query .= ")";
            break;

        case trueyou\Priv_tbl::name():
            $query = "SELECT " . trueyou\Branch_tbl::BRANCH_TH . " FROM " . trueyou\Branch_tbl::name();
            $query .= " WHERE " . trueyou\Branch_tbl::BRANCH_TH . " NOT IN (";
            $query .= "SELECT " . trueyou\Priv_branch_tbl::BNAME . " FROM ". trueyou\Priv_branch_tbl::name();
            $query .= " WHERE " . trueyou\Priv_branch_tbl::CAMP_CODE . " = " . "'{$form->get_field(Privilege::CAMP_CODE)}'";
            $query .= ")";
            break;
    }

    return $query;
}

$db = new MySQLDatabase(DB_TRUEYOU);

/**
 * @var $form Form
 **/

$form = unserialize($_SESSION[FORM]);
$form->fetch();
$errors = $form->validate($db);
if(count($errors) > 0) {
    $_SESSION[ERROR] = $errors;
    $url = $_SESSION[LINK];
    redirect('../' . $url); // back to previous
}

$_SESSION[FORM] = serialize($form);


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

<form id="branch_form" action="new_content.php" method="POST">
    <select size="20" id="source" style="width: 200px"  multiple>
        <?php

        // get branches that are not already add
        $query = generateQuery($form->get_associate_db_table(), $form);
        echo $query;
        $result = $db->query($query);
        while($row = $result->fetch(PDO::FETCH_NUM)) {
            echo "<option value=\"{$row[0]}\">$row[0]</option>";
        }

        ?>
    </select>

    <input type="button" id="add" value=">>">
    <input type="button" id="remove" value="<<">

    <!--TODO: Dynamically insert form here-->
    <select size="20" name="target[]" id="target" style="width: 200px" multiple>

    </select>

    <input type="submit" name="submit" id="priv_submit" value="submit" />
</form>

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