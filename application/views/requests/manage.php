<?php $this->load->view('partial/header'); ?>
<section class="process-requests">
	<h1><?php echo $title ?></h1>
	<hr>
	<?php
	echo form_open('request/search', '');
	echo form_label('Buscar estudiante:', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"');
	?>
	</form>
	<div id="stundet-info">
		Matricula #:<span id="student-matricula"></span><br>
		Nombres y Apellidos:<span id="student-name"></span><br>
		Aldea Actual:<span id="student-aldea"></span><br>
	</div>
	<div class="process-request">
		<h6>Solicitudes de Notas</h6>
		<table class="tablesorter">
			<thead>
				<tr>
					<th># Solicitud</th>
					<th>Nombre solicitante</th>
					<th>Fecha de solicitud</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
			<?php if ($nota): ?>
				<?php foreach ($nota as $key => $value): ?>
				<tr>
					<td><?php echo $value->id ?></td>
					<td><?php echo $value->nombre ?></td>
					<td><?php echo $value->fecha_solicitud ?></td>
					<td><?php echo $value->status ?></td>
					<td>
					<?php echo anchor('request/view/'.$value->id, 'Detalles', 'class="thickbox btn btn-info btn-xs"'); ?>
					<?php echo anchor_popup('request/printing/'.$value->id, 'Imprimir', array('class'=>'btn btn-warning btn-xs')) ?>
					<?php echo anchor('resquest/process/'.$value->id, 'Procesar', 'class="btn btn-success btn-xs"'); ?>
					</td>
				</tr>
				<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan="5">No hay solicitudes de traslados en estos momentos...</td>
				</tr>
			<?php endif ?>
			</tbody>
		</table>
	</div>
	<div class="process-request">
		<h6>Solicitudes de Traslados</h6>
		<table class="tablesorter">
			<thead>
				<tr>
					<th># Solicitud</th>
					<th>Nombre solicitante</th>
					<th>Fecha de solicitud</th>
					<th>Aldea Anterior</th>
					<th>Aldea Nueva</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
			<?php if ($traslado): ?>
				<?php foreach ($traslado as $key => $value): ?>
				<tr>
					<td><?php echo $value->id ?></td>
					<td><?php echo $value->nombre ?></td>
					<td><?php echo $value->fecha_solicitud ?></td>
					<td><?php echo $value->aldea_anterior ?></td>
					<td><?php echo $value->aldea_nueva ?></td>
					<td><?php echo $value->status ?></td>
					<td>
					<?php echo anchor('request/view/'.$value->id, 'Detalles', 'class="thickbox btn btn-info btn-xs"'); ?>
					<?php echo anchor_popup('request/printing/'.$value->id, 'Imprimir', array('class'=>'btn btn-warning btn-xs')) ?>
					<?php echo anchor('resquest/process/'.$value->id, 'Procesar', 'class="btn btn-success btn-xs"'); ?>
					</td>
				</tr>
				<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan="5">No hay solicitudes de traslados en estos momentos...</td>
				</tr>
			<?php endif ?>
			</tbody>
		</table>
	</div>
	<div class="process-request">
		<h6>Solicitudes de Constancias de Culminación</h6>
		<table class="tablesorter">
			<thead>
				<tr>
					<th># Solicitud</th>
					<th>Nombre solicitante</th>
					<th>Fecha de solicitud</th>
					<th>Estado</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
			<?php if ($constancia): ?>
				<?php foreach ($constancia as $key => $value): ?>
				<tr>
					<td><?php echo $value->id ?></td>
					<td><?php echo $value->nombre ?></td>
					<td><?php echo $value->fecha_solicitud ?></td>
					<td><?php echo $value->status ?></td>
					<td>
					<?php echo anchor('request/view/'.$value->id, 'Detalles', 'class="thickbox btn btn-info btn-xs"'); ?>
					<?php echo anchor_popup('request/printing/'.$value->id, 'Imprimir', array('class'=>'btn btn-warning btn-xs')) ?>
					<?php echo anchor('resquest/process/'.$value->id, 'Procesar', 'class="btn btn-success btn-xs"'); ?>
					</td>
				</tr>
				<?php endforeach ?>
			<?php else: ?>
				<tr>
					<td colspan="5">No hay solicitudes de constancias en estos momentos...</td>
				</tr>
			<?php endif ?>
			</tbody>
		</table>
	</div>
</section>
<?php $this->load->view('partial/footer'); ?>
<script>
	$('#stundet-info').hide();
	$('#search-student').select2({
		placeholder: 'Cedula, Nombre o Apellido...',
		minimumInputLength: 3,
		maximumInputLength: 11,
		allowClear: true,
		formatSelection: function (item) { return item.id; },
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
		},
		initSelection: function(element, callback){
			var id=$(element).val();
	        if (id!=="") {
	            $.ajax('index.php/students/suggest', {
	            	dataType: "json",
	                data: {term: id}
	            }).done(function(data) { callback(data[0]); });
	        }
		}
	}).change(function(val, added, removed){
		if (val.removed) {
			$('#stundet-info').slideUp('fast',function(){
				$('footer').fadeIn('400');
			});
		}
		if (val.added) {
			$('#student-matricula').text(val.added.student_cod);
			$('#student-name').text(val.added.text);
			$('#student-aldea').text(val.added.aldea.nombre);
			$('#stundet-info').slideDown('slow', function(){
				$('footer').fadeOut('400');
			});
		}
	});
</script>