<?php $this->load->view('partial/header'); ?>
<section class="request">
	<h1><?php echo $title ?></h1>
	<hr>
	<?php echo form_open('requests/save', 'id="form-request"'); ?>
	<?php echo form_hidden('tipo', $type); ?>
	<div class="form-content">
		<h5 class="required align-right">Campos en rojo son obligatorios</h5>
		<ul>
			<div>
				<h3>Datos de el estudiante</h3>
				<?php echo anchor('students/view?height=480&width=650', '+', 'title="Agregar Estudiante" class="fancybox btn btn-success btn-sm"'); ?>
			</div>
			<li>
				<?php echo form_label('Cedula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?>
			</li>
			<li id="stundet-info">
				Matricula #: <span id="student-matricula">.</span>.<br>
				Nombres y Apellidos: <span id="student-name"></span>.<br>
				Aldea Actual: <span id="student-aldea"></span>.<br>
				Fecha de Emisión: <span><?php echo date('d/m/Y') ?></span>.
				<input type="hidden" id="aldea_actual" name="aldea_actual" value="">
			</li>
		</ul>
		<ul>
			<div>
				<h3>Datos de la solicitud</h3>
			</div>
			<?php if ($type == 'traslado'): ?>
			<li><?php echo form_label('Nueva Aldea:', 'aldea_nueva', array('class'=>'required')).'<br>'.form_input('aldea_nueva', '', 'id="search-aldea"'); ?></li>
			<li>
			<?php elseif($type == 'nota'): ?>
				<label for="semestre" class="required">Semestre Solicitado</label>
				<input type="number" name="semestre" id="semestre" value="1" class="form-control">
			</li>
			<?php endif ?>
		</ul>
		<ul>
			<li style=" width:100%"><?php echo form_label('Comentarios:', 'comentarios').'<br>'.form_textarea(array('name'=>'comentarios', 'cols'=>80, 'rows'=>6, 'class'=>'form-control')); ?></li>
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
	
	$("#form-request").validity(function() {
        $("#search-student").require('La cédula del estudiante es obligatoria!');
        $('#search-aldea').require('La aldea es obligatoria!');
        $('#semestre').match('integer').require().range(1,12);
    });

	$('#search-student').select2({
		placeholder: 'Cedula, Nombre o Apellido...',
		minimumInputLength: 3,
		maximumInputLength: 11,
		allowClear: true,
		width: '80%',
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
		placeholder: 'Nombre de la aldea o Municipio a la cual pertenece',
		minimumInputLength: 5,
		maximumInputLength: 11,
		allowClear: true,
		width: '100%',
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
