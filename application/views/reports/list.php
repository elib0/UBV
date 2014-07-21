<?php $this->load->view('partial/header'); ?>
<section class="report-list">
	<h1>Reportes</h1>
	<div>
		<h3>Detallados</h3>
		<ul>
			<li><?php echo anchor_popup('reports/detail/nota', 'Solicitantes de notas.', $atts) ?></li>
			<li><?php echo anchor_popup('reports/detail/traslado', 'Solicitantes de Traslados.', $atts) ?></li>
			<li><?php echo anchor_popup('reports/detail/constancia','Solicitantes de Constancias de culminacion.', $atts) ?></li>
			<li><?php echo anchor_popup('reports/detail/grado', 'Estudiantes en lista de grado.', $atts) ?></li>
		</ul>
	</div>
	<div>
		<h3>Gráficos</h3>
		<h6 class="text-danger">Nota: Estos reportes son generados con la ultima tecnología web, por lo tanto su rendimiento se vera afectado en navegadores viejos o en maquinas con poca potencia</h6>
		<ul>
			<li><?php echo anchor_popup('reports/graphical?mod=1','Solicitudes Generadas Vs Procesadas.',$atts) ?></li>
			<li><?php echo anchor_popup('reports/graphical?mod=3','Solicitudes por municipios.',$atts) ?></li>
		</ul>
	</div>
</section>
<?php $this->load->view('partial/footer'); ?>
