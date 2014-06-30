<?php $this->load->view('partial/header'); ?>
<section class="manage-documents">
	<h1>Consignación de Recaudos</h1>
	<hr>
	<div class="table-options">
		<h6>Buscar Estudiante:</h6>
		<?php echo form_open('documents/view', 'id="form-documents"'); ?>
		<?php echo form_label('Por siguientes criterios: ', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"'); ?>
		</form>
	</div>
	<div id="stundet-info">
		Matricula #: <span id="student-matricula">.</span>.<br>
		Nombres y Apellidos: <span id="student-name"></span>.<br>
		PFG: <span id="student-pfg"></span>.<br>
		Aldea Actual: <span id="student-aldea"></span>.<br>
		Fecha de Emisión: <span><?php echo date('d/m/Y') ?></span>.
		<input type="hidden" id="aldea_actual" name="aldea_actual" value="">
	</div>
	<div class="documents-data">
		<?php echo form_open('documents/save', 'id="form-document"'); ?>
		<input type="hidden" id="cedula" name="cedula" value="">
		<div class="form-content">
			<table class="tablesorter" width="100%">
				<thead>
					<tr>
						<th colspan="2">Documentos Consignados</th>
						<th>Entregado</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=1;foreach ($documents as $key => $document): ?>
					<tr>
					<?php 
					echo '<td class="number-format">'.$i.'</td>';
					echo "<td>$document</td>";
					echo '<td class="number-format"><input id="'.$key.'" name="documents[]" type="checkbox" value="'.$key.'"></td>';
					?>
					</tr>
				<?php $i++; endforeach ?>
				</tbody>
			</table>
			<input type="submit" value="Guardar" class="btn btn-default align-right">
			<?php echo anchor_popup('documents/printing/', 'Imprimir', array('class'=>'align-right btn btn-warning', 'id'=>'btn-print-document')) ?>
		</div>
		<?php echo form_close(); ?>
	</div>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
	$(function() {
		$("#form-document").validity(function() {
	        $("#search-student").require('La cédula del estudiante es obligatoria!');
	    });
		$('#search-student').select2({
			placeholder: 'Cedula, Nombre o Apellido...',
			minimumInputLength: 3,
			maximumInputLength: 11,
			allowClear: true,
			width: '50%',
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
			}
		}).change(function(val, added, removed){
			if (val.removed) {
				$('input:checked').removeAttr('checked');
				$('#stundet-info').slideUp('fast');
				$('.documents-data').slideUp('fast');
			}
			if (val.added) {
				$('#student-matricula').text(val.added.student_cod);
				$('#student-name').text(val.added.text);
				$('#student-pfg').text(val.added.pfg.nombre);
				$('#student-aldea').text(val.added.aldea.nombre);

				$('#cedula').val(val.added.id);
				$('#form-documents').ajaxSubmit({
					dataType: 'json',
					success: function(response){
						$('.documents-data').slideDown('slow');
						console.log(response);
						for (var i in response) {
							if(response[i] == 1){
								$('#'+i).attr('checked','checked');
							}
						}
					}
				});

				//Mostramos
				$('#stundet-info').slideDown('slow');
			}
		});

		$('#form-document').ajaxForm({
			dataType: 'json',
			success: function(response){
				var title = 'Error General';
				var type = 'alert';
				var messaggeType = 'dager';
				if (response.status){
					title = '';
					type = false;
					messaggeType = 'primary';

					$('#btn-print-document').fadeIn('fast');
				}
				set_feedback(type, title, response.messagge, messaggeType, false, false);
			}
		});
	});
</script>