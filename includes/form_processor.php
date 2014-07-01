<?php

require_once('form.php');
require_once('database/database.php');

class FormProcessor
{
    private $form;
    private $db;

    public function __construct(Form $form, PDO $db) {
        $this->form = $form;
        $this->db = $db;
    }

    public static function get_table_column_name($table) {

    }

    private function construct_query($col_name, $fields) {

    }

    public function issue($query) {

    }

}