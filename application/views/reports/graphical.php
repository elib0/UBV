<?php $this->load->view('reports/partial/header', $header_config); ?>
	<section class="graphical-report">
		<canvas id="canvas" height="400" width="400"></canvas>
	</section>
	<script src="<?php echo base_url(); ?>js/Chart.min.js"></script>
<?php $this->load->view('reports/partial/footer'); ?>
<script>
	$(function() {
		$.ajax({
			url: 'ajax_graphical',
			type: 'POST',
			dataType: 'json',
			data: {type: '<?php echo $type ?>'},
			success: function(response){
				console.log(response);
				var ctx = document.getElementById("canvas").getContext("2d");
				var graph = new Chart(ctx);

				if (response.type == 'pie') {
					graph.Pie(response.data);
				}else{
					graph.Line(response.data);
				}
			},
			error: function(jqXHR, textStatus){
				console.log(jqXHR)
				console.log(textStatus)
			}
		});
	});
</script>