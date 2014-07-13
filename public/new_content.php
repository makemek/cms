<?php
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
require_once('../includes/form/form_processor.php');
require_once('../includes/form/form.php');
require_once('../includes/form/tenant.php');
require_once('../includes/form/privilege.php');
require_once('../includes/functions.php');

if(!isset($_SESSION['form']) || !isset($_POST['submit']))
    redirect('admin.php');

/**
 * @var $crud FormProcessor
 * @var $controller CRUD
 */

$form = $_SESSION['form'];
$db = new MySQLDatabase(DB_TRUEYOU);

$crud = null;
$controller = null;

// find out what type of form is submitted
switch($form->get_associate_db_table()) {
    case trueyou\Tenant_tbl::name():
        $crud = new Tenant_form_controller($form, $db);
        $controller = new Tenant_branch_controller($db);
        break;

    case trueyou\Priv_tbl::name():
        $crud = new Priv_form_controller($form, $db);
        $controller = new Priv_branch_controller($db);
        break;

    default:
        die($form->get_associate_db_table() . ' not found in table configuration');
}

$crud->create();
$controller->create();


session_destroy();
