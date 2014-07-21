<?php $this->load->view('reports/partial/header', $header_config); ?>
	<table class="tablesorter">
		<thead>
			<tr>
				<th>Matricula</th>
				<th>Nombre y Apellido</th>
				<th>Estado</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($requests->num_rows() > 0): ?>
				<?php foreach ($requests->result() as $key => $request): ?>
				<tr>
					<td><?php echo $request->matricula ?></td>
					<td><?php echo $request->nombre ?></td>
					<td>Con todos los recaudos entregados</td>
				</tr>
				<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan="3">¡No hay datos actualemnte para este reporte!</td>
				</tr>
			<?php endif ?>
		</tbody>
	</table>
<?php $this->load->view('reports/partial/footer'); ?>