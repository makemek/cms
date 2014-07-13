<?php
require_once('../includes/layout/header.php');
require_once('../includes/form/form.php');
require_once('../includes/form/privilege.php');
require_once('../includes/form/tenant.php');
require_once('../includes/form/branch.php');
require_once('../includes/database/database.php');
require_once('../includes/form/form_processor.php');
session_start()
?>

<title>
    <?php
    if(isset($_GET['add']))
        echo "Add New {$_GET['add']}";
    else
        echo "Add New Content";
    ?>
</title>



<div id="page">
<?php
$select = isset($_GET['add']) ? $_GET['add'] : null;
$db = new MySQLDatabase(DB_TRUEYOU);
$form = null;
$controller = null;

switch ($select) {
    case Navigation::TENANT:
        $nav[Navigation::ADD_CONTENT][Navigation::TENANT]->set_selected(true);
        $form = new Tenant();
        $form = Tenant_form_controller::setup_default_fields($form, $db);
        break;

    case Navigation::PRIV:
        $nav[Navigation::ADD_CONTENT][Navigation::PRIV]->set_selected(true);
        $form = new Privilege();
        $form = Priv_form_controller::setup_default_fields($form, $db);
        break;

    case Navigation::BRANCH:
        $nav[Navigation::ADD_CONTENT][Navigation::BRANCH]->set_selected(true);
        $form = new Branch(true);
        $controller = new Branch_form_controller($form, $db);
        break;

    default:
        die();
}

if($form->is_submitted() && !is_null($controller))
    $controller->create();
else {
    $form->form();
    $_SESSION['form'] = serialize($form);
}

?>
</div>

<?php include('../includes/layout/footer.php'); ?>