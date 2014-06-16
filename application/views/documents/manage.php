<?php $this->load->view('partial/header'); ?>
<section class="manage-documents">
	<h1>Consignación de Recaudos</h1>
	<div class="table-options">
		<?php echo form_open('documents/view'); ?>
		<?php echo form_label('Buscar Estudiante', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"'); ?>
		<input type="submit" value="Consultar" class="btn btn-default btn-sm">
		</form>
	</div>
	<div class="documents-data">
		<?php echo form_open('documents/save'); ?>
		<table id="table-sorter" width="100%">
			<tr>
				<th colspan="2">Documentos Consignados</th>
				<th>Entregado</th>
			</tr>
			<tr>
				<td>1</td>
				<td>Verificación Académica</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>2</td>
				<td>Carta o Constancia de Culminación del Trayecto Inicial</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>3</td>
				<td>Constancia del cumplimiento del Servicio Comunitario</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>4</td>
				<td>Constancia de Presentación del Trabajo Especial de Grado</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>5</td>
				<td>Comprobante de Consignación de recaudos</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>6</td>
				<td>Una Fotografía de frente tamaño carnet</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>7</td>
				<td>Copia de Cédula de Identidad tamaño carta  legible</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>8</td>
				<td>Partida de Nacimiento o Datos filiatorios</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>9</td>
				<td>Copia simple del Título de Bachiller</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>10</td>
				<td>Fondo Negro del Título de Bachiller</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>11</td>
				<td>Autenticidad del Título de Bachiller</td>
				<td><input type="checkbox"></td>
			</tr>
			<tr>
				<td>11</td>
				<td>Notas de 1ero a 5to año</td>
				<td><input type="checkbox"></td>
			</tr>
		</table>
		<?php echo form_close(); ?>
	</div>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
	$('#search-student').select2({
			placeholder: 'Numero de cedula...',
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
			}
		}).change(function(val, added, removed){
			var name = 'No has seleccionado ningun empleado';
			if (!val.removed) {
				name = val.added.text;
			}
			
			$('.stundet-info li > span').text(name);
		});
</script>