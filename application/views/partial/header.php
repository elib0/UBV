<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <base href="<?php echo base_url(); ?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title.' - ' ?>UBV System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/plugins/select2.css" media="screen">
    <link rel="stylesheet" href="css/plugins/thickbox.css" media="screen">
    <link rel="stylesheet" href="css/plugins/tablesorter.css" media="screen">
    <!--[if lt IE 9]><script src="js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
      <nav class="main-menu">
        <ul>
        <?php
        foreach ($allowed_modules->result() as $module) {
            $href = ( strpos($module->modulo_id, '-') !== FALSE ) ? str_replace('-', '/',$module->modulo_id) : $module->modulo_id;

            //Si el modulo tiene Imagen la pongo
            if ($module->imagen) {
              echo '<li><img src="images/menubar/'.$module->imagen.'" alt="'.$module->nombre.'"></li>';
            }
            echo '<li>'.anchor($href, $module->nombre, 'title="'.$module->nombre.'"').'</li>';
        }
        ?>
        </ul>
      </nav>
      <nav class="user-menu">
        <h5>Bienvenido: <?php echo $user_info->nombre.' '.$user_info->apellido.'.'; ?></h5>
        <?php echo anchor('logout','Salir del Sistema'); ?>
      </nav>
    </header>
    <?php endif ?>
    <div id="wrapper">