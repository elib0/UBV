<section class="manage-universities">
		<div>
			<ul>
				<li>
					<h3>Aldeas Registradas</h3>
				</li>
				<li>
					<h3>Pfg</h3>
				</li>
			</ul>
		</div>
		<div>
			<ul>
				<li>
					<h3>Agregar Aldea</h3>
					<?php echo form_open('universities/save/aldea', 'id="form-univercity"'); ?>
					<div class="form-content">
						<?php echo form_label('Nombre:', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', '$univercity->nombre'); ?>
						<br>
						<?php echo form_label('Dirección:', 'direccion', array('class'=>'required')).'<br>'.form_textarea('direccion', '$univercity->direcion'); ?>
						<br>
						<?php echo form_label('Municipio:', 'municipio', array('class'=>'required')).'<br>'.form_dropdown('municipio', $municipios); ?>
					</div>
					<input type="submit" value="Guardar">
					<?php echo form_close(); ?>
				</li>
				<li>
					<h3>Agregar PFG</h3>
					<?php echo form_open('universities/save/pfg', 'id="form-pfg"'); ?>
					<div class="form-content">
						<?php echo form_label('Nombre:', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', '$univercity->nombre'); ?>
						<br>
						<?php echo form_label('Descripción:', 'descripcion', array('class'=>'required')).'<br>'.form_textarea('descripcion', '$univercity->descripcion'); ?>
						<br>
						<?php echo form_label('Aldea:', 'aldea', array('class'=>'required')).'<br>'.form_dropdown('aldea', $aldeas); ?>
					</div>
					<input type="submit" value="Guardar">
					<?php echo form_close(); ?>
				</li>
			</ul>
		</div>	
		
</section>
<script type="text/javascript">
	$(function() {
		$('#form-univercity, #form-pfg').ajaxForm({
			dataType: 'json',
			success: function(response){
				console.log(response);
			}
		});
	});
</script>