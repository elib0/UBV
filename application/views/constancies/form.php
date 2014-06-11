<?php $this->load->view('partial/header'); ?>
<h1>Constancia de Culminación</h1>
<?php echo form_open('requests/save', 'id="form-constancie"'); ?>
<div class="form-content">
	<h3>Datos de el estudiante</h3>
	<h5 class="required">Campos en rojo son obligatorios</h5>
	<div>
		<ul class="stundet-info">
			<li><?php echo form_label('Cedula Estudiante', 'buscar', array('class'=>'required')).'<br>'.form_input('cedula', '', 'id="search-student"'); ?></li>
			<li>
				<?php echo anchor('students/view?height=500&width=800', '+', 'title="Agregar Estudiante" class="thickbox btn btn-primary btn-sm"'); ?><br>
				<span>No has seleccionado ningún estudiante</span>
			</li>
		</ul>
	</div>
	<br>
	Fecha de Emisión: <?php echo date('d/m/Y') ?>
	<input type="submit" value="Solicitar">
</div>
<?php echo form_close(); ?>
<?php $this->load->view('partial/footer'); ?>
<script>
$(function() {
	$('#search-student').select2({
		placeholder: 'Numero de cedula...',
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
		}
		
		$('.stundet-info li > span').text(name);
		$('#aldea-actual').text(aldea);

	});
});
</script>