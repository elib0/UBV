<?php $this->load->view('partial/header'); ?>
<section class="manage-students">
	<h1>Administracion de Estudiantes</h1>
	<?php echo anchor('students/view?height=500&width=800', 'Agregar Estudiante', 'title="Agregar Estudiante" class="thickbox big-button"'); ?>
	<div class="table-options">
		Busqueda y otras opciones de la Tabla
	</div>
	<table id="table-sorter">
		<thead>
			<tr>
				<th>Cedula</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>Mencion</th>
				<th># Solicitudes</th>
				<tbody>
					<?php if ($students->num_rows() > 0): ?>
					<?php foreach ($students->result() as $value): ?>
						<tr>
							<td><?php echo $value['cedula'] ?></td>
							<td><?php echo $value['nombre'] ?></td>
							<td><?php echo $value['apellido'] ?></td>
							<td><?php echo $value['cod_mencion'] ?></td>
							<td><?php echo $value['cedula'] ?></td>
						</tr>
					<?php endforeach ?>
					<?php else: ?>
						<tr>
							<td colspan="5">No hay estudiantes registrados actualmente</td>
						</tr>	
					<?php endif ?>
					
				</tbody>
			</tr>
		</thead>
	</table>
</section>
<script>
	
</script>
<?php $this->load->view('partial/footer'); ?>