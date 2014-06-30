<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <base href="<?php echo base_url(); ?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title.' - '.$config_title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/plugins/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/plugins/select2.css" media="screen">
    <link rel="stylesheet" href="css/plugins/tablesorter.css" media="screen">
    <link href="css/plugins/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
    <link href="css/plugins/validity.css" rel="stylesheet" type="text/css" />
    <link href="css/plugins/fancybox.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]><script src="js/vendor/selectivizr-1.0.2.min.js"></script><![endif]-->
    <!--<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
  </head>
  <body <?php echo (isset($class)) ? 'class="'.$class.'"' : '' ; ?>>
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
    <div class=".message"><?php echo $system_message ?></div>
    <?php if ($show_menu): ?>
    <nav class="main-menu">
      <ul>
      <?php
      foreach ($allowed_modules->result() as $module) {
          $href = ( strpos($module->modulo_id, '-') !== FALSE ) ? str_replace('-', '/',$module->modulo_id) : $module->modulo_id;

          if ($module->in_menu) {
              //Si el modulo tiene Imagen la pongo
              echo "<li><ul>";
              if ($module->imagen) {
                  echo '<li><img src="images/menubar/'.$module->imagen.'" alt="'.$module->nombre.'"></li>';
              }else{
                echo "<li></li>";
              }
              echo '<li>'.anchor($href, $module->nombre, 'title="'.$module->nombre.'"').'</li>';
              echo "</ul></li>";
          }
      }
      ?>
      </ul>
    </nav>
    <header>
      <div class="logo"><a href="index.php"><img src="images/logo.png" title="Ir al inicio" alt="" width="78px"></a></div>
      <nav class="user-menu">
        <ul>
          <li class="session-user"><h5>Usuario: <?php echo anchor('employees/view/'.$user_info->cedula.'?height=500&width=650', $user_info->nombre.' '.$user_info->apellido, 'title="Perfil de Usuario" class="fancybox"'); ?></h5></li>
          <li class="logout"><?php echo anchor('logout','Salir', 'title="Salir del Sistema"'); ?></li>
        </ul>
      </nav>
      <div id="clock">
        <?php echo date('F d, Y');?>
        <span></span>
      </div>
    </header>
    <?php endif ?>
    <div id="wrapper" <?php echo (isset($classWrapper)) ? 'class="'.$classWrapper.'"' : '' ; ?>>