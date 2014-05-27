<?php $this->load->view('partial/header'); ?>
<section class="config-system">
	<h1>Configuración del sistema</h1>
	<ul>
		<li>
			<h3>Configuración General</h3>
			<?php
			echo form_open('config/save');
			echo form_label('Nombre de la sede:', 'sede').form_input('sede');
			echo '<br>';
			echo form_label('Correo del Administrador:', 'email').form_input('email');
			echo '<br>';
			echo form_submit('submit', 'Guardar');
			echo form_close();
			?>
			<input type="button" id="button-municipio">
			<input type="button" id="button-aldea">
		</li>
		<li>
			<h3>Usuarios del Sistema</h3>
		</li>
		<li>
			<h3>Útiles</h3>
			<?php
			echo form_open('config/backup');
			echo form_submit('submit', 'Respaldar');
			echo form_close();
			?>
		</li>
	</ul>
</section>
<?php $this->load->view('partial/footer'); ?>