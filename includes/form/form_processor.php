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
    }

    public static function setup_default_fields(Privilege $priv, MySQLDatabase $db) {
        self::card_type($priv, $db);
        self::show_card($priv, $db);
        self::owner($priv, $db);
        return $priv;
    }

    private static function show_card(Privilege $priv, MySQLDatabase $db) {
        $show_card = $db->get_enum(\trueyou\Priv_tbl::name(), \trueyou\Priv_tbl::SHOW_CARD);
        $priv->set_field(Privilege::SHOW_CARD, $show_card);

    }

    private static function card_type(Privilege $priv, MySQLDatabase $db) {
        $set = $db->get_enum(trueyou\Priv_tbl::name(), trueyou\Priv_tbl::CARD, true);
        $priv->set_field(Privilege::CARD, $set);
    }

    private static function owner(Privilege $priv, MySQLDatabase $db) {
        $name_en_col = trueyou\Tenant_tbl::NAME_EN;
        $owner = $db->query("SELECT " . $name_en_col . " FROM ". \trueyou\Tenant_tbl::name() .
            " ORDER BY " . $name_en_col . " ASC");
        $priv->set_field(Privilege::OWNER, $owner->fetchAll(PDO::FETCH_COLUMN));
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
    private $db;
    private $tenant;

    public function __construct(Tenant $tenant, MySQLDatabase $db) {
        $this->tenant = $tenant;
        $this->db = $db;
    }

    public static function setup_default_fields(Tenant $tenant, MySQLDatabase $db) {
        $table_name = trueyou\Tenant_tbl::name();

        //----- Access Channel ------- //
        $access_ch = $db->get_enum($table_name, trueyou\Tenant_tbl::ACCESS_CH, true);
        $tenant->set_field(Tenant::ACCESS_CH, $access_ch);

        // ---- Priority ------ //
        $priority = $db->get_enum($table_name, trueyou\Tenant_tbl::PRIORITY);
        $tenant->set_field(Tenant::PRIORITY, $priority);

        // ---- Categories ----- //
        $categories = $db->get_enum($table_name, trueyou\Tenant_tbl::TUREYOU_CAT, true);
        $tenant->set_field(Tenant::TRUEYOU_CAT, $categories);

        // ---- Status ----- //
        $status = $db->get_enum($table_name, trueyou\Tenant_tbl::STATUS);
        $tenant->set_field(Tenant::STATUS, $status);

        return $tenant;
    }

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