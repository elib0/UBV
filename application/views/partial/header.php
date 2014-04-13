<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title.' - ' ?>UBV System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css">
    <!--[if lt IE 9]><script src="<?php echo base_url(); ?>js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
    <script src="<?php echo base_url(); ?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body>
    <!--[if lt IE 9]>
      <div class="browsehappy">
        <p>
          Tu versión del navegador no esta <strong>actualizada</strong>. Porfavor <a href="http://browsehappy.com/" target="_blank">actualiza tu navegador</a> o <a href="http://www.google.com/chromeframe/?redirect=true" target="_blank">activa "Google Chrome Frame"</a> para mejorar tu experiencia en la web.
        </p>
        <p>
          Has click en cualquier lado de la pantalla para ignorar temporalmente este mensaje.
        </p>
      </div>
    <![endif]-->
    <div class=".message"><?php echo $system_message; ?></div>
    <?php if ($show_menu): ?>
    <header>
      <div class="logo">Aqui va el logo</div>
      <ul class="main-menu">
      <?php
      foreach ($allowed_modules->result() as $module) {
          echo '<li><a href="'.$module->modulo_id.'" title="'.$module->nombre.'">'.$module->nombre.'</a></li>';
      }
      ?>
      </ul>
      <div class="header-footer">
        <h5>Bienvenido: <?php echo $user_info->nombre.' '.$user_info->apellido.'.'; ?></h5>
        <?php echo anchor('employee/logout','Salir del Sistema'); ?>
      </div>
    </header>
    <?php endif ?>
    <div id="wrapper">