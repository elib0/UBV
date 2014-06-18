<?php echo form_open('employees/save/'.$employee->cedula, 'id="form-employee"'); ?>
<div class="form-content">
	<h3>Datos personales</h3>
	<h5 class="required">Campos en rojo son obligatorios</h5>
	<?php if (!$employee->cedula): ?>
		<ul>
			<li><?php echo form_label('Cédula de identidad', 'cedula', array('class'=>'required')).'<br>'.form_input('cedula', $employee->cedula); ?></li>
		</ul>
	<?php else: ?>
		<?php echo form_hidden('cedula', $employee->cedula); ?>
	<?php endif ?>
	<ul>
		<li><?php echo form_label('Nombres', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', $employee->nombre); ?></li>
		<li><?php echo form_label('Apellidos', 'apellido', array('class'=>'required')).'<br>'.form_input('apellido', $employee->apellido); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Teléfono', 'telefono').'<br>'.form_input('telefono', $employee->telefono); ?></li>
		<li><?php echo form_label('Correo Electronico', 'correo').'<br>'.form_input('correo', $employee->email); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Dirección', 'direccion').'<br>'.form_textarea('direccion', $employee->direccion); ?></li>
	</ul>
	<br>
	<h3>Datos de Empleado</h3>
	<ul>
		<li><?php echo form_label('Apodo', 'apodo').'<br>'.form_input('apodo', $employee->apodo); ?></li>
		<li>
			<?php echo form_label('Contraseña', 'contrasena').'<br>'.form_input('contrasena'); ?>
		</li>
		<li><?php echo form_label('Tipo de empleado', 'nivel').'<br>'.form_dropdown('nivel', $levels,$employee->cod_nivel); ?></li>
	</ul>
	<br><br>
	<p>Estos datos serán usados para el acceso al sistema.</p>
	<input type="submit" value="Guardar" class="btn btn-default">
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(function() {
		$('#form-employee').ajaxForm({
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
					closeTb = true;
				}
				set_feedback(type, title, response.messagge, messaggeType, closeTb);
				// $('#search-student').select2('val','response.cedula',true);
			}
		});
	});
</script>