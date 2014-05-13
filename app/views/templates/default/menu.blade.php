@if(!empty($menu))
<ul class="nav-list list-unstyled max-width-class text-center">
	@foreach($menu as $url => $name)
		<li class="nav-item"><a href="{{ slink::createLink($url) }}">{{$name}}</a>
	@endforeach
	</ul>
@endif