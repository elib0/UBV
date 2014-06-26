<section class="manage-universities">
	<h1>Aldeas Registradas</h1>
	<?php echo anchor('universities/view?height=450&width=700', '+', 'title="Agregar Aldea Nueva" class="fancybox btn btn-success"'); ?>
	<div class="table-options">
		<h6>Opciones de busqueda:</h6>
		<?php echo form_open('employees', 'id="search-form"'); ?>
		<?php echo form_label('Buscar Aldea', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"'); ?>
		<?php echo anchor('employees', 'Reiniciar', 'class="btn btn-default btn-sm" title="Reiniciar Busqueda"'); ?>
		</form>
	</div>
	<table id="table-sorter" class="tablesorter">
		<thead>
			<tr>
				<th>Codigo Aldea</th>
				<th>Nombre</th>
				<th>Ubicacion</th>
				<th>Municipio</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($univercities->num_rows() > 0): ?>
		<?php foreach ($univercities->result() as $value): ?>
			<tr>
				<td class="number-format"><?php echo $value->cod_aldea ?></td>
				<td><?php echo $value->nombre ?></td>
				<td><?php echo $value->direccion ?></td>
				<td><?php echo $value->nombre_municipio ?></td>
				<td class="number-format">
					<?php echo anchor('universities/view/'.$value->cod_aldea.'/?height=450&width=700&modal=true', 'Editar', 'title="Editar Aldea" class="fancybox btn btn-info btn-sm"'); ?>
				</td>
			</tr>
		<?php endforeach ?>
		<?php else: ?>
			<tr>
				<td colspan="5">No hay aldeas registrados actualmente.</td>
			</tr>	
		<?php endif ?>
		</tbody>
	</table>
</section>
<script>
	$(function() {
		if ($('#table-sorter tbody > tr').length > 1 )  {
			$("#table-sorter").tablesorter({
				headers: {4:{sorter: false}},
				sortList: [[1,0],[3,0]]
			});
		}
	});
</script>
