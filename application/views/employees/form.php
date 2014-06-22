<?php echo form_open('employees/save/'.$employee->cedula, 'id="form-employee"'); ?>
<div class="form-content">
	<h3>Datos personales</h3>
	<h5 class="required align-right">Campos en rojo son obligatorios</h5>
	<?php if (!$employee->cedula): ?>
		<ul>
			<li><?php echo form_label('Cédula de identidad', 'cedula', array('class'=>'required')).'<br>'.form_input('cedula', $employee->cedula, 'id="cedula"'); ?></li>
		</ul>
	<?php else: ?>
		<?php echo form_hidden('cedula', $employee->cedula); ?>
	<?php endif ?>
	<ul>
		<li><?php echo form_label('Nombres', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', $employee->nombre, 'id="nombre"'); ?></li>
		<li><?php echo form_label('Apellidos', 'apellido', array('class'=>'required')).'<br>'.form_input('apellido', $employee->apellido, 'id="apellido"'); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Teléfono', 'telefono', array('class'=>'required')).'<br>'.form_input('telefono', $employee->telefono, 'id="telefono"'); ?></li>
		<li><?php echo form_label('Correo Electronico', 'correo', array('class'=>'required')).'<br>'.form_input('correo', $employee->email, 'id="correo"'); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Dirección', 'direccion', array('class'=>'required')).'<br>'.form_textarea(array('name'=>'direccion', 'value'=>$employee->direccion, 'cols'=>100, 'rows'=>3, 'id'=>"direccion")); ?></li>
	</ul>
	<br>
	<h3>Datos de Empleado</h3>
	<div><?php echo form_label('Estado:', 'estado').form_checkbox('estado', '0', !(boolean)$employee->eliminado); ?></div>
	<ul>
		<li><?php echo form_label('Apodo', 'apodo', array('class'=>'required')).'<br>'.form_input('apodo', $employee->apodo, 'id="apodo"'); ?></li>
		<li>
			<?php echo form_label('Contraseña', 'contrasena', array('class'=>'required')).'<br>'.form_input('contrasena','', 'id="contrasena"');
				echo form_input('contrasena','', 'id="recontrasena"');
			?>
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
		$("#form-employee").validity(function() {
	        $("#cedula, #nombre, #apellido, #telefono, #correo, #direccion,#apodo, #contrasena").require();
	        $("#recontrasena").require('Repetir contraseña es obligatorio!');
	        // $("#recontrasena").match($('#contrasena').val());
	        $('#cedula').match('integer').minLength(3).maxLength(9);
	        $('#nombre, #apellido').minLength(3).maxLength(20);
	        $('#email').match('email');
	        $('#telefono').match('phone');
	        $('#apodo').minLength(4).maxLength(10);
	    });

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
			}
		});
	});
</script>