{{ Form::model($page, array('url'=>slink::createAuthLink('i18n_pages/update/'.$page->id),'class'=>'smart-form','id'=>'page-form','role'=>'form','method'=>'post')) }}

    <div class="well">
        <header>Для изменения страницы воспользуйтесь формой:</header>
        <fieldset>
            <section>
                @if(!$page->start_page)
                <label class="label">
                    Идентификатор страницы
                    <div class="note">Может содержать <strong>только</strong> английские буквы в нижнем регистре, цифры, знаки подчеркивания и тире</div>
                </label>
                <label class="input col-5"> <i class="icon-append fa fa-list-alt"></i>
                    {{ Form::text('slug', $page->slug) }}
                @else
                <div class="alert alert-info padding-5">
                    <i class="fa-fw fa fa-info"></i>
                    Это главная страница.
                </div>
                @endif
                </label>
            </section>
            @if(!$page->start_page)
            <section class="pull-right">
                <label class="toggle">
                    {{ Form::checkbox('in_menu', $page->in_menu) }}
                    <i data-swchon-text="да" data-swchoff-text="нет"></i>
                    Показывать в меню:
                </label>
            </section>
            @endif
            @if(Allow::valid_access('templates'))
            <section>
                <label class="label">Шаблон страницы:</label>
                <label class="select col-5">
                    @foreach($templates as $template)
                        <?php $temps[$template->name] = $template->name;?>
                    @endforeach
                    {{ Form::select('template', $temps, $page->template, array('class'=>'template-change', 'autocomplete'=>'off')) }} <i></i>
                </label>
            </section>
            @endif
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
                                    {{ Form::text('name['.$locale.']', $page_meta[$locale]->name) }}
                                </label>
                            </section>
                            <section>
                                <label class="label">Содержание</label>
                                <label class="textarea">
                                    {{ Form::textarea('content['.$locale.']', $page_meta[$locale]->content, array('class'=>'redactor-no-filter redactor_150')) }}
                                </label>
                            </section>
                        </fieldset>
                    </div>
                </section>
                @if(Allow::enabled_module('seo'))
                <section class="col col-6">
                    <div class="well">
                        @include('modules.seo.i18n_pages')
                    </div>
                </section>
                @endif
                <!-- /Form -->

            </div>
        @endforeach
        </div>
    </div>

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
