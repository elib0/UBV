<?php echo form_open('universities/save/aldea', 'id="form-univercity"'); ?>
<div class="form-content">
	<ul>
		<li>
			<h3>Agregar Aldea</h3>
			<div class="form-content">
				<?php echo form_label('Nombre:', 'nombre', array('class'=>'required')).'<br>'.form_input('nombre', $univercity->nombre, 'id="nombre" class="form-control"'); ?>
				<br>
				<?php echo form_label('Dirección:', 'direccion').'<br>'.form_textarea(array('name'=>'direccion','value'=>$univercity->direccion,'id'=>'direccion','class'=>'form-control', 'rows'=>6)); ?>
				<br>
				<?php echo form_label('Coordinador:', 'coordinador', array('class'=>'required')).'<br>'.form_input('coordinador',$univercity->cedula_coordinador, 'id="search-coordinador"'); ?>
				<br>
				<?php echo form_label('Municipio:', 'municipio', array('class'=>'required')).'<br>'.form_dropdown('municipio', $municipios,$univercity->cod_municipio, 'id="search-municipios"'); ?>
			</div>
		</li>
		<li>
			<?php echo form_label('Programa de formación de grado:', 'pfgs', array('class'=>'required')).'<br>'.form_input('pfgs', $pfgs, 'id="pfgs"'); ?>
			<p>
				Agrega los PFG pertenecientes a dicha aldea. Para separar PFG puedes usar comas (,). Ejemplo: Informática, Electricidad, Química.
			</p>
		</li>
	</ul>
</div>
<input type="submit" value="Guardar" class="align-right btn btn-default">
<?php echo form_close(); ?>
<script type="text/javascript">
	$(function() {
		$("#form-univercity").validity(function() {
	        $("#nombre").require();
	        $("#search-municipios").require('Debes seleccionar el municipio donde pertenece la aldea!');
	        $("#pfgs").require('Al menos un pfg por aldea!');
	        $("#search-coordinador").require('Obligatorio toda aldea debe tener un coordinador!');
	    });
		$('#search-municipios').select2({
			formatSelection: function (item) { return item.text; },
		}).change(function(val, added, removed){
			console.log(val.added);
		});
		$('#pfgs').select2({
			placeholder:'Nombre Pfg a agregar para esta aldea',
			tags:[],
			minimumInputLength:4,
			maximumInputLength: 20,
			tokenSeparators: [","]
		});
		$('#search-coordinador').select2({
			placeholder: 'Cedula, Nombre o Apellido...',
			minimumInputLength: 3,
			maximumInputLength: 11,
			allowClear: true,
			formatSelection: function (item) { return item.text; },
			ajax:{
				url: 'index.php/employees/suggest/2',
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
		            $.ajax('index.php/employees/suggest/2', {
		            	dataType: "json",
		                data: {term: id}
		            }).done(function(data) { callback(data[0]); });
		        }
			}
		});
		$('#form-univercity').ajaxForm({
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
				set_feedback(type, title, response.messagge, messaggeType, closeTb, false);
			}
		});
	});
</script>