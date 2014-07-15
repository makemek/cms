<?php
require_once('../includes/layout/header.php');
require_once('../includes/form/form.php');
require_once('../includes/form/privilege.php');
require_once('../includes/form/tenant.php');
require_once('../includes/form/branch.php');
require_once('../includes/database/database.php');
require_once('../includes/form/form_processor.php');
session_start();

function displayError($errors) {
    echo '<ul>';
    foreach($errors as $msg) {
        echo "<li><strong><span style=\"color:red\">{$msg}</span></strong></li>";
    }
    echo '</ul>';

}
?>

<title>
    <?php
    if(isset($select))
        echo "Add New {$select}";
    else
        echo "Add New Content";
    ?>
</title>

<div id="page">
<?php
$_SESSION['link'] = 'public/add_content.php?add=';
if(isset($_SESSION['error'])) {
    displayError($_SESSION['error']);

    echo '<hr />';
    unset($_SESSION['error']); // acknowledge error(s)
}

$select = null;
if(isset($_GET['add'])) {
    $select = $_GET['add'];
    $_SESSION['link'] .= $select;
}

$db = new MySQLDatabase(DB_TRUEYOU);
$form = null;
$controller = null;

switch ($select) {
    case Navigation::TENANT:
        $nav[Navigation::ADD_CONTENT][Navigation::TENANT]->set_selected(true);
        $form = new Tenant(true);
        $form = Tenant_form_controller::setup_default_fields($form, $db);
        break;

    case Navigation::PRIV:
        $nav[Navigation::ADD_CONTENT][Navigation::PRIV]->set_selected(true);
        $form = new Privilege(true);
        $form = Priv_form_controller::setup_default_fields($form, $db);
        break;

    case Navigation::BRANCH:
        $nav[Navigation::ADD_CONTENT][Navigation::BRANCH]->set_selected(true);
        $form = new Branch(true);
        $controller = new Branch_form_controller($form, $db);
        break;

    default:
        session_destroy();
        die();
}

if($form->is_submitted() && !is_null($controller)) {
    $form->fetch();
    $errors = $form->validate($db);

    if(count($errors) > 0) {
        $_SESSION['error'] = $errors;
        displayError($errors);
        unset($_SESSION['error']);
    }

    else
        $controller->create();
}
else {
    $form->form();
    $_SESSION['form'] = serialize($form);
}

?>
</div>

<?php include('../includes/layout/footer.php'); ?>