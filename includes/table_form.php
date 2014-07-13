<?php
require_once('form/form.php');
require_once('form/form_processor.php');

use trueyou\Branch_tbl as branch_tbl;

class Priv_branch_controller implements CRUD
{
    private $db;

    public function __construct(MySQLDatabase $db) {
        $this->db = $db;
    }

    public function create()
    {
        // TODO: Implement create() method.
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

class Tenant_branch_controller implements CRUD
{

    private $db;

    public function __construct(MySQLDatabase $db) {
        $this->db = $db;
    }

    private function fetchInput() {
        $result = array();
        foreach($_POST as $branch_name => $floor) {
            if(empty($floor[0]))
                $floor[0] = null;
            if(empty($floor[1]))
                $floor[1] = null;

            $branch_name = str_replace('_', ' ', $branch_name);
            $result[$branch_name] = $floor;
        }

        return $result;
    }

    public function create()
    {
        $input = $this->fetchInput();

        var_dump($this->fetchInput());
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