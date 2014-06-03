<?php echo form_open('students/save/'.$student->cedula, 'id="form-student"'); ?>
<div class="form-content">
	<h3>Datos personales</h3>
	<h5 class="required">Campos en rojo son obligatorios</h5>
	<?php if (!$student->cedula): ?>
		<ul>
			<li><?php echo form_label('Cédula de identidad', 'cedula', array('class'=>'required')).'<br>'.form_input('cedula', $student->cedula); ?></li>
		</ul>
	<?php endif ?>
	<ul>
		<li><?php echo form_label('Nombres', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', $student->nombre); ?></li>
		<li><?php echo form_label('Apellidos', 'apellido', array('class'=>'required')).'<br>'.form_input('apellido', $student->apellido); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Teléfono', 'telefono').'<br>'.form_input('telefono', $student->telefono); ?></li>
		<li><?php echo form_label('Correo Electronico', 'correo').'<br>'.form_input('correo', $student->email); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Dirección', 'direccion').'<br>'.form_textarea('direccion', $student->direccion); ?></li>
	</ul>
	<br>
	<h3>Datos del Estudiante</h3>
	<ul>
		<!-- <li><?php echo form_label('Aldea', 'aldea').'<br><span>Prueba</span>'?></li> -->
		<li><?php echo form_label('Pfg', 'pfg', array('class'=>'required')).'<br>'.form_dropdown('pfg', $pfg); ?></li>
	</ul>
	<br><br><br>
	<input type="submit" value="Guardar">
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(function() {
		$('#form-student').ajaxForm({
			dataType: 'json',
			success: function(response){
				console.log(response);
				// $('#search-student').select2('val','response.cedula',true);
			}
		});
	});
</script>