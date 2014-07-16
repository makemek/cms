<?php
require_once('../includes/database/database.php');
require_once('../includes/database/table_config.php');
require_once('../includes/form/form_processor.php');
require_once('../includes/form/form.php');
require_once('../includes/form/tenant.php');
require_once('../includes/form/privilege.php');
require_once('../includes/functions.php');
require_once('../includes/table_form.php');
require_once('../includes/session_config.php');
session_start();

if(!isset($_SESSION[FORM]) || !isset($_POST['submit'])) {
    redirect('admin.php');
}

unset($_POST['submit']); // acknowledge submit

/**
 * @var $form_controller FormProcessor
 * @var $controller CRUD
 */

$form = unserialize($_SESSION[FORM]);
var_dump($form);
$db = new MySQLDatabase(DB_TRUEYOU);

$form_controller = null;
$controller = null;

// find out what type of form is submitted
switch($form->get_associate_db_table()) {
    case trueyou\Tenant_tbl::name():
        $form_controller = new Tenant_form_controller($form, $db);
        $controller = new Tenant_branch_controller($form, $db);
        break;

    case trueyou\Priv_tbl::name():
        $form_controller = new Priv_form_controller($form, $db);
        $controller = new Priv_branch_controller($db);
        break;

    default:
        die($form->get_associate_db_table() . ' not found in table configuration');
}

$form_controller->create();
$controller->create();


session_destroy();
