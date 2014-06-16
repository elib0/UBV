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
function set_feedback(text, classname, keep_displayed)
{
	if(text!='')
	{
		$('#feedback_bar').removeClass();
		$('#feedback_bar').addClass(classname);
		$('#feedback_bar').text(text);
		$('#feedback_bar').css('opacity','1');

		if(!keep_displayed)
		{
			$('#feedback_bar').fadeTo(5000, 1);
			$('#feedback_bar').fadeTo("fast",0);
		}
	}
	else
	{
		$('#feedback_bar').css('opacity','0');
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