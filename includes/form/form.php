<?php

include_once('tenant.php');
include_once('privilege.php');
include_once('branch.php');

//TODO Add session to validate form

abstract class Form
{
    protected $fields; // assoc array of name => value
    private $sticky = false;

    public function __construct($sticky=false) {
        $this->sticky = $sticky;
        $all_form_elem = $this->get_all_fields_name();
        if(!$all_form_elem) {
            echo "<strong>Warning: Please define field's name for this form.</strong>";
            return;
        }
        foreach($all_form_elem as $elem_name) {
            if($this->is_submitted() && $this->is_sticky() && isset($_POST[$elem_name])) {
                $this->fields[$elem_name] = $_POST[$elem_name];
            }
            else
                $this->fields[$elem_name] = '';
        }
    }

    public abstract function form();
    protected abstract function get_all_fields_name();
    protected abstract function validate($input);

    public function fetch() {
        if(!$this->is_submitted())
            return null;

        $result = array();

        foreach($this->fields as $name => $value) {
//            if(!empty($_POST[$name]))
                $result[$name] = $_POST[$name];
//            else
//                $result[$name] = null;
        }

        $this->validate($result);

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
    protected function fetch_numeric($field) {
        if(empty($_POST[$field]))
            return null;
        return $_POST[$field];
    }
}

interface Record {
    public function get_associate_db_table();

    /*
     * @return associative array of DB column's name => value associated in that field.
     */
    public function fetch();
}