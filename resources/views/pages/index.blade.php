<x-layout>

	<div class="nk-main">
        
		<div class="nk-gap-2"></div>
	

	
<div class="container">

<x-inc.banner />

<!-- START: Categories -->
<div class="nk-gap-2"></div>
<div class="row vertical-gap">
	<div class="col-lg-4">
		<div class="nk-feature-1">
			<div class="nk-feature-icon">
				<img src="/images/icon-mouse.png" alt="">
			</div>
			<div class="nk-feature-cont">
				<h3 class="nk-feature-title"><a href="#">PC</a></h3>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="nk-feature-1">
			<div class="nk-feature-icon">
				<img src="/images/icon-gamepad.png" alt="">
			</div>
			<div class="nk-feature-cont">
				<h3 class="nk-feature-title"><a href="#">PS4</a></h3>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="nk-feature-1">
			<div class="nk-feature-icon">
				<img src="/images/icon-gamepad-2.png" alt="">
			</div>
			<div class="nk-feature-cont">
				<h3 class="nk-feature-title"><a href="#">Xbox</a></h3>
			</div>
		</div>
	</div>
</div>
<!-- END: Categories -->

<x-index.latest-news-scroll />

<div class="nk-gap-2"></div>
<div class="row vertical-gap">
	<div class="col-lg-8">

		<x-index.latest-news-grid />

		<x-index.latest-matches />

		<x-index.tabbed-news />

		<x-index.best-selling />
	</div>
	<div class="col-lg-4">
		<x-widgets.sidebar />
	</div>
</div>
</div>

<div class="nk-gap-4"></div>

	<x-slot name="metaTitle">
		{{-- {{ $metaTitle }} --}}
	</x-slot>
	
	<x-slot name="metaDescription">
		{{-- {{ $metaDescription }} --}}
	</x-slot>

</x-layout>