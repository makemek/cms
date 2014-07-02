<?php

require_once('form.php');
require_once('database/database.php');

class FormProcessor
{
    private $rec;
    private $db;

    public function __construct(Record $rec, MySQLDatabase $db) {
        $this->rec = $rec;
        $this->db = $db;
    }

    public function execute() {
        $table_name = $this->rec->get_associate_db_table();

        $insertVal = $this->rec->fetch();
        print_r($insertVal);

        $query = $this->construct_query($table_name, $insertVal);
        $row_affected = $this->issue($query);
        return $row_affected;
    }

    private function construct_query($table_name, $fields) {
        //$fields = array_values($fields);
        $col_name = $this->db->get_table_column_name($table_name);

        if(count($fields) != count($col_name))
            echo 'Warning: Field may not be inserted correctly.' . '<br />';

        $col_name_str = implode(',', $col_name);
        $param = $this->create_param_str(count($col_name));

//        echo $col_name . '<br/>';
        echo '<pre>'; print_r($fields); echo '</pre>';
//        echo $param . '<br/>';

        try {
            $query = "INSERT INTO {$table_name} ({$col_name_str}) VALUES({$param})" ;
            echo $query . '<br />';
            $stmt = $this->db->prepare($query);

//            for($i = 1; $i <= count($fields); ++$i)
//                $stmt->bindValue($i, $fields[$i-1]);
            $i = 1;
            foreach($col_name as $col) {
                $insert_val = $fields[$col];
                if(is_array($fields[$col]))
                    $insert_val = trim(implode(',', $insert_val), ',');

                echo $insert_val . '<br/>';

                $stmt->bindValue($i, $insert_val);
                ++$i;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $stmt;
    }

    private function create_param_str($amount) {
        // construct ?,?,?, .... string
        $param = '';
        for($i = 0; $i < $amount; ++$i)
            $param .= '?,';

        $param = trim($param, ',');

        return $param;
}

    private function issue(PDOStatement $query, $args=null) {

        try {
            if(!$args)
                $query->execute();
            else
                $query->execute($args);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $query->rowCount();
    }
}