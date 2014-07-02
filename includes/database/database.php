<?php
require_once('config.php');

class MySQLDatabase extends PDO
{
    public function __construct ($db_name) {
        try{
            parent::__construct('mysql:host=' . DB_HOST . ';dbname=' . $db_name . ';',
                DB_USER, DB_PASSWORD);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function get_table_column_name($table) {
        $query = "DESCRIBE " . $table;
        $stmt = $this->prepare($query);
        $stmt->execute();

        $fields = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fields[] = $row['Field'];
        }

        return $fields;
    }


    public function mysql_prep($value) {
        $magic_quotes_active = get_magic_quotes_gpc(); // i.e PHP >= v4.3.0
        $new_enough_php = function_exists("mysql_real_escape_string");
        if($new_enough_php) { // PHP v4.3.0 or higher
            // undo any magic quote effects so mysql_real_escape_string can do the work
            if($magic_quotes_active) { $value = stripslashes($value); }
            $value = mysql_real_escape_string($value);
        } else { // before PHP v4.3.0
            // if magic quotes aren't already on then add slashes manually
            if(!$magic_quotes_active) { $value = addslashes($value); }
            // if magic quotes are active, then the slashes already exist
        }
        return $value;
    }
}

