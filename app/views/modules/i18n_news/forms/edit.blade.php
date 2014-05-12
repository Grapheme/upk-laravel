{{ Form::model($news, array('url'=>slink::createAuthLink('i18n_news/update/'.$news->id),'class'=>'smart-form','id'=>'news-form','role'=>'form','method'=>'post')) }}


    <div class="well">
        <header>Для редактирования новости заполните форму:</header>
        <fieldset>
            <section class="col col-6">
                <label class="label">
                    Идентификатор новости
                    <div class="note">Может содержать <strong>только</strong> английские буквы в нижнем регистре, цифры, знаки подчеркивания и тире</div>
                </label>
                <label class="input col-11"> <i class="icon-append fa fa-list-alt"></i>
                    {{ Form::text('slug', $news->slug) }}
                </label>
            </section>
            @if(Allow::valid_access('templates'))
            <section class="col col-6">
                <label class="label">
                    Шаблон новости:
                    <div class="note">Если обычная новость - то выбирайте news.</div>
                </label>
                <label class="select col-11">
                    @foreach($templates as $template)
                        <?php $temps[$template->name] = $template->name;?>
                    @endforeach
                    {{ Form::select('template', $temps, $news->template, array('class'=>'template-change','autocomplete'=>'off')) }} <i></i>
                </label>
            </section>
            @endif
            <section class="col col-6">
                <label class="label">Дата публикации:</label>
                <label class="select col-5">
                    <input type="text" name="published_at" value="<?=date("d.m.Y", strtotime($news->published_at))?>" class="datepicker" />
                </label>
            </section>
        </fieldset>
    </div>


    <!-- Tabs -->
    <ul class="nav nav-tabs margin-top-10">
    @foreach ($locales as $l => $locale)
        <li class="{{ $l === 0 ? 'active' : '' }}">
            <a href="#lang_{{ $locale }}" data-toggle="tab">{{ $locale }}</a>
        </li>
    @endforeach
    </ul>


    <!-- Fields -->
	<div class="row margin-top-10">
        <div class="tab-content">
        @foreach ($locales as $l => $locale)
            <div class="tab-pane{{ $l === 0 ? ' active' : '' }}" id="lang_{{ $locale }}">

                <!-- Form -->
                <section class="col col-6">
                    <div class="well">
                        <header>{{ $locale }}-версия:</header>
                        <fieldset>
                            <section>
                                <label class="label">Название</label>
                                <label class="input"> <i class="icon-append fa fa-list-alt"></i>
                                    {{ Form::text('title['.$locale.']', @$news_meta[$locale]->title) }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Анонс</label>
                                <label class="input">
                                    {{ Form::textarea('preview['.$locale.']', @$news_meta[$locale]->preview, array('class'=>'redactor redactor_150')) }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Содержание</label>
                                <label class="textarea">
                                    {{ Form::textarea('content['.$locale.']', @$news_meta[$locale]->content, array('class'=>'redactor redactor_450')) }}
                                </label>
                            </section>
                        </fieldset>
        			</div>
        		</section>
        	    @if(Allow::enabled_module('seo'))
        		<section class="col col-6">
        			<div class="well">
        				@include('modules.seo.i18n_news')
        			</div>
        		</section>
            	@endif
            	<!-- /Form -->

            </div>
        @endforeach
        </div>
   	</div>

	<div style="float:none; clear:both;"></div>

    <section class="col-12">
		@include('modules.galleries.abstract')
		@include('modules.galleries.uploaded', array('gall' => $gall))
	</section>
	
    <section class="col-6">
        <footer>
        	<a class="btn btn-default no-margin regular-10 uppercase pull-left btn-spinner" href="{{URL::previous()}}">
        		<i class="fa fa-arrow-left hidden"></i> <span class="btn-response-text">Назад</span>
        	</a>
        	<button type="submit" autocomplete="off" class="btn btn-success no-margin regular-10 uppercase btn-form-submit">
        		<i class="fa fa-spinner fa-spin hidden"></i> <span class="btn-response-text">Сохранить</span>
        	</button>
        </footer>
    </section>


{{ Form::close() }}