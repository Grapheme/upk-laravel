function positionitems() {
  $items = $('.index-block').add('.slide-title').add('.wrapper-abs');

  var time = 200;

  $items.each(function() {
	  var that = $(this);
      setTimeout( function(){ that.css({opacity: 1}); }, time);
      time += 200;
  });
}
$(function(){
	$('.block-title').each(function(){
		var pad = ( $('.index-block').width() - $(this).width() ) / 2;
		$(this).css('padding-left', pad);
	});

	positionitems();
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
