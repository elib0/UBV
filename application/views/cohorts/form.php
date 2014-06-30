<?php echo form_open('cohort/save/', 'id="form-cohort"'); ?>
<div>
	<h5 class="required align-right">Campos en rojo son obligatorios</h5>
	<ul>
		<li><?php echo form_label('Nombre', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', 'employee->cedula', 'id="nombre" class="form-control"'); ?></li>
	</ul>
	<ul>
		<li>
			<label for="inicio" class="required">Fecha de Inicio</label><br>
			<input type="date" name="inicio" id="inicio" class="form-control">
		</li>
		<li>
			<label for="fin" class="required">Fecha Final</label><br>
			<input type="date" name="fin" id="fin" class="form-control">
		</li>
	</ul>
	<input type="submit" value="Guardar" class="btn btn-default">
</div>
<?php echo form_close(); ?>
<script>
	$(function() {
		$("#form-cohort").validity(function() {
	        $("#inicio, #nombre, #fin").require();
	        $('#nombre').minLength(3).maxLength(15);
	        $('#inicio, #fin').match('date');
	    });
	});
</script>