<?php $this->load->view('partial/header'); ?>
<section class="request">
	<h1>Solicitar <?php echo $title ?></h1>
	<?php echo form_open('requests/save', 'id="form-request"'); ?>
	<?php echo form_hidden('tipo', strtolower($title)); ?>
	<div class="form-content">
		<h5 class="required">Campos en rojo son obligatorios</h5>
		<ul class="stundet-info">
			<h3>Datos de el estudiante</h3>
			<li><?php echo form_label('Cedula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?></li>
			<li>
				<?php echo anchor('students/view?height=500&width=800', '+', 'title="Agregar Estudiante" class="thickbox btn btn-primary btn-sm"'); ?><br>
				<span>No has seleccionado ningún estudiante</span>
			</li>
		</ul>
		<ul>
			<h3>Datos de la solicitud</h3>
			<!--<li><?php //echo form_label('Semestre solicitado', 'semestre', array('class'=>'required')).'<br>'.form_dropdown('semestre', range(1, 12)); ?></li>-->
			<label for="semestre">Semestre Solicitado</label>
			<input type="number" name="semestre" value="1" min="1" max="12">
		</ul>
		<ul>
			<li><?php echo form_label('Aldea Actual', 'actual', array('class'=>'required')).'<br><span id="aldea-actual">No has seleccionado ningun estudiante</span>' ?></li>
			<li><?php echo form_label('Aldea Anterior', 'anterior', array('class'=>'required')).'<br>'.form_dropdown('anterior', $aldeas, '', 'id="aldea_anterior"'); ?></li>
			<li style=" width:100%"><?php echo form_label('Comentarios:', 'comentarios').'<br>'.form_textarea('comentarios'); ?></li>
		</ul>
		<input type="submit" value="Solicitar" class="btn btn-default">
	</div>
	<?php echo form_close(); ?>
</section>
<?php $this->load->view('partial/footer'); ?>
<script type="text/javascript">
	$(function() {
		$('#search-student').select2({
			placeholder: 'Cedula, Nombre o Apellido...',
			minimumInputLength: 3,
			maximumInputLength: 11,
			allowClear: true,
			formatSelection: function (item) { return item.id; },
  			formatResult: function (item) { return item.text; },
			ajax:{
				url: 'index.php/students/suggest',
				dataType: 'json',
				quietMillis: 100,
				data: function (term, page) {
	                return {
	                    term: term,
	                };
	            },
	            results: function (data, page) {
	            	console.log(data);
	                return { results: data };
	            }
			},
			initSelection: function(element, callback){
				var id=$(element).val();
		        if (id!=="") {
		            $.ajax('index.php/students/suggest', {
		            	dataType: "json",
		                data: {term: id}
		            }).done(function(data) { callback(data[0]); });
		        }
			}
		}).change(function(val, added, removed){
			var name = 'No has seleccionado ningun estudiante';
			var aldea = name;
			if (!val.removed) {
				name = val.added.text;
				aldea = val.added.pfg;
				$('#aldea_anterior > option[val='+val.added.pfg+']').remove();
			}
			
			$('.stundet-info li > span').text(name);
			$('#aldea-actual').text(aldea);

		});

		$('#form-request').ajaxForm({
			dataType: 'json',
			success: function(response){
				var title = 'Error General';
				var type = 'alert';
				var messaggeType = 'dager';
				var closeTb = false;
				if (response.status){
					title = '';
					type = false;
					messaggeType = 'success';
					closeTb = true;
				}
				set_feedback(type, title, response.messagge, messaggeType, closeTb);
			}
		});
	});
</script>
