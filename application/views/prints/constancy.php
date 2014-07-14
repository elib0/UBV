<?php $this->load->view('prints/partial/header', array('title'=>$request->tipo)); ?>
<section class="print-constancy">
	<div>
		República Bolivariana de Venezuela <br>
		Universidad Bolivariana de Venezuela <br>
		Secretaria General <br>
		Subsecretaria del Eje Geopolitico <br>
		General José Félix Ribas <br>
		(Amazonas, Apure, Aragua, Carabobo, Cojedes, Guárico)
	</div>
	<h5>CODIGO CORRELATIVO DEL DOCUMENTO: <span><?php echo $request->id ?></span></h5>
	<h2>CONSTANCIA DE CULMINACIÓN DE ESTUDIOS</h2>
	<p>
		Quien suscribe, Hepsibah Vanessa Ojeda Caballero, Coordinadora (E) Regional del Eje  Central de la Universidad Bolivariana de Venezuela, hace constar que el (la) ciudadano (a) <?php echo $request->nombre_estudiante ?> titular de la cédula de identidad Nº<?php echo $request->cedula ?> cursó y aprobó en esta universidad todas las unidades curriculares para optar al título del PROGRAMA DE FORMACION DE GRADO (<?php echo $request->nombre_pfg ?>)
Constancia que se expide a petición de parte interesada a los efectos y fines consiguientes,  en CARABOBO a los <?php echo date('d') ?> días del mes de <?php echo date('m') ?> del año <?php echo date('Y') ?>.
	</p>
</section>
<?php $this->load->view('prints/partial/footer'); ?>