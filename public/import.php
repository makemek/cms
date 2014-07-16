<?php
require_once('../includes/database/table_config.php');
require_once('../includes/database/database.php');
include_once('../includes/layout/header.php');

define('CSV', 'application/vnd.ms-excel');
?>

<div id="page">
    <h2>Import From CSV File</h2>
    <form action="import.php" enctype="multipart/form-data" method="POST">
        Branch: <input name="<?php echo trueyou\Branch_tbl::name(); ?>" type="file" accept=".csv" /><br />
<!--        Privilege: <input name="--><?php //echo trueyou\Priv_tbl::name(); ?><!--" type="file" accept=".csv" /><br />-->
<!--        Privilege's Branch: <input name="--><?php //echo \trueyou\Priv_branch_tbl::name(); ?><!--" type="file" accept=".csv" /><br />-->
<!--        Tenant's Branch: <input name="--><?php //echo \trueyou\Tenant_branch_tbl::name(); ?><!--" type="file" accept=".csv" /><br />-->
        <input type="submit" name="submit" value="Upload" />
        <input type="reset" name="reset" value="Reset" />
    </form>

    <hr/>

    <?php
    if(!isset($_POST['submit']))
        die();

    $db = new MySQLDatabase(DB_TRUEYOU);





    foreach($_FILES as $table => $file) {
        if($file['error'] != UPLOAD_ERR_OK || $file['type'] !== CSV)
            break;

        $query = "LOAD DATA LOCAL INFILE '?' INTO TABLE {$table} ";
        $query .= "FIELDS TERMINATED BY ',' ";
        $query .= "ENCLOSED BY '\"' ";
        $query .= "LINES TERMINATED BY '\n'";

        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $file['name']);

        try{
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_NUM);
            echo $stmt->rowCount() . '<br />';
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    ?>

</div>

<?php
include_once('../includes/layout/footer.php');