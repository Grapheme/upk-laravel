@if(!empty($menu))
	<ul class="nav navbar-nav">
		@foreach($menu as $url => $name)
			<li><a href="{{slink::createLink($url)}}">{{$name}}</a></li>
		@endforeach
	</ul>
@endif