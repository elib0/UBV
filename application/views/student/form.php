<?php echo form_open('students/save/', 'id="form-student"'); ?>
<div class="form-content">
	<h3>Datos personales</h3>
	<h5 class="required align-right">Campos en rojo son obligatorios</h5>
	<?php if (!$student->cedula): ?>
		<ul>
			<li><?php echo form_label('Cédula de identidad', 'cedula', array('class'=>'required')).'<br>'.form_input('cedula', $student->cedula, 'id="cedula"'); ?></li>
		</ul>
	<?php else: ?>
		<?php echo form_hidden('cedula', $student->cedula); ?>
	<?php endif ?>
	<ul>
		<li><?php echo form_label('Nombres', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', $student->nombre, 'id="nombre"'); ?></li>
		<li><?php echo form_label('Apellidos', 'apellido', array('class'=>'required')).'<br>'.form_input('apellido', $student->apellido, 'id="apellido"'); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Teléfono', 'telefono').'<br>'.form_input('telefono', $student->telefono); ?></li>
		<li><?php echo form_label('Correo Electronico', 'correo').'<br>'.form_input('correo', $student->email); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Dirección', 'direccion').'<br>'.form_textarea(array('name'=>'direccion', 'value'=>$student->direccion, 'cols'=>100, 'rows'=>3)); ?></li>
	</ul>
	<br>
	<h3>Datos del Estudiante</h3>
	<ul>
		<li><?php echo form_label('Seleccionar PFG:', 'pfg', array('class'=>'required')).'<br>'.form_input('pfg', $student->cod_pfg, 'id="search-pfg"'); ?></li>
		<li id="aldea"></li>
	</ul>
	<br><br><br>
	<input type="submit" value="Guardar" class="btn btn-default">
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(function() {
		$('#aldea').hide();

		$("#form-student").validity(function() {
	        $("#cedula, #nombre, #apellido, #search-pfg").require();
	        $('#cedula').match('integer').minLength(3).maxLength(9);
	        $('#nombre, #apellido').minLength(3).maxLength(20);
	    });

		$('#search-pfg').select2({
			placeholder: 'Buscar pfg por aldea...',
			minimumInputLength: 5,
			maximumInputLength: 20,
			formatSelection: function (item) { return item.text; },
			ajax:{
				url: 'index.php/universities/suggest_pfg',
				dataType: 'json',
				quietMillis: 100,
				data: function (term, page) {
	                return {
	                    term: term,
	                };
	            },
	            results: function (data, page) {
	                return { results: data };
	            }
			},
			initSelection: function(element, callback){
				var id=$(element).val();
		        if (id!=="") {
		            $.ajax('index.php/universities/suggest_pfg', {
		            	dataType: "json",
		                data: {term: id}
		            }).done(function(data) { console.log(data);callback(data[0]); });
		        }
			}
		}).on('select2-highlight', function(e){
			$('#aldea').text(e.choice.aldea).fadeOut('fast').fadeIn('slow');
		});

		$('#form-student').ajaxForm({
			dataType: 'json',
			success: function(response){
				var title = 'Error General';
				var type = 'alert';
				var messaggeType = 'dager';
				var closeTb = reload = false;

				if (response.status){
					title = '';
					type = false;
					messaggeType = 'success';
					closeTb = reload = true;
					if (response.person_id) {
						$('#search-student').select2('val',response.person_id,true);
						reload = false;
					};
					
				}
				set_feedback(type, title, response.messagge, messaggeType, closeTb, reload);
			}
		});
	});
</script>