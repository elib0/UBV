<?php $this->load->view('reports/partial/header', $header_config); ?>
	<table class="tablesorter">
		<thead>
			<tr>
				<th></th>
				<th>Matricula</th>
				<th>Nombre y Apellido</th>
				<th>Fecha de Solicitud</th>
				<th>Estado</th>
				<th>Comentarios</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($requests->num_rows() > 0): ?>
				<?php foreach ($requests->result() as $key => $request): ?>
				<tr>
					<td class="expand"><span>+</span></td>
					<td><?php echo $request->matricula ?></td>
					<td><?php echo $request->nombre ?></td>
					<td><?php echo $request->fecha_solicitud ?></td>
					<td>No Procesada</td>
					<td><?php echo ($request->comentarios != '') ? $request->comentarios : 'Sin Comentarios' ; ?></td>
				</tr>
				<?php if ($data_details && $head_details): ?>
				<tr class="tr-hidden">
					<td colspan="6">
							<table class="tablesorter">
							<thead>
								<tr>
								<?php foreach ($head_details as $value): ?>
									<th><?php echo $value ?></th>
								<?php endforeach ?>
								</tr>
							</thead>
							<tbody>
								<tr>
								<?php foreach ($data_details as $value): ?>
									<?php 
									if ($value == 'aldea_anterior' || $value == 'aldea_nueva') {
										$field = $this->University->get_aldea_info_by_pfg($request->{$value})->nombre;
									}else{
										$field = $request->{$value};
									}
									?>
									<td><?php echo $field ?></td>
								<?php endforeach ?>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<?php endif ?>
				<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan="6">¡NO hay datos actualemnte para este reporte!</td>
				</tr>
			<?php endif ?>
		</tbody>
	</table>
	<p class="bg-info">Para Mas detalles de una solicitud puede usar el simbolo (+).</p>
<?php $this->load->view('reports/partial/footer'); ?>