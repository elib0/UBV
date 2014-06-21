<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Solicitud de <?php echo ucwords($solicitud->tipo) ?></title>
</head>
<body>
	<header>
		<div class="logo"><img src="images/logo.png" alt=""></div>
	</header>
	<h5><span><?php echo $solicitud->cod_solicitud ?></span></h5>
	<h2>Solicitud de <?php echo $titulo ?></h2>
	<h2><?php echo $cod_solicitud ?></h2>
	<p>
		Nombres y Apellidos: <?php echo $solicitud->nombre ?><br>
		C.I: <?php echo $solicitud->cedula ?> Programa: <?php echo $programa ?><br>
		Cohorte: <?php echo $cohorte ?> Semestre Solicitado: <?php echo $semestre ?><br>
		Aldea Anterior: <?php echo $alde_anterior ?> Aldea Actual: <?php echo $alde_actual ?><br>
		Numero telefónico: <?php echo $telefono ?><br>
		Fecha de la solicitud <?php echo $var ?> Fecha Retiro <?php echo date('m/d/Y') ?><br><br>

		Notas: <?php echo $notas ?>
	</p>
</body>
</html>