<?php $this->load->view('partial/header'); ?>
<?php $this->load->view('partial/main_menu'); ?>
<section class="config-system">
	<h1>Configuración del sistema</h1>
	<ul>
		<li>
			<h2>Configuración General:</h2>
			<?php
			echo form_open('config/save');
			echo form_label('Nombre de la sede:', 'sede').form_input('sede');
			echo '<br>';
			echo form_label('Correo del Administrador:', 'email').form_input('email');
			echo '<br>';
			echo form_submit('submit', 'Guardar');
			echo form_close();
			?>
		</li>
		<li>
			<h2>Utilidades:</h2>
			<?php
			echo form_open('config/backup');
			echo form_submit('submit', 'Respaldar');
			echo form_close();
			?>
		</li>
	</ul>
	<?php
	?>
</section>
<?php $this->load->view('partial/footer'); ?>