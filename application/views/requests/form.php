<?php $this->load->view('partial/header'); ?>
<section class="request">
	<h1><?php echo $title ?></h1>
	<hr>
	<?php echo form_open('requests/save', 'id="form-request"'); ?>
	<?php echo form_hidden('tipo', $type); ?>
	<div class="form-content">
		<h5 class="required text-right">Campos en rojo son obligatorios</h5>
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
				PFG: <span id="student-pfg"></span>.<br>
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
			<li>
				<?php echo form_label('Aldea Nueva:', 'aldea_nueva', array('class'=>'required')).'<br>'.form_input('aldea_nueva', '', 'id="search-aldea" placeholder="Debes seleccionar un estudiante primero..." disabled="disabled"'); ?>
				<p class="bg-success">El traslado a otra aldea solo se hará previamente habiendo solicitado las notas, Y unicamente a aldeas que dicten el mismo PFG que cursa el estudiante.</p>
			</li>
			<li>
			<?php elseif($type == 'nota'): ?>
				<label for="semestre" class="required">Semestre Solicitado</label>
				<input type="number" name="semestre" id="semestre" value="1" class="form-control">
			</li>
			<?php endif ?>
		</ul>
		<ul>
			<?php if ($reasons): ?>
				<li style=" width:100%"><?php echo form_label('Razon:', 'razon').'<br>'.form_dropdown('razon', $reasons, 'class="form-control"'); ?></li>
			<?php endif ?>
			<li style=" width:100%"><?php echo form_label('Comentarios:', 'comentarios').'<br>'.form_textarea(array('name'=>'comentarios', 'cols'=>80, 'rows'=>6, 'class'=>'form-control')); ?></li>
		</ul>
		<p class="text-center">
			Esta solicitud no es reversible, ni modificable una vez emitida.
		</p>
		<input type="submit" value="Solicitar" class="btn btn-default">
	</div>
	<?php echo form_close(); ?>
</section>
<?php $this->load->view('partial/footer'); ?>
<script type="text/javascript">
$(function() {
	$("#form-request").validity(function() {
        $("#search-student").require('La cédula del estudiante es obligatoria!');
        $('#search-aldea').require('La aldea nueva es obligatoria!');
        $('#semestre').match('integer').require().range(1,10);
    });

	$('#search-student').select2({
		placeholder: 'Cedula, Nombre o Apellido...',
		minimumInputLength: 4,
		maximumInputLength: 11,
		allowClear: true,
		width: '80%',
		formatSelection: function (item) { return item.id; },
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
		//console.log(val.added);
		if (val.removed) {
			$('#stundet-info').slideUp('fast');
			$("#search-aldea").attr('disabled', 'disabled').select2("destroy").val('');
		}
		if (val.added) {
			$('#student-matricula').text(val.added.student_cod);
			$('#student-name').text(val.added.text);
			$('#student-pfg').text(val.added.pfg.nombre);
			$('#student-aldea').text(val.added.aldea.nombre);
			$('#stundet-info').slideDown('slow');

			if($('#search-aldea').length == 1){
				if(val.added.can_transfer){
					$.ajax({
						url: 'index.php/universities/possible_changes',
						type: 'GET',
						dataType: 'json',
						data: {student: val.added.student_cod,pfg: val.added.pfg.nombre},
						success: function(response){
							// console.table(response);
							if (response) {
								$('#search-aldea').attr('placeholder', 'Posibles Cambios...').removeAttr('disabled')
								.select2({
									formatSelection: function (item) { return item.text; },
									data: response,
									allowClear: true,
									width: '100%'
								});
							}
						}
					});
				}else{
					button = new Array();
					button.push({
				        label: 'Solicitar Notas',
				        action: function(dialogItself){
				        	location.href = 'index.php/requests/notes';
				            dialogItself.close();
				        }
				    });
					$('#search-student').select2('val','');
					$('input[type=submit]').attr('disabled', 'disabled');
					set_feedback(false, 'Requisito', 'Este estudiante no puede solicitar traslado sin antes a ver solicitado sus notas!', 'dager', false,false, button);
				}
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
				// $.fancybox.open([{
				// 	type: 'ajax',
				// 	href: 'index.php/requests/view/'+response.request_id,
				// 	autoSize : false,
				// 	width: '530',
				// 	height: '350'
				// }]);
			}
			set_feedback(type, title, response.messagge, messaggeType, false, false);
		}
	});
});
</script>
