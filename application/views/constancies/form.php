<?php $this->load->view('partial/header'); ?>
<section>
	<h1>Constancia de Culminación</h1>
	<hr>
	<?php echo form_open('requests/save', 'id="form-constancie"'); ?>
	<div class="form-content">
		<h5 class="required">Campos en rojo son obligatorios</h5>
		<div>
			<ul>
				<h3>Datos de el estudiante</h3>
				<li>
					<?php echo form_label('Cedula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?>
					<?php echo anchor('students/view?height=500&width=800', '+', 'title="Agregar Estudiante" class="thickbox btn btn-success btn-sm"'); ?>
				</li>
				<li id="stundet-info">
					Matricula #:<span id="student-matricula"></span><br>
					Nombres y Apellidos:<span id="student-name"></span><br>
					Aldea Actual:<span id="student-aldea"></span><br>
					Fecha de Emisión: <?php echo date('d/m/Y') ?>
				</li>
			</ul>
		</div>
		<br>
		<input type="submit" value="Solicitar" class="btn btn-default">
	</div>
	<?php echo form_close(); ?>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
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
            	console.log(data);
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
});
</script>