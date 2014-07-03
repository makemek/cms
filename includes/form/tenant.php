<?php
require_once('form.php');
require_once('../includes/database/table_config.php');

class Tenant extends Form implements Record
{
    public function form() { ?>
        <form action="../public/add_content.php?add=Tenant" method="post">
            Title: <input type="text" name="title" value=""><br />
            Description: <input type="text" name="description" value=""><br />
            <input type="submit" name="submit" value="submit">
        </form>
    <?php }

    protected function get_all_fields_name()
    {
        // TODO: Implement get_all_fields_name() method.
    }

    public function get_associate_db_table()
    {
        return trueyou\Tenant_tbl::name();
    }

    protected function validate($input)
    {
        // TODO: Implement validate() method.
    }
}