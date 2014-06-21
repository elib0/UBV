<?php $this->load->view('partial/header'); ?>
<section class="request">
	<h1><?php echo $title ?></h1>
	<hr>
	<?php echo form_open('requests/save', 'id="form-request"'); ?>
	<?php echo form_hidden('tipo', $type); ?>
	<div class="form-content">
		<h5 class="required">Campos en rojo son obligatorios</h5>
		<ul>
			<h3>Datos de el estudiante</h3>
			<li>
				<?php echo form_label('Cedula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?>
				<?php echo anchor('students/view?height=480&width=600', '+', 'title="Agregar Estudiante" class="thickbox btn btn-success btn-sm"'); ?><br>
			</li>
			<li id="stundet-info">
				Matricula #:<span id="student-matricula"></span><br>
				Nombres y Apellidos:<span id="student-name"></span><br>
				Aldea Actual:<span id="student-aldea"></span><br>
				Fecha de Emisión: <?php echo date('d/m/Y') ?>
				<input type="hidden" id="aldea_actual" name="aldea_actual" value="">
			</li>
		</ul>
		<ul>
			<h3>Datos de la solicitud</h3>
			<!--<li><?php //echo form_label('Semestre solicitado', 'semestre', array('class'=>'required')).'<br>'.form_dropdown('semestre', range(1, 12)); ?></li>-->
			<?php if ($type == 'traslado'): ?>
			<li><?php echo form_label('Nueva Aldea:', 'aldea_nueva', array('class'=>'required')).'<br>'.form_input('aldea_nueva', '', 'id="search-aldea"'); ?></li>
			<li>
			<?php elseif($type == 'nota'): ?>
				<label for="semestre">Semestre Solicitado</label>
				<input type="number" name="semestre" value="1" min="1" max="12">
			</li>
			<?php endif ?>
		</ul>
		<ul>
			<li style=" width:100%"><?php echo form_label('Comentarios:', 'comentarios').'<br>'.form_textarea(array('name'=>'comentarios', 'cols'=>100, 'rows'=>3)); ?></li>
		</ul>
		<p class="align-center">
			Esta solicitud no es reversible, ni modificable una vez emitida.
		</p>
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
		// formatResult: function (item) { return item.text; },
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
			$('#student-matricula').text(val.added.student_cod);
			$('#student-name').text(val.added.text);
			$('#student-aldea').text(val.added.aldea.nombre);
			$('#stundet-info').slideDown('slow');
		}
	});

	$('#search-aldea').select2({
		placeholder: 'Nombre, Municipio',
		minimumInputLength: 5,
		maximumInputLength: 11,
		allowClear: true,
		formatSelection: function (item) { return item.aldea; },
		ajax:{
			url: 'index.php/universities/suggest',
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
		}
	});

	$('#form-request').ajaxForm({
		dataType: 'json',
		success: function(response){
			var title = 'Error General';
			var type = 'alert';
			var messaggeType = 'dager';
			if (response.status){
				title = '';
				type = false;
				messaggeType = 'primary';
			}
			set_feedback(type, title, response.messagge, messaggeType, false, false);
		}
	});
});
</script>
