<?php $this->load->view('prints/partial/header', array('title'=>$request->tipo)); ?>
<section class="print-request">
	<h5><span><?php echo $request->id ?></span></h5>
	<h2>Solicitud de <?php echo ucwords($request->tipo) ?></h2>
	<!-- <h2><?php echo $request->id ?></h2> -->
	<p>
		Nombres y Apellidos: <?php echo $request->nombre_estudiante ?><br>
		C.I: <?php echo $request->cedula ?> Programa: <?php echo $request->nombre_pfg ?><br>
		Cohorte: <?php echo $request->cod_cohorte ?> Semestre Solicitado: <?php echo $request->semestre_solicitado ?><br>

		<?php if ($request->tipo == 'traslado'): ?>
			Aldea Anterior: <?php echo $request->nombre_aldea ?> Aldea Nueva: <?php echo $request->nombre_aldea ?><br>
		<?php endif ?>
		
		Numero telefónico: <?php echo $request->telefono ?><br>
		Fecha de la solicitud <?php echo date('d F \d\e\l Y.', mysql_to_unix($request->fecha_solicitud)) ?> Fecha Retiro <?php echo date('m/d/Y') ?><br><br>

		Notas: <?php echo ($request->comentarios) ? $request->comentarios : 'Ninguna...' ; ?>
	</p>
</section>
<?php $this->load->view('prints/partial/footer'); ?>