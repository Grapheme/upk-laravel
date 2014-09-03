function positionitems() {
  $items = $('.index-block').add('.wrapper-abs');

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
function text_center() {
	$('.block-title').each(function(){
		var pad = ( $('.index-block').width() - $(this).width() ) / 2;
		$(this).css('padding-left', pad);
	});
}

function stiky() {
	$('.page-wrapper').css('min-height', $(window).height() - 200);
}

$(function(){
	var $fotoramaDiv = $('._fotorama').fotorama();
    var fotorama = $fotoramaDiv.data('fotorama');

	text_center();
	slide_over();
	positionitems();
	stiky();
});

$('._fotorama').on(
  'fotorama:show',
  function (e, fotorama) {
    $('.slide-title').css('opacity', 0);
    $('.slide-title').eq(fotorama.activeIndex).css('opacity', 1);
  }
);

$(window).resize(function(){
	slide_over();
	stiky();
});

$(window).load(function(){
	setTimeout(function(){
		text_center();
	}, 500);
	$('.fotorama-slide, .slideshow-over, .slideshow-after').addClass('loaded');
});

$('.index-block').on('touchstart', function(){
	$('.index-block').removeClass('active-block');
	$(this).addClass('active-block');
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



function runFormValidation(){
	
	var SecureSignUp1 = $("#signin-secure-page-form-1").validate({
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
	var SecureSignUp2 = $("#signin-secure-page-form-2").validate({
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
	var RequestToAccess = $("#request-to-access-form").validate({
		rules:{
			name: {required : true},
			organisation: {required : true},
			email: {required : true,email : true},
			phone : {required : true},
		},
		messages : {
			name : {required : 'Введите Ваше имя'},
			organisation : {required : 'Введите название организации'},
			email : {required : 'Введите Email адрес', email : 'Введите верный Email адрес'},
			phone : {required : 'Введите контактный телефон'},
		},
		errorPlacement : function(error, element) {
			error.insertAfter(element);
		},
		submitHandler: function(form) {
			var options = {target: null,dataType:'json',type:'post'};
			options.success = function(response,status,xhr,jqForm){
				if(response.status){
					$('.content').find('.desc').html(response.responseText);
					$(form).remove();
				}else{
					$(form).find('input').removeClass('valid').addClass('invalid');
				}
			}
			$(form).ajaxSubmit(options);
		}
	});
};