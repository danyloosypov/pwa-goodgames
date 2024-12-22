<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
	
	<head>
		@include('inc.head')

		<title>{{ $metaTitle }}</title>
		<meta name="description" content="{{ $metaDescription }}">
		
		{!! SEO::robots() !!}
		{!! SEO::linkPrev() !!}
		{!! SEO::linkNext() !!}
		        
		@livewireStyles
	</head>

	<body style="--width: 0;">

		<x-inc.header />

		<div class="body-wrapper">
			{{ $slot }}
		</div>

		<x-inc.footer />

		{{ $javascript }}
		@livewireScripts
	</body>
    
</html>