$(function() {	
	//All Title attributes (tooltips)
	$('#wrapper,nav.user-menu, .logo > a').on('mouseenter','[title]',function(e){
		//mouse over (hover)
		var title=this.title||$(this).data('title');
		if(!title) return;
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

	$(window).scroll(function() {
	    if ($(this).scrollTop() > 10) {
	        $("footer").fadeOut('slow');
	    } else {
	        $("footer").fadeIn('fast');
	    }
	});

	$.validity.setup({ outputMode:"label" });
	$(".fancybox").fancybox({
		type:'ajax',
		autoSize : false,
		beforeLoad : function() {                    
            this.width = parseInt(this.href.match(/width=[0-9]+/i)[0].replace('width=',''));  
            this.height = parseInt(this.href.match(/height=[0-9]+/i)[0].replace('height=',''));
        }
	});

	showclock('#clock span');
});


//Funciones
function set_feedback(type, title, text, messageType, closeTb, reload, myButtons)
{
	myButtons = myButtons || new Array();
	closeTb = closeTb || false;
	reload = reload || false;

	if (closeTb) { $.fancybox.close(); } //Cierra el Fancybox
	//Agrega boton por defecto de cerrar(Aceptar)
	myButtons.push(
		{
	        label: 'Aceptar',
	        action: function(dialogItself){
	            dialogItself.close();
	        }
	    }
	);

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
        	if (reload) { location.reload(); } //Recarga si se cierra el alert
        },
        buttons: myButtons
	};
	if (type=='alert'){
		BootstrapDialog.alert(options);
	}else if(type=='confirm'){
		BootstrapDialog.confirm(options.title, function(result){return result;});
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