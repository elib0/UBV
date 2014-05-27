<?php $this->load->view('partial/header'); ?>
<h1>Solicitar <?php echo $title ?></h1>
<?php echo form_open('requests/save', 'id="form-request"'); ?>
<div class="form-content">
	<h3>Datos de el estudiante</h3>
	<h5 class="required">Campos en rojo son obligatorios</h5>
	<ul>
		<li><?php echo form_label('Cédula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?></li>
		<li>
			Boton Agregar Estudiante<br>
			<span id="stundet-name">Seleccione un estudiante...</span>
		</li>
	</ul>
	<h3>Datos de la solicitud</h3>
	<ul>
		<li><?php echo form_label('Aldea Anterior', 'anterior', array('class'=>'required')).'<br>'.form_input('anterior', '$anterior'); ?></li>
		<li><?php echo form_label('Aldea Actual', 'actual', array('class'=>'required')).'<br>'.form_input('actual', '$actual'); ?></li>
	</ul>
	<br><br><br>
	<input type="submit" value="Registrar">
</div>
<?php $this->load->view('partial/footer'); ?>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(function() {
		$('#search-student').select2({
			placeholder: 'Numero de cedula...',
			minimumInputLength: 3,
			maximumInputLength: 11,
			id: 'id'
			allowClear: true,
			data:[{id:17681201,text:'Eli Jose'},{id:15496385,text:'Ramona Cochina'},{id:17888040,text:'Carlitos'},{id:3,text:'159954201'},{id:4,text:'21569874'}]
		}).change(function(val, added, removed){
			console.log(val.added);
		});

		$('#form-request').ajaxForm({
			dataType: 'json',
			success: function(response){
				console.log(response);
			}
		});
	});
</script>
