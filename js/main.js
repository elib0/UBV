$(function() {
	//All Title attributes (tooltips)
	var aux = '';
	$('#wrapper').on('mouseenter','[title]',function(e){
		//mouse over (hover)
		var title=this.title||$(this).data('title');
		if(!title) return;
		aux = this.title;
		this.title='';
		$(this).data('title',title);
		var $tooltip=$('<p class="tooltip"></p>');
		$(this).data('tooltip',$tooltip);
		$tooltip.text(title).appendTo('body').fadeIn('fast');
	}).on('mousemove','[title]',function(e){
		var $tooltip=$(this).data('tooltip');
		if(!$tooltip) return;
		var mousex=e.pageX+20;//Get X coordinates
		var mousey=e.pageY+10;//Get Y coordinates
		if($tooltip.outerWidth()+mousex>=$(window).width()-5) mousex=e.pageX-10-$tooltip.outerWidth();
		if($tooltip.outerHeight()+mousey>=$(window).height()-5) mousey=e.pageY-$tooltip.outerHeight();
		$tooltip.css({top:mousey,left:mousex});
	}).on('mouseleave','[title]',function(){
		//mouse out
		var $tooltip=$(this).data('tooltip');
		if(!$tooltip) return;
		$(this).data('tooltip',null);
		$tooltip.remove();
	});

	showclock('#clock span');
});


//Funciones
function set_feedback(type, title, text, messageType, closeTb)
{
	closeTb = closeTb || false;
	if (closeTb) { tb_remove();} //Cierra el ThinckBox

	var types = new Array();
 	types['default'] = BootstrapDialog.TYPE_DEFAULT;
 	types['info'] = BootstrapDialog.TYPE_INFO;
 	types['primary'] = BootstrapDialog.TYPE_PRIMARY;
 	types['success'] = BootstrapDialog.TYPE_SUCCESS;
 	types['warning'] = BootstrapDialog.TYPE_WARNING;
 	types['danger'] = BootstrapDialog.TYPE_DANGER;

	var options = {
		'title': title,
		'message': text,
		'type': types[messageType],
		'closable': false,
        'closeByBackdrop': false,
        'closeByKeyboard': true,
        onhide: function(dialogRef){
        	if (closeTb) { location.reload(); } //Recarga si se cierra el alert
        },
        buttons: [{
	        label: 'Aceptar',
	        action: function(dialogItself){
	            dialogItself.close();
	        }
        }]
	};
	if (type=='alert'){
		BootstrapDialog.alert(options);
	}else{
		BootstrapDialog.show(options);
	}
}

function showclock(contenedor){
	var hoy=new Date();
	var h=hoy.getHours();
	var m=hoy.getMinutes();
	var s=hoy.getSeconds();

	if(s <= 9) s = '0'+s;
	if(m <= 9) m = '0'+m;

	var hora = h+":"+m+":"+s
	$(contenedor).html( hora );
	setTimeout(function(){showclock(contenedor)},500);
}