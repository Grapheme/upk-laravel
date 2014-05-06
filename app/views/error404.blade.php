@extends('templates.default')

@section('content')

<main class="container about">
            <div class="not-found">
                <div class="not-found-content">
                    <div class="not-found-text">
                        @if(!isset($message) || empty($message))
							<span>{{trans('interface.not_found')}}</span>
	                        <span>{{trans('interface.back_main', array('link' => URL::to('/')))}}</span>
						@else
							<span>{{ $message }}</span>
						@endif
                    </div>
                </div>
            </div>
        </main>
@stop