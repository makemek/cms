<?php
require_once('../includes/functions.php');
?>

<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../public/stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	
	<body>
		<div id="header">
		<h1>Makemek</h1>
		</div>

        <div id="main">
            <?php
            $nav = new Navigation();
            echo navigation($nav);

            ?>