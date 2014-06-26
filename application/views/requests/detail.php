<section>
	<div class="align-right">Numero de solicitud: <span><?php echo $request->id ?></span></div>
	<div>
		<h3>Datos Solicitante</h3>
		Matricula: <?php echo $request->matricula ?>.<br>
		Cedula: <?php echo $request->cedula ?>.<br>
		Nombre y Apellido: <?php echo $request->nombre_estudiante ?>.<br>
		Email: <?php echo mailto($request->email, $request->email) ?><br>
		Telefono de contacto: <?php echo $request->telefono ?>
	</div>
	<div>
		<h3>Datos de la Solicitud</h3>
		Requerimiento: <?php echo ucwords($request->tipo) ?><br>
		Fecha de Solicitud: <?php echo date('d F \d\e\l Y.', mysql_to_unix($request->fecha_solicitud)) ?><br>
		Fecha de Entrega:
		<?php 
		echo ($request->fecha_retiro) ? date('d F \d\e\l Y.', mysql_to_unix($request->fecha_retiro)) : 'Sin entregar'; 
		?><br>
		<?php if ($request->tipo == 'traslado'): ?>
		Traslado de: <?php echo $request->aldea_anterior ?>
		a: <?php echo $request->aldea_nueva ?>
		<?php elseif($request->tipo == 'nota'): ?>
		Notas del Semestre: <?php echo $request->semestre_solicitado ?>
		<?php endif ?>
		<br><br>Comentarios:<br>
		<?php echo ($request->comentarios != '') ? $request->comentarios : 'Sin comentarios...' ; ?>
	</div>
	<?php echo anchor('#', 'Cerrar', 'class="align-right btn btn-default" onclick="$.fancybox.close(true); return false;"'); ?>
	<?php echo anchor_popup('requests/printing/'.$request->id, 'Imprimir', array('class'=>'align-right btn btn-warning')) ?>
	<?php
	if (!$request->status) {
	 	echo anchor('requests/process/'.$request->id, 'Procesar', 'id="btn-process-request" class="btn btn-success"'); 
	 } 
	
	?>
</section>