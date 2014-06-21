<section>
	<div class="align-right">Numero de solicitud: <span><?php echo $service->id ?></span></div>
	<div>
		<h3>Datos Solicitante</h3>
		Matricula: <?php echo $service->matricula ?>.<br>
		Cedula: <?php echo $service->cedula ?>.<br>
		Nombre y Apellido: <?php echo $service->nombre ?>.<br>
		Email: <?php echo mailto($service->email, $service->email) ?><br>
		Telefono de contacto: <?php echo $service->telefono ?>
	</div>
	<div>
		<h3>Datos de la Solicitud</h3>
		Requerimiento: <?php echo ucwords($service->tipo) ?><br>
		Fecha de Solicitud: <?php echo date('d F \d\e\l Y.', mysql_to_unix($service->fecha_solicitud)) ?><br>
		<?php if ($service->tipo == 'traslado'): ?>
		Traslado de: <?php echo $service->aldea_anterior ?>
		a: <?php echo $service->aldea_nueva ?>
		<?php elseif($service->tipo == 'nota'): ?>
		Notas del Semestre: <?php echo $service->semestre_solicitado ?>
		<?php endif ?>
		<br><br>Comentarios:<br>
		<?php echo ($service->comentarios != '') ? $service->comentarios : 'Sin comentarios...' ; ?>
	</div>
	<?php echo anchor('#', 'Cerrar', 'class="align-right btn btn-default"'); ?>
	<?php echo anchor_popup('requests/printing/'.$service->id, 'Imprimir', array('class'=>'align-right btn btn-warning')) ?>
	<?php echo anchor('requests/process/'.$service->id, 'Procesar', 'class="btn btn-success"'); ?>
</section>