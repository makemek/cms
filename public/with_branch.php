<?php
session_start();
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
<select size="20" name="source" id="source" width="300" style="width: 200px"  multiple>
    <?php
    $branch_attrib = trueyou\Branch_tbl::BRANCH;
    $branch_tbl = trueyou\Branch_tbl::name();

    $query = "SELECT $branch_attrib FROM $branch_tbl ";
    $query .= "WHERE $branch_attrib NOT IN (";
    $query .= "SELECT $branch_attrib FROM ". trueyou\Tenant_branch_tbl::name();
    $query .= ")";

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