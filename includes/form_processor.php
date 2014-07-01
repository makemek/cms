<?php

require_once('form.php');
require_once('database/database.php');

class FormProcessor
{
    private $form;
    private $db;

    public function __construct(Record $form, PDO $db) {
        $this->form = $form;
        $this->db = $db;
    }

    public function execute() {

    }

    private function construct_query($col_name, $fields) {

    }

    public function issue($query) {

    }

}