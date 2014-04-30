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


function runFormValidation(){
	
	var SecureSignUp = $("#signin-secure-page-form").validate({
		rules:{
			login: {required : true},
			password : {required : true, minlength : 6},
		},
		messages : {
			login : {required : 'Введите Ваше логин'},
			password : {required : 'Введите пароль',minlength : 'Минимальная длина пароля 6 символа'},
		},
		errorPlacement : function(error, element) {
			error.insertAfter(element);
		},
		submitHandler: function(form) {
			var options = {target: null,dataType:'json',type:'post'};
			options.success = function(response,status,xhr,jqForm){
				if(response.status){
					$(form).replaceWith(response.responseText);
					if(response.redirect !== false){
						BASIC.RedirectTO(response.redirect);
					}
				}else{
					$(form).find('input').removeClass('valid').addClass('invalid');
				}
			}
			$(form).ajaxSubmit(options);
		}
	});
}