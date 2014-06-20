<?php $this->load->view('partial/header'); ?>
<section class="manage-employees">
	<h1>Usuarios del Sistema</h1>
	<?php echo anchor('employees/view?height=550&width=800', 'Registrar Empleado', 'title="Registrar Empleado" class="thickbox btn btn-primary"'); ?>
	<div class="table-options">
		<?php echo form_open('employees', 'id="search-form"'); ?>
		<?php echo form_label('Buscar Empleado', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"'); ?>
		<?php echo anchor('employees', 'Reiniciar', 'class="btn btn-default btn-sm" title="Reiniciar Busqueda"'); ?>
		</form>
	</div>
	<table id="table-sorter" class="tablesorter" width="100%">
		<thead>
			<tr>
				<th>Cédula</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Tipo de empleado</th>
				<th>Estado</th>
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
				<td><?php echo (!$value->eliminado) ? 'Activo' : 'Eliminado' ; ?></td>
				<td>
					<?php echo anchor('employees/view/'.$value->cedula.'?height=550&width=800', 'Editar', 'title="Editar Usuario" class="thickbox btn btn-info btn-sm"'); ?>
					<?php echo anchor('employees/delete/'.$value->cedula, 'Deshabilitar', 'title="Deshabilitar Usuario" class="delete-user btn btn-danger btn-sm"'); ?>
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
		$("#table-sorter").tablesorter({
			headers: {4:{sorter: false}},
			sortList: [[1,0],[2,0]]
		});

		$('.delete-user').click(function(event) {
			var that = this;
			if (window.confirm('¿Realmente desea deshabilitar este usuario?')) {
				$.ajax({
					url: that.href,
					type: 'POST',
					dataType: 'json',
					success: function(response){
						var title = 'Error al Eliminar';
						var messaggeType = 'dager';
						
						if (response.status) {
							title = 'Info';
							messaggeType = 'success';

							$(that).parents('tr').fadeOut('slow', function() {
								$(this).remove();
							});
						}
						set_feedback('alert', title, response.messagge, messaggeType, false);
					}
				});
			}
		    return false;
		});

		$('#search-student').select2({
			placeholder: 'Cedula, Nombre o Apellido...',
			minimumInputLength: 3,
			maximumInputLength: 11,
			allowClear: true,
			formatSelection: function (item) { return item.id; },
			// formatResult: function (item) { return item.text; },
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
			if (val.added) {
				$('#search-form').submit();
			}
		});
	});
</script>