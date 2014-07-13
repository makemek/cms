<?php

if(!isset($_SESSION['form']))
    redirect('admin.php');

if(isset($_POST['submit'])) {
    $controller = new Tenant_branch_controller($_SESSION['form']);
    $controller->create();
}