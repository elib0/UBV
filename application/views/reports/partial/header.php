<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<link href="<?php echo base_url(); ?>css/plugins/bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>css/plugins/tablesorter.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>css/reports.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="report-wrapper">
		<a href="index.php" class="logo"><img src="<?php echo base_url(); ?>images/logo.png" title="Ir al inicio"></a>
		<h1><?php echo (isset($main_title)) ? $main_title : 'Lista/Reporte' ; ?> - <?php echo $title ?></h1>