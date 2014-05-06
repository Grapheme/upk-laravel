@if(isset($news) && $news->count())
@foreach($news as $new)
<div class="block-w-logo" data-date="{{ myDateTime::getDayAndMonth($new->created_at) }}"></div>
<div class="block-title">{{ trans('interface.NEWS') }}</div>
<div class="block-text">{{ $new->preview }}</div>
@endforeach
@endif