<title>
    <?php
    if(isset($_GET['add']))
        echo "Add New {$_GET['add']}";
    else
        echo "Add New Content";
    ?>
</title>

<?php 
require_once('../includes/layout/header.php');
require_once('../includes/form/form.php');
require_once('../includes/database/database.php');
require_once('../includes/form/form_processor.php');

function process_form(Form $form, MySQLDatabase $db) {
    if($form->is_submitted()) {
        $controller = new FormProcessor($form, $db);
        $controller->create();
    }
    else
        $form->form();
}
?>

<div id="page">
<?php
    $select = $_GET['add'];
    $db = new MySQLDatabase(DB_TRUEYOU);
    $form = null;

    switch ($select) {
        case Navigation::TENANT:
            $form = new Tenant($db, true);
            $nav[Navigation::ADD_CONTENT][Navigation::TENANT]->set_selected(true);

            if($form->is_submitted()) {
                process_form($form, $db);
                redirect('with_branch.php?tenant='.$form->get_field(Tenant::NAME_EN));
            }
            break;

        case Navigation::PRIV:
            $form = new Privilege($db, true);
            $nav[Navigation::ADD_CONTENT][Navigation::PRIV]->set_selected(true);

            if($form->is_submitted()) {
                process_form($form, $db);
                redirect('with_branch.php?priv_code='.$form->get_field(Privilege::CAMP_CODE));
            }
            break;

        case Navigation::BRANCH:
            $form = new Branch(true);
            $nav[Navigation::ADD_CONTENT][Navigation::BRANCH]->set_selected(true);
            break;

        default:
            die("{$select} did not match any menu");
    }

process_form($form, $db);

?>
</div>

<?php include('../includes/layout/footer.php'); ?>