<?php $this->load->view('partial/header'); ?>
<section class="manage-students">
	<h1>Administracion de Estudiantes</h1>
	<?php echo anchor('students/view?height=500&width=800', 'Agregar Estudiante', 'title="Agregar Estudiante" class="thickbox btn btn-primary"'); ?>
	<div class="table-options">
		Busqueda y otras opciones de la Tabla
	</div>
	<table id="table-sorter" width="100%">
		<thead>
			<tr>
				<th>Cédula</th>
				<th>Nombre</th>
				<th>Apellido</th>
				<th>PFG</th>
				<th>Solicitudes</th>
				<th>Acciones</th>
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
								<?php echo anchor('students/view/'.$value->cedula.'?height=500&width=800', 'Editar', 'title="Editar Estudiante" class="thickbox btn btn-primary"'); ?>
							</td>
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
<?php $this->load->view('partial/footer'); ?>