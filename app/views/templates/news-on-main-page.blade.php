@if(isset($news) && $news->count())
@foreach($news as $new)
<div class="block-w-logo" data-date="{{ myDateTime::getDayAndMonth($new->created_at) }}"></div>
<div class="block-title">Новости</div>
<div class="block-text">{{ Str::limit($new->content,200) }}</div>
@endforeach
@endif