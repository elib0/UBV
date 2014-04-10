    <header>
      <div class="logo">Aqui va el logo</div>
      <ul class="main-menu">
      <?php
      foreach ($allowed_modules->result() as $module) {
          echo '<li><a href="'.$module->modulo_id.'" title="'.$module->nombre.'">'.$module->nombre.'</a></li>';
      }
      ?>
      </ul>
    </header>