<?php echo form_open('students/save/'.$student->cedula, 'id="form-student"'); ?>
<div class="form-content">
	<h5 class="required text-right">Campos en rojo son obligatorios</h5>
	<ul>
		<div>
			<h3>Datos personales</h3>
		</div>
	<?php if (!$student->cedula): ?>
		<li><?php echo form_label('Cédula de identidad', 'cedula', array('class'=>'required')).'<br>'.form_input('cedula', $student->cedula, 'id="cedula" class="form-control"'); ?></li>
	<?php endif ?>
	</ul>
	<ul>
		<li><?php echo form_label('Nombres', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', $student->nombre, 'id="nombre" class="form-control"'); ?></li>
		<li><?php echo form_label('Apellidos', 'apellido', array('class'=>'required')).'<br>'.form_input('apellido', $student->apellido, 'id="apellido" class="form-control"'); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Teléfono', 'telefono').'<br>'.form_input('telefono', $student->telefono, 'class="form-control"'); ?></li>
		<li><?php echo form_label('Correo Electronico', 'correo').'<br>'.form_input('correo', $student->email, 'class="form-control"'); ?></li>
	</ul>
	<br>
	<ul>
		<li><?php echo form_label('Dirección', 'direccion').'<br>'.form_textarea(array('name'=>'direccion', 'value'=>$student->direccion, 'cols'=>100, 'rows'=>3, 'class'=>'form-control')); ?></li>
	</ul>
	<ul>
		<div>
			<h3>Datos del Estudiante</h3>
		</div>
		<li><?php echo form_label('Seleccionar PFG:', 'pfg', array('class'=>'required')).'<br>'.form_input('pfg', $student->cod_pfg, 'id="search-pfg"'); ?></li>
		<li>Aldea:<span id="aldea"></span></li>
	</ul>
	<br><br><br>
	<input type="submit" value="Guardar" class="btn btn-default">
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
	$(function() {
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
		            }).done(function(data) { 
		            	$('#aldea').text(data[0].aldea.nombre).show();
		            	callback(data[0]);
		            });
		        }
			}
		}).on('select2-highlight', function(e){
			$('#aldea').text(e.choice.aldea.nombre).fadeOut('fast').fadeIn('slow');
		});

		$('#form-student').ajaxForm({
			dataType: 'json',
			success: function(response){
				var title = 'Error General';
				var type = 'alert';
				var messaggeType = 'dager';
				var closeTb = false;
				var reload = false;

				if (response.status){
					title = '';
					type = false;
					messaggeType = 'success';
					closeTb = true;
					reload = true;

					if ( $('section.request').length > 0 ) {
						reload = false;
						$('#search-student').select2('val',response.person_id,true);
					};
					
				}
				set_feedback(type, title, response.messagge, messaggeType, closeTb, reload);
			}
		});
	});
</script>