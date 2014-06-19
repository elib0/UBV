<?php $this->load->view('partial/header'); ?>
<section class="request">
	<h1><?php echo $title ?></h1>
	<hr>
	<?php echo form_open('requests/save', 'id="form-request"'); ?>
	<?php echo form_hidden('tipo', strtolower($title)); ?>
	<div class="form-content">
		<h5 class="required">Campos en rojo son obligatorios</h5>
		<ul>
			<h3>Datos de el estudiante</h3>
			<li>
				<?php echo form_label('Cedula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?>
				<?php echo anchor('students/view?height=500&width=800', '+', 'title="Agregar Estudiante" class="thickbox btn btn-primary btn-sm"'); ?><br>
			</li>
			<li id="stundet-info">
				Matricula #:<span id="student-matricula"></span><br>
				Nombres y Apellidos:<span id="student-name"></span><br>
				Aldea Actual:<span id="student-aldea"></span>
			</li>
		</ul>
		<ul>
			<h3>Datos de la solicitud</h3>
			<!--<li><?php //echo form_label('Semestre solicitado', 'semestre', array('class'=>'required')).'<br>'.form_dropdown('semestre', range(1, 12)); ?></li>-->
			<li>
				<label for="semestre">Semestre Solicitado</label>
				<input type="number" name="semestre" value="1" min="1" max="12">
			</li>
			<li><?php echo form_label('Aldea Anterior', 'anterior', array('class'=>'required')).'<br>'.form_dropdown('anterior', $aldeas, '', 'id="aldea_anterior"'); ?></li>
		</ul>
		<ul>
			<li style=" width:100%"><?php echo form_label('Comentarios:', 'comentarios').'<br>'.form_textarea('comentarios'); ?></li>
		</ul>
		<input type="submit" value="Solicitar" class="btn btn-default">
	</div>
	<?php echo form_close(); ?>
</section>
<?php $this->load->view('partial/footer'); ?>
<script type="text/javascript">
$(function() {
	$('#stundet-info').hide();
	$('#search-student').select2({
		placeholder: 'Cedula, Nombre o Apellido...',
		minimumInputLength: 3,
		maximumInputLength: 11,
		allowClear: true,
		formatSelection: function (item) { return item.id; },
			formatResult: function (item) { return item.text; },
		ajax:{
			url: 'index.php/students/suggest',
			dataType: 'json',
			quietMillis: 100,
			data: function (term, page) {
                return {
                    term: term,
                };
            },
            results: function (data, page) {
                return { results: data };
            }
		},
		initSelection: function(element, callback){
			var id=$(element).val();
	        if (id!=="") {
	            $.ajax('index.php/students/suggest', {
	            	dataType: "json",
	                data: {term: id}
	            }).done(function(data) { callback(data[0]); });
	        }
		}
	}).change(function(val, added, removed){
		if (val.removed) {
			$('#stundet-info').slideUp('fast');
		}
		if (val.added) {
			console.log(val.added);
			$('#student-matricula').text(val.added.student_cod);
			$('#student-name').text(val.added.text);
			$('#student-aldea').text(val.added.aldea.nombre);
			$('#stundet-info').slideDown('slow');
		}
	});

	$('#form-request').ajaxForm({
		dataType: 'json',
		success: function(response){
			var title = 'Error General';
			var type = 'alert';
			var messaggeType = 'dager';
			var closeTb = false;
			if (response.status){
				title = '';
				type = false;
				messaggeType = 'primary';
				closeTb = true;
			}
			set_feedback(type, title, response.messagge, messaggeType, closeTb);
			// $('#search-student').select2('val','response.cedula',true);
		}
	});
});
</script>
