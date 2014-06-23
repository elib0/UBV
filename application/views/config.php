<?php $this->load->view('partial/header'); ?>
<section class="config-system">
	<h1>Configuración del sistema</h1>
	<hr>
	<ul>
		<li>
			<h3>Configuración General</h3>
			<?php
			echo form_open('config/save', 'id="form-save" class="form-control"');
			echo form_label('Nombre de la sede:', 'sede').form_input('sede', $sede, 'id="sede"');
			echo form_label('Correo del Administrador:', 'email').form_input('email', $admin_email, 'id="email"');
			echo form_submit('submit', 'Guardar', 'class="btn btn-default btn-sm"');
			echo form_close();
			?>
		</li>
		<li>
			<h3>Administración de Aldeas</h3>
			<?php echo anchor('universities?height=600&width=900', 'Aldeas', 'title="Modificar y Administras las Aldeas Universitarias" class="thickbox btn btn-primary btn-sm"'); ?>
			<?php echo anchor('universities/view?height=450&width=700', '+', 'title="Agregar Aldea Nueva" class="thickbox btn btn-success btn-sm"'); ?>
		</li>
		<li>
			<h3>Usuarios del Sistema</h3>
			<?php echo anchor('employees', 'Administrar Empleados', 'title="Administrar Empleados" class="btn btn-primary btn-sm"'); ?>
		</li>
		<h3>Útiles</h3>
		<li class="form-control">
			<?php
			echo form_open('config/backup');
			echo form_submit('submit', 'Respaldar','class="btn btn-default btn-sm"');
			echo form_close();
			?>
			<?php
			echo form_open_multipart('config/restore', 'id="form-restore"');
			echo form_upload('backup','','class="btn btn-default btn-sm"');
			echo form_submit('submit', 'Restaurar', 'class="btn btn-default btn-sm"');
			echo form_close();
			?>
		</li>
	</ul>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
	$(function() {
		$("#form-save").validity(function() {
	        $("#sede, #email").require();
	        $('#email').match('email');
	        $('#sede').minLength(3).maxLength(100);
	    });

		$('#form-restore, #form-save').ajaxForm({
			dataType: 'json',
			success: function(response){
				var title = 'Error General';
				var type = 'alert';
				var messaggeType = 'dager';
				var closeTb = false;
				if (response.status){
					title = '';
					type = false;
					messaggeType = 'success';
				}
				set_feedback(type, title, response.messagge, messaggeType, closeTb);
			}
		});
	});
</script>