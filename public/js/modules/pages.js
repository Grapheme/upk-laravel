/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */
 
$(function(){
	
	$(".remove-page").click(function() {
		var $this = this;
		$.SmartMessageBox({
			title : "Удалить страницу?",
			content : "",
			buttons : '[Нет][Да]'
		},function(ButtonPressed) {
			if(ButtonPressed == "Да") {
				$.ajax({
					url: $($this).parent('form').attr('action'),
					type: 'DELETE',dataType: 'json',
					beforeSend: function(){$($this).elementDisabled(true);},
					success: function(response,textStatus,xhr){
						if(response.status == true){
							showMessage.constructor('Удаление страницы',response.responseText);
							showMessage.smallSuccess();
							$($this).parents('tr').fadeOut(500,function(){$(this).remove();});
						}else{
							$($this).elementDisabled(false);
							showMessage.constructor('Удаление страницы','Возникла ошибка.Обновите страницу и повторите снова');
							showMessage.smallError();
						}
					},
					error: function(xhr,textStatus,errorThrown){
						$($this).elementDisabled(false);
						showMessage.constructor('Удаление страницы','Возникла ошибка.Повторите снова');
						showMessage.smallError();
					}
				});
			}
		});
		return false;
	});


/*function saveBtn(that, close){
    var $formId = $(that).attr('data-id');
    var $form = $('#' + $formId);
    var $dataArray = $form.serialize();

        $.ajax({
        url: $form.attr('action'),
        data: $dataArray,
        type: 'post',
        }).done(function(){

        $form.find('.input').removeClass('state-error');

        $.bigBox({
                title : "Page saved",
                color : "#739E73",
                timeout: 7000,
                icon : "fa fa-check",
            });

            if(close === true)
            {
                window.location.href = $(that).attr('href');
            }

        }).fail(function(data){

            var $errors = JSON.parse(data.responseJSON);

            $form.find('.input').removeClass('state-error');

            for(var key in $errors)
            {
                $('input[name=' + key + ']').parent().addClass('state-error');
                //console.log($('input[name=' + json.errors[key] + ']'));
            }

            $errorPos = $form.find('.state-error').first().parent().position().top;

            if($(window).scrollTop() > $errorPos)
            {
                $('html, body').animate({ scrollTop: $errorPos });
            }
                
            $.bigBox({
                title : "Error!",
                content : data.responseJSON,
                color : "#C46A69",
                timeout: 7000,
                icon : "fa fa-warning shake animated",
            });

        }).always(function(data){
        console.log(data);
        });
}

$('.btn-just-save').click(function(){
    saveBtn($(this));
    return false;
});

$('.btn-save-n-close').click(function(){
    saveBtn($(this), true);
    return false;
});

$('.template-select').on('change', function(){

    $_select = $(this);

    $.ajax({
        url: '{{slink::createLink('admin/temps/insert/')}}',
        data:  { id: $_select.val() },
        type: 'post'
    }).done(function(data){
        $('textarea[name=content]').text(data);

    }).fail(function(data){
        console.log(data);

    });
});*/

/*function saveBtn(that, close){
    var $formId = $(that).attr('data-id');
    var $form = $('#' + $formId);
    var $dataArray = $form.serialize();

        $.ajax({
        url: $form.attr('action'),
        data: $dataArray,
        type: 'post',
        }).done(function(){

        $form.find('.input').removeClass('state-error');

        $.bigBox({
                title : "Page saved",
                color : "#739E73",
                timeout: 7000,
                icon : "fa fa-check",
            });

            if(close === true)
            {
                window.location.href = $(that).attr('href');
            }

        }).fail(function(data){

            var $errors = JSON.parse(data.responseJSON);

            $form.find('.input').removeClass('state-error');

            for(var key in $errors)
            {
                $('input[name=' + key + ']').parent().addClass('state-error');
                //console.log($('input[name=' + json.errors[key] + ']'));
            }

            $errorPos = $form.find('.state-error').first().parent().position().top;

            if($(window).scrollTop() > $errorPos)
            {
                $('html, body').animate({ scrollTop: $errorPos });
            }
                
            $.bigBox({
                title : "Error!",
                content : data.responseJSON,
                color : "#C46A69",
                timeout: 7000,
                icon : "fa fa-warning shake animated",
            });

        }).always(function(data){
        console.log(data);
        });
}
$('.btn-just-save').click(function(){
    saveBtn($(this));
    return false;
});
$('.btn-save-n-close').click(function(){
    saveBtn($(this), true);
    return false;
});
$('.template-select').on('change', function(){

    $_select = $(this);

    $.ajax({
        url: '{{slink::createLink('admin/temps/insert/')}}',
        data:  { id: $_select.val() },
        type: 'post'
    }).done(function(data){
        $('.redactor_editor').text(data);

    }).fail(function(data){
        console.log(data);

    });
});*/
});

function runFormValidation() {
	
	var editing = $("#page-form").validate({
		rules:{
			name: {required : true}
		},
		messages : {
			name : {required : 'Укажите название страницы'},
		},
		errorPlacement : function(error, element){error.insertAfter(element.parent());},
		submitHandler: function(form) {
			var options = {target: null,dataType:'json',type:'post'};
			options.beforeSubmit = function(formData,jqForm,options){
				$(form).find('.btn-form-submit').elementDisabled(true);
			},
			options.success = function(response,status,xhr,jqForm){
				$(form).find('.btn-form-submit').elementDisabled(false);
				if(response.status){
					if(response.redirect !== false){
						BASIC.RedirectTO(response.redirect);
					}
					showMessage.constructor(response.responseText,'');
					showMessage.smallSuccess();
				}else{
					showMessage.constructor(response.responseText,response.responseErrorText);
					showMessage.smallError();
				}
			}
			$(form).ajaxSubmit(options);
		}
	});
}