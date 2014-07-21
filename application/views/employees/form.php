<?php echo form_open('employees/save/'.$employee->cedula, 'id="form-employee"'); ?>
<div class="form-content">
	<h5 class="required text-right">Campos en rojo son obligatorios</h5>
	<ul>
		<div>
			<h3>Datos personales</h3>
		</div>
	<?php if (!$employee->cedula): ?>
		<li><?php echo form_label('Cédula de identidad', 'cedula', array('class'=>'required')).'<br>'.form_input('cedula', $employee->cedula, 'id="cedula" class="form-control"'); ?></li>
	<?php endif ?>
	</ul>
	<ul>
		<li><?php echo form_label('Nombres', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', $employee->nombre, 'id="nombre"  class="form-control"'); ?></li>
		<li><?php echo form_label('Apellidos', 'apellido', array('class'=>'required')).'<br>'.form_input('apellido', $employee->apellido, 'id="apellido"  class="form-control"'); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Teléfono', 'telefono', array('class'=>'required')).'<br>'.form_input('telefono', $employee->telefono, 'id="telefono"  class="form-control"'); ?></li>
		<li><?php echo form_label('Correo Electronico', 'correo', array('class'=>'required')).'<br>'.form_input('correo', $employee->email, 'id="correo" class="form-control"'); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Dirección', 'direccion', array('class'=>'required')).'<br>'.form_textarea(array('name'=>'direccion', 'value'=>$employee->direccion, 'cols'=>100, 'rows'=>3, 'id'=>"direccion", 'class'=>"form-control")); ?></li>
	</ul>
	<br>
	<div><?php echo form_label('Activo:', 'estado').form_checkbox('estado', '0', !(boolean)$employee->eliminado); ?></div>
	<ul>
		<div>
			<h3>Datos de Empleado</h3>
		</div>
		<li><?php echo form_label('Apodo', 'apodo', array('class'=>'required')).'<br>'.form_input('apodo', $employee->apodo, 'id="apodo"  class="form-control"'); ?></li>
		<li>
			<?php echo form_label('Contraseña', 'contrasena', array('class'=>'required')).'<br>'.form_password('contrasena','', 'id="contrasena"  class="form-control"');
				echo form_password('contrasena','', 'id="recontrasena"  class="form-control"');
			?>
		</li>
		<li><?php echo form_label('Tipo de empleado', 'nivel').'<br>'.form_dropdown('nivel', $levels,$employee->cod_nivel, ' class="form-control"'); ?></li>
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
	        $('#email').match('email').maxLength(60);
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
				set_feedback(type, title, response.messagge, messaggeType, closeTb, closeTb);
			}
		});
	});
</script>