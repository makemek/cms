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

    /**
     * Fetch input according to following format
     * Branch_name => array(Floor1, Floor2)
     * @return array filtered input from $_POST
     */
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
        $query = "INSERT INTO " . \trueyou\Tenant_branch_tbl::name() . " VALUES(:bName, :floor1, :floor2)";
        $stmt = $this->db->prepare($query);
        foreach($input as $bName => $floor) {
            $stmt->bindParam('bName', $bName);
            $stmt->bindParam('floor1', $floor[0]);
            $stmt->bindParam('floor2', $floor[1]);
        }

        $stmt->execute();

        return $stmt->rowCount();
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