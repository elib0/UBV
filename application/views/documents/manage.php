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
			<input type="submit" value="Guardar" class="btn btn-default">
			<?php echo anchor_popup('documents/printing/', 'Imprimir', array('class'=>'align-right btn btn-warning')) ?>
		</div>
		<?php echo form_close(); ?>
	</div>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
	$(function() {
		$('.documents-data').hide();

		$("#form-document").validity(function() {
	        $("#search-student").require('La cédula del estudiante es obligatoria!');
	    });
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
			}
		}).change(function(val, added, removed){
			if (val.removed) {
				$('.documents-data').slideUp('fast');
				$('cedula').val('');
			}
			if (val.added) {
				$('#cedula').val(val.added.id);
				$('#form-documents').ajaxSubmit({
					dataType: 'json',
					success: function(response){
							$('.documents-data').slideDown('fast');
							console.log(response);
						}
				});
			}
		});
	});
</script>