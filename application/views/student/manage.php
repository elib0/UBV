<?php $this->load->view('partial/header'); ?>
<section class="manage-students">
	<h1>Administracion de Estudiantes</h1>
	<hr>
	<?php echo anchor('students/view?height=500&width=800', 'Agregar Estudiante', 'title="Agregar Estudiante" class="thickbox btn btn-primary"'); ?>
	<div class="table-options">
		<?php echo form_open('students', 'id="search-form"'); ?>
		<?php echo form_label('Buscar Estudiante', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"'); ?>
		<?php echo form_checkbox('request', 'true').form_label('Solicitudes pendiente', 'buscar', array('class'=>'required')); ?>
		<?php echo anchor('stundent', 'Reiniciar', 'class="btn btn-default btn-sm" title="Reiniciar Busqueda"'); ?>
		</form>
	</div>
	<table id="table-sorter" class="tablesorter" width="100%">
		<thead>
			<tr>
				<th>Cédula</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>PFG</th>
				<th>Solicitudes pendientes</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($students->num_rows() > 0): ?>
		<?php foreach ($students->result() as $value): ?>
			<tr>
				<td><?php echo $value->cedula ?></td>
				<td><?php echo $value->nombre ?></td>
				<td><?php echo $value->apellido ?></td>
				<td><?php echo $value->cod_pfg ?></td>
				<td><?php echo $this->Student->get_student_requests($value->cedula)->num_rows() ?></td>
				<td>
					<?php echo anchor('students/view/'.$value->cedula.'?height=500&width=800', 'Editar', 'title="Editar Estudiante" class="thickbox btn btn-danger btn-sm"'); ?>
				</td>
			</tr>
		<?php endforeach ?>
		<?php else: ?>
			<tr>
				<td colspan="5">No hay estudiantes registrados actualmente</td>
			</tr>	
		<?php endif ?>
		</tbody>
	</table>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
	$(function() {
		$("#table-sorter").tablesorter({
			headers: {5:{sorter: false},3:{sorter:false}},
			sortList: [[1,0],[2,0]]
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
	            	console.log(data);
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