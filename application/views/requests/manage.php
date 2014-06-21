<?php $this->load->view('partial/header'); ?>
<section class="process-requests">
	<h1><?php echo $title ?></h1>
	<hr>
	<?php
	echo form_open('request/search', '');
	echo form_label('Buscar estudiante:', 'buscar', array('class'=>'required')).form_input('cedula', '', 'id="search-student"');
	?>
	<div class="align-right">
		Total Solicitudes: <span id="num-request"><?php echo $num_solicitudes ?></span>
	</div>
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
				<tr data-title="<?php echo $value->comentarios ?>">
					<td class="number-format"><?php echo $value->id ?></td>
					<td><?php echo $value->nombre ?></td>
					<td class="number-format"><?php echo $value->fecha_solicitud ?></td>
					<td id="<?php echo 'td-'.$value->id ?>" class="number-format"><?php echo $value->status ?></td>
					<td class="number-format">
					<?php echo anchor('requests/view/'.$value->id.'?height=320&width=530', 'Detalles', 'class="thickbox btn btn-info btn-xs"'); ?>
					<?php echo anchor_popup('requests/printing/'.$value->id, 'Imprimir', array('class'=>'btn btn-warning btn-xs')) ?>
					<?php echo anchor('requests/process/'.$value->id, 'Procesar', 'class="btn btn-success btn-xs"'); ?>
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
				<tr data-title="<?php echo $value->comentarios ?>">
					<td class="number-format"><?php echo $value->id ?></td>
					<td><?php echo $value->nombre ?></td>
					<td class="number-format"><?php echo $value->fecha_solicitud ?></td>
					<td><?php echo $value->aldea_anterior ?></td>
					<td><?php echo $value->aldea_nueva ?></td>
					<td id="<?php echo 'td-'.$value->id ?>" class="number-format"><?php echo $value->status ?></td>
					<td class="number-format">
					<?php echo anchor('requests/view/'.$value->id.'?height=320&width=530', 'Detalles', 'class="thickbox btn btn-info btn-xs"'); ?>
					<?php echo anchor_popup('requests/printing/'.$value->id, 'Imprimir', array('class'=>'btn btn-warning btn-xs')) ?>
					<?php echo anchor('requests/process/'.$value->id, 'Procesar', 'class="btn btn-success btn-xs"'); ?>
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
				<tr data-title="<?php echo $value->comentarios ?>">
					<td class="number-format"><?php echo $value->id ?></td>
					<td><?php echo $value->nombre ?></td>
					<td class="number-format"><?php echo $value->fecha_solicitud ?></td>
					<td id="<?php echo 'td-'.$value->id ?>" class="number-format"><?php echo $value->status ?></td>
					<td class="number-format">
					<?php echo anchor('requests/view/'.$value->id.'?height=320&width=530', 'Detalles', 'class="thickbox btn btn-info btn-xs"'); ?>
					<?php echo anchor_popup('requests/printing/'.$value->id, 'Imprimir', array('class'=>'btn btn-warning btn-xs')) ?>
					<?php echo anchor('requests/process/'.$value->id, 'Procesar', 'id="btn-process-request" class="btn btn-success btn-xs"'); ?>
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

	$('body').on('click', '#btn-process-request', function() {
		if (window.confirm('La solicitud pasara a estado "ENTREGADA", ¿Desea continuar?')) {
			$.ajax({
				url: this.href,
				type: 'GET',
				dataType: 'json',
				success: function(response){
					var title = 'Error General';
					var messaggeType = 'dager';
			
					if (response.status) {
						$('#td-'+response.id).text('1');
						title = '';
						messaggeType = 'success';
					}
					set_feedback('alert', title, response.messagge, messaggeType, true, false);
				}
			});
			
		}
		return false;
	});

	$('.process-request > table').on('mouseenter','tr',function(e){
		//mouse over (hover)
		var title=this.dataset.title;
		if(!title) return;
		$(this).data('title',title);
		var $tooltip=$('<p class="tooltip"></p>');
		$(this).data('tooltip',$tooltip);
		$tooltip.text('Comentarios: '+title).appendTo('body').fadeIn('fast');
	}).on('mousemove','tr',function(e){
		var $tooltip=$(this).data('tooltip');
		if(!$tooltip) return;
		var mousex=e.pageX+20;//Get X coordinates
		var mousey=e.pageY+10;//Get Y coordinates
		if($tooltip.outerWidth()+mousex>=$(window).width()-5) mousex=e.pageX-10-$tooltip.outerWidth();
		if($tooltip.outerHeight()+mousey>=$(window).height()-5) mousey=e.pageY-$tooltip.outerHeight();
		$tooltip.css({top:mousey,left:mousex});
	}).on('mouseleave','tr',function(){
		//mouse out
		var $tooltip=$(this).data('tooltip');
		if(!$tooltip) return;
		$(this).data('tooltip',null);
		$tooltip.remove();
	});
</script>