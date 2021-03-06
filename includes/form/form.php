<?php

abstract class Form implements Record
{
    protected $fields = array(); // assoc array of name => value
    private $sticky = false;

    public function __construct($sticky=false) {
        $this->sticky = $sticky;
        $all_form_elem = array_merge($this->get_all_string_fields(), $this->get_all_numeric_fields());

        if(!$all_form_elem) {
            echo "<strong>Warning: Please define field's name for this form.</strong>";
            return;
        }

        if($this->is_submitted() && $this->is_sticky())
            $this->fields = $this->fetch();
        else {
            foreach($all_form_elem as $elem)
                $this->set_field($elem, '');
        }
    }

    public abstract function form();
    public function set_field($field, $value) {
        $this->fields[$field] = $value;
    }
    public function get_field($field) {
        return $this->fields[$field];
    }

    public function get_all_fields() {
        return $this->fields;
    }

    protected abstract function get_all_string_fields();
    protected abstract function get_all_numeric_fields();

    /**
     * @param MySQLDatabase $db
     * @return array of errors
     */
    public abstract function validate(MySQLDatabase $db);

    protected function is_exists(MySQLDatabase $db, $table_name, $column, $value) {
        $query = "SELECT " . $column . " FROM " . $table_name;
        $query .= " WHERE " . $column . " = " . "'{$value}'";

        return $db->query($query)->rowCount();
    }

    public function fetch() {
        if(!$this->is_submitted())
            return null;

        $result = array();

        $string_fields = $this->get_all_string_fields();
        $numeric_fields = $this->get_all_numeric_fields();

        if(is_array($string_fields)) {
            foreach($string_fields as $str_field) {
                if(isset($_POST[$str_field]))
                    $result[$str_field] = $_POST[$str_field];
                else
                    $result[$str_field] = ''; // default value
            }
        }

        if(is_array($numeric_fields)) {
            foreach($numeric_fields as $num_field) {
                if(isset($_POST[$num_field]))
                    $result[$num_field] = $this->fetch_numeric($num_field);
                else
                    $result[$num_field] = null; // default value
            }
        }

        $this->fields = $result; // assigns to present fields

        return $result;
    }

    protected function submit_bt($name) {
        return "<input type=\"submit\" name=\"submit\" value=\"{$name}\" >";
    }

    public function is_submitted() {
        return isset($_POST['submit']);
    }

    public function is_sticky() {
        return $this->sticky;
    }

    /*
     * if the numeric field is empty -> return null
     * otherwise return $_POST['field']
     */
    private function fetch_numeric($field) {
        if(empty($_POST[$field]))
            return null;
        return $_POST[$field];
    }
}

interface Record {
    public function get_associate_db_table();

    /**
     * @return  array associative array of DB column's name => value associated in that field.
     */
    public function fetch();
}