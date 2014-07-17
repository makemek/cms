<?php
require_once('../includes/database/table_config.php');
require_once('../includes/database/database.php');
include_once('../includes/layout/header.php');

define('CSV', 'application/vnd.ms-excel');
define('SKIP_LINE', 'skip_line');
define('COLUMN', 'col');

$db = new MySQLDatabase(DB_TRUEYOU);
?>

<div id="page">
    <h2>Import From CSV File</h2>

    <?php $tbl = array(
        'Branch' => trueyou\Branch_tbl::name(),
        'Privilege' => trueyou\Priv_tbl::name(),
        "Privilege's branch" => trueyou\Priv_branch_tbl::name(),
        "Tenant's branch" => trueyou\Tenant_branch_tbl::name()
    ); ?>

    <form action="import.php" enctype="multipart/form-data" method="POST">

        <?php
        foreach($tbl as $name => $table) { ?>
            <fieldset>
                <legend><?php echo $name; ?></legend>

                <input type="file" name="<?php echo $table ?>" accept=".csv" />
                Ignore First: <input type="number" min="0" name="<?php echo $table;?>[line]" value="0" /> Lines
                <br />

                <?php
                $col = $db->get_table_column_name($table);
                foreach($col as $c)
                    echo "<input type=\"checkbox\" name=\"{$table}[col][]\" value=\"{$c}\"/>" . $c;
            ?>
            </fieldset>
            <br />
        <?php } ?>

        <input type="submit" name="submit" value="Upload" />
        <input type="reset" name="reset" value="Reset" />
    </form>

    <hr/>

    <?php
    if(!isset($_POST['submit']))
        die();

    foreach($_FILES as $table => $file) {
        if($file['error'] != UPLOAD_ERR_OK || $file['type'] !== CSV) {
            @unlink($_FILES['tmp_name']);
            continue;
        }

        $target = UPLOAD_DIR . $file['name'];
        $success = move_uploaded_file($file['tmp_name'], $target);
        if(!$success)
            die('File is not successfully uploaded');

        $query = "LOAD DATA LOCAL INFILE '" . $target . "' INTO TABLE {$table} ";
        $query .= "FIELDS TERMINATED BY ',' ";
        $query .= "ENCLOSED BY '\"' ";
        $query .= "LINES TERMINATED BY '\n' ";
        $query .= "IGNORE {$_POST[$table]['line']} LINES ";
        $query .= "(";
        foreach($_POST[$table]['col'] as $field)
            $query .= $field . ',';
        $query = rtrim($query, ',');
        $query .= ") ";

        $stmt = $db->prepare($query);

        try{
            $stmt->execute();

            echo "Table: " . $table . '<br />';
            echo "Rows affacted: " . $stmt->rowCount() . '<br />';

        } catch (PDOException $e) {
            echo "<strong><span style='color:red'>CSV Import Failure</span></strong><br/>";
            die($e->getMessage());
        }

        unlink(UPLOAD_DIR . $file['name']);
    }



    ?>

</div>

<?php
include_once('../includes/layout/footer.php');