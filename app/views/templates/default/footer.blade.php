<footer class="footer">
	<div class="footer-logo"></div>
	<div class="footer-copy">
		{{ trans('interface.FOOTER_COPYRIGHT') }}
		<div class="bot-cont">
			{{ trans('interface.FOOTER_ADDRESS') }}
            <a href="tel:+78632806656">+7 (863) 280-66-56</a>
        </div>
	</div>
	<ul class="sub-nav">
		<li class="sub-item"><a href="{{ _url('career') }}">{{ trans('interface.MENU_CAREER') }}</a>
		<li class="sub-item"><a href="{{ _url('tenders') }}">{{ trans('interface.MENU_TENDERS') }}</a>
		<li class="sub-item"><a href="{{ _url('sitemap') }}">{{ trans('interface.MENU_SITEMAP') }}</a>
	</ul>
	<div class="dev">
		{{ trans('interface.FOOTER_MAKEIN') }}
	</div>
</footer>