<?php $this->load->view('partial/header', array('class'=>'login')); ?>
	<img src="images/logo.png" alt="">
	<section class="login-form">
		<div class="box-login">
			<p>
				Bienvenidos al sistema de administracion de la UBV. <br>
				Para continuar debes usar tu nombre de usuario y <br>
				contraseña suministrado por el coordinador o administrador del area.
			</p>
			<?php echo form_open('login'); ?>
			<table>
				<tr>
					<td class="icon-user"></td>
					<td><?php echo form_input(array('name'=>'username', 'id'=>'username', 'required'=>'required', 'placeholder'=>'Alias')); ?></td>
				</tr>
				<tr>
					<td class="icon-lock"></td>
					<td><?php echo form_password(array('name'=>'password', 'id'=>'password', 'required'=>'required','placeholder'=>'Contraseña')); ?></td>
				</tr>
			</table>
			<br>
			<?php 
			echo form_submit('submit', 'Entrar', 'class="btn btn-default"');
			echo form_close(); 
			?>
		</div>
	</section>
<?php $this->load->view('partial/footer'); ?>