<?php $this->load->view('partial/header'); ?>
<section class="manage-employees">
	<h1>Usuarios del Sistema</h1>
	<?php echo anchor('employees/view?height=550&width=800', 'Registrar Empleado', 'title="Registrar Empleado" class="thickbox btn btn-primary"'); ?>
	<div class="table-options">
		<?php echo form_open('employees'); ?>
		<?php echo form_label('Buscar Empleado', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"'); ?>
		<input type="submit" value="Filtrar" class="btn btn-default btn-sm">
		</form>
	</div>
	<table id="table-sorter" class="tablesorter" width="100%">
		<thead>
			<tr>
				<th>Cédula</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Tipo de empleado</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($employees->num_rows() > 0): ?>
		<?php foreach ($employees->result() as $value): ?>
			<tr>
				<td><?php echo $value->cedula ?></td>
				<td><?php echo $value->nombre ?></td>
				<td><?php echo $value->apellido ?></td>
				<td><?php echo $value->nivel ?></td>
				<td>
					<?php echo anchor('employees/view/'.$value->cedula.'?height=550&width=800', 'Editar', 'title="Editar Usuario" class="thickbox btn btn-danger btn-sm"'); ?>
				</td>
			</tr>
		<?php endforeach ?>
		<?php else: ?>
			<tr>
				<td colspan="5">No hay usuarios registrados actualmente.</td>
			</tr>	
		<?php endif ?>
		</tbody>
	</table>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
	$(function() {
		$("#table-sorter").tablesorter();
		
		$('#search-student').select2({
			placeholder: 'Cedula, Nombre o Apellido...',
			minimumInputLength: 3,
			maximumInputLength: 11,
			allowClear: true,
			formatSelection: function (item) { return item.id; },
				formatResult: function (item) { return item.text; },
			ajax:{
				url: 'index.php/employees/suggest',
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
	});
</script>