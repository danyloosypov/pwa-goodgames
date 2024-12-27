<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">

@foreach ($_GET as $param => $val)
	@if (strncmp($param, 'utm_', 4) === 0 || $param == 'gclid')
		<meta name="robots" content="noindex,nofollow"/>
	@endif
@endforeach

@if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'facebook') !== false)
	<meta property="og:image" content="{{url('/images/og-fb.jpg')}}">
@else
	<meta property="og:image" content="{{url('/images/og.jpg')}}">
@endif

@if (Lang::langs()->count() > 1)
	@foreach (Lang::langs() as $lang)
		<link rel="alternate" hreflang="{{$lang->tag}}" href="{{Lang::url($lang->tag)}}"/>
	@endforeach
@endif

<script>
	var is_mobile = {{ Platform::mobile() ? 'true' : 'false'}}
	var lang = document.querySelector('html').getAttribute('lang')
</script>

<!-- START: Styles -->

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7cOpen+Sans:400,700" rel="stylesheet" type="text/css">

<!-- Bootstrap -->
<link rel="stylesheet" href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}">

<!-- FontAwesome -->
<script defer src="{{ asset('assets/fontawesome-free/js/all.js') }}"></script>
<script defer src="{{ asset('assets/fontawesome-free/js/v4-shims.js') }}"></script>

<!-- IonIcons -->
<link rel="stylesheet" href="{{ asset('assets/ionicons/css/ionicons.min.css') }}">

<!-- Flickity -->
<link rel="stylesheet" href="{{ asset('assets/flickity/dist/flickity.min.css') }}">

<!-- Photoswipe -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/photoswipe/dist/photoswipe.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/photoswipe/dist/default-skin/default-skin.css') }}">

<!-- Seiyria Bootstrap Slider -->
<link rel="stylesheet" href="{{ asset('assets/bootstrap-slider/dist/css/bootstrap-slider.min.css') }}">

<!-- Summernote -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/summernote/dist/summernote-bs4.css') }}">

<!-- GoodGames -->
<link rel="stylesheet" href="{{ asset('goodcss/goodgames.css') }}">
<link rel="stylesheet" href="{{ asset('goodcss/custom.css') }}">
<!-- END: Styles -->

<!-- jQuery -->
<script src="{{ asset('assets/jquery/dist/jquery.min.js') }}"></script>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<script src="{{ asset('js/slider.js') }}"></script>