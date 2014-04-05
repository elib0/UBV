<section class="login-form">
	<h1>Control de acceso: </h1>
	<?php 
	echo form_open('login');
	echo form_label('Nombre de Usuario:', 'user');
	echo form_input(array('name'=>'username', 'id'=>'username'));
	echo '<br />';
	echo form_label('Contraseña:', 'password');
	echo form_password(array('name'=>'password', 'id'=>'password'));
	echo "<br />";
	echo form_submit('submit', 'Entrar');
	echo form_close();
	?>
</section>