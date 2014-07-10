<?php

require_once('form.php');
require_once(__DIR__ . '/../database/database.php');

interface CRUD {
    public function create();
    public function read();
    public function update();
    public function delete();
}

abstract class FormProcessor implements CRUD
{
    private $rec;
    private $db;

    public function __construct(Record $rec, MySQLDatabase $db) {
        $this->rec = $rec;
        $this->db = $db;
    }

    // Universal insert
    public function create() {
        $table_name = $this->rec->get_associate_db_table();

        $insertVal = $this->rec->fetch();
        print_r($insertVal);

        $query = $this->construct_query($table_name, $insertVal);
        $row_affected = $this->issue($query);
        return $row_affected;
    }

    private function construct_query($table_name, $fields) {
        $col_name = $this->db->get_table_column_name($table_name);

        if(count($fields) != count($col_name))
            echo 'Warning: Field may not be inserted correctly.' . '<br />';

        $col_name_str = implode(',', $col_name);
        $param = $this->create_param_str(count($col_name));

        echo '<pre>'; print_r($fields); echo '</pre>';

        try {
            $query = "INSERT INTO {$table_name} ({$col_name_str}) VALUES({$param})" ;
            echo $query . '<br />';
            $stmt = $this->db->prepare($query);

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

    /*
     * Construct ?, ?, ?, ... string
     */
    private function create_param_str($amount) {
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

class Branch_form_controller extends FormProcessor
{
    private $branch;
    private $db;

    public function __construct(Branch $branch, MySQLDatabase $db) {
        parent::__construct($branch, $db);
        $this->branch = $branch;
        $this->db = $db;
    }

    public function read()
    {
        return $this->branch;
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}

class Priv_form_controller extends FormProcessor
{
    private $priv;
    private $db;

    public function __construct(Privilege $priv, MySQLDatabase $db) {
        $this->priv = $priv;
        $this->db = $db;

        $this->setup_default_fields();
    }

    private function setup_default_fields() {
        $this->card_type();
        $this->show_card();
        $this->owner();
    }

    private function show_card() {
        $show_card = $this->db->get_enum(\trueyou\Priv_tbl::name(), \trueyou\Priv_tbl::SHOW_CARD);
        $this->priv->set_field(Privilege::SHOW_CARD, $show_card);

    }

    private function card_type() {
        $set = $this->db->get_enum(trueyou\Priv_tbl::name(), trueyou\Priv_tbl::CARD, true);
        $this->priv->set_field(Privilege::CARD, $set);
    }

    private function owner() {
        $name_en_col = trueyou\Tenant_tbl::NAME_EN;
        $owner = $this->db->query("SELECT " . $name_en_col . " FROM ". \trueyou\Tenant_tbl::name() .
            " ORDER BY " . $name_en_col . " ASC");
        $this->priv->set_field(Privilege::OWNER, $owner->fetchAll(PDO::FETCH_COLUMN));
    }

    public function read()
    {
        return $this->priv;
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}

class Tenant_form_controller extends FormProcessor
{
    public function read()
    {
        // TODO: Implement read() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}