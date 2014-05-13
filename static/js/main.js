function positionitems() {
  $items = $('.index-block').add('.slide-title').add('.wrapper-abs');

  var time = 200;

  $items.each(function() {
	  var that = $(this);
      setTimeout( function(){ that.css({opacity: 1}); }, time);
      time += 200;
  });
}
function slide_over() {
	$('.slideshow-after').css('width', $(window).width() - $('.wrapper-abs').width());
}
$(function(){
	$('.block-title').each(function(){
		var pad = ( $('.index-block').width() - $(this).width() ) / 2;
		$(this).css('padding-left', pad);
	});

	slide_over();
	positionitems();
});

$(window).resize(function(){
	slide_over();
});

$(window).load(function(){
	$('.fotorama-slide, .slideshow-over, .slideshow-after').addClass('loaded');
});

$('.intranet').click(function(e){
	e.stopPropagation();
	$(this).addClass('active');
	$('.sign-up').addClass('active');
});

$('.sign-up').click(function(e){
	e.stopPropagation();
});

$(document).click(function(){
	$('.intranet').removeClass('active');
	$('.sign-up').removeClass('active');
});

$('.press-btn').click( function(){
	$(this).parent().find('.articles').toggleClass('active');
});
