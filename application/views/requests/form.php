<?php $this->load->view('partial/header'); ?>
<h1>Solicitar <?php echo $title ?></h1>
<?php echo form_open('requests/save', 'id="form-request"'); ?>
<div class="form-content">
	<h3>Datos de el estudiante</h3>
	<h5 class="required">Campos en rojo son obligatorios</h5>
	<ul class="stundet-info">
		<li><?php echo form_label('Cedula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?></li>
		<li>
			<?php echo anchor('students/view?height=500&width=800', '+', 'title="Agregar Estudiante" class="thickbox btn btn-primary btn-sm"'); ?><br>
			<span>No has seleccionado ningún estudiante</span>
		</li>
	</ul>
	<h3>Datos de la solicitud</h3>
	<ul>
		<li><?php echo form_label('Aldea Anterior', 'anterior', array('class'=>'required')).'<br>'.form_input('anterior', '$anterior'); ?></li>
		<li><?php echo form_label('Aldea Actual', 'actual', array('class'=>'required')).'<br>'.form_input('actual', '$actual'); ?></li>
	</ul>
	<br><br><br>
	<input type="submit" value="Registrar">
</div>
<?php $this->load->view('partial/footer'); ?>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(function() {
		$('#search-student').select2({
			placeholder: 'Numero de cedula...',
			minimumInputLength: 3,
			maximumInputLength: 11,
			allowClear: true,
			formatSelection: function (item) { return item.id; },
  			formatResult: function (item) { return item.text; },
			ajax:{
				url: 'index.php/students/search',
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
			}
		}).change(function(val, added, removed){
			console.log(val);
			var name = 'No has seleccionado ningun estudiante';
			if (!val.removed) {
				name = val.added.text
			}
			
			$('.stundet-info li > span').text(name);
		});

		$('#form-request').ajaxForm({
			dataType: 'json',
			success: function(response){
				console.log(response);
			}
		});
	});
</script>
