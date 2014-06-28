<?php
require_once('config.php');

class MySQLDatabase
{
    private $db;
    private $db_name;

    public function __construct ($db_name) {
        $this->$db_name = $db_name;
    }

    public function open_connection()
    {
        try {
            $this->db = new PDO('mysql:' . DB_HOST . ';dbname=' . $this->db_name . ';',
            DB_USER, DB_PASSWORD);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function close_connection()
    {
        try {
        $this->db = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function query($sql) {
        $result = $this->db->fetch(PDO::FETCH_ASSOC);
        $this->confirm_query($result);
        return $result;
    }

    private function confirm_query($result) {
        if (!$result) {
            die("Database query failed: " . mysql_error());
        }
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

$db = new MySQLDatabase(DB_NAME);
