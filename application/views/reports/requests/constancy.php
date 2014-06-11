<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Constancia de Culminación</title>
</head>
<body>
	<header>
		<div class="logo"><img src="images/logo.png" alt=""></div>
		<div>
			República Bolivariana de Venezuela <br>
			Universidad Bolivariana de Venezuela <br>
			Secretaria General <br>
			Subsecretaria del Eje Geopolitico <br>
			General José Félix Ribas <br>
			(Amazonas, Apure, Aragua, Carabobo, Cojedes, Guárico)
		</div>
	</header>
	<h5>CODIGO CORRELATIVO DEL DOCUMENTO: <span><?php echo $cod ?></span></h5>
	<h2>CONSTANCIA DE CULMINACIÓN DE ESTUDIOS</h2>
	<p>
		Quien suscribe, Hepsibah Vanessa Ojeda Caballero, Coordinadora (E) Regional del Eje  Central de la Universidad Bolivariana de Venezuela, hace constar que el (la) ciudadano (a) <?php echo $apellido.' '.$nombre ?> titular de la cédula de identidad Nº<?php echo $cedula ?> cursó y aprobó en esta universidad todas las unidades curriculares para optar al título del PROGRAMA DE FORMACION DE GRADO EN ESTUDIOS JURIDICOS (<?php echo $pfg ?>)
Constancia que se expide a petición de parte interesada a los efectos y fines consiguientes,  en CARABOBO a los <?php echo date('d') ?> días del mes de <?php echo date('m') ?> del año <?php echo date('Y') ?>. (<?php echo date('d/m/Y') ?>) 

	</p>
</body>
</html>