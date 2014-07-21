		<div>
			<input id="full-screen" type="button" value="Ver en Pantalla Completa" class="btn btn-default">
			<input id="print" type="button" value="Imprimir" class="btn btn-default">
			<input id="close" type="button" value="Cerrar" class="btn btn-default">
		</div>
	</div>
	<script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>js/vendor/jquery-2.0.3.min.js"><\/script>')</script>
	<script>

	$(function() {
		$('#close').click(function(event) {
			window.close();
		});
		$('#print').click(function(event) {
			window.print();
		});
		$('#full-screen').click(function(event) {
			var docElm = document.documentElement;
			if (docElm.requestFullscreen) {
			    docElm.requestFullscreen();
			}
			else if (docElm.mozRequestFullScreen) {
			    docElm.mozRequestFullScreen();
			}
			else if (docElm.webkitRequestFullScreen) {
			    docElm.webkitRequestFullScreen();
			}
		});
		if ($('.tablesorter').length > 0) {
			$(".tablesorter td.expand span").click(function(event){
		    	$(this).text($(this).text()!='+'?'+':'-').parents('tr').next().toggle();
		    });
		};	
	});
	</script>
</body>
</html>