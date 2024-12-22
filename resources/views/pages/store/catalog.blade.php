<x-layout>

    <div class="nk-main">
        <!-- START: Breadcrumbs -->
        <div class="nk-gap-1"></div>
        <div class="container">
            <ul class="nk-breadcrumbs">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <a href="store.html">Store</a>
                </li>
                <li>
                    <span class="fa fa-angle-right"></span>
                </li>
                <li>
                    <span>Action Games</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->
        <div class="container">
            <!-- START: Image Slider -->
            <div class="nk-image-slider" data-autoplay="8000">
                <div class="nk-image-slider-item">
                    <img src="/images/slide-1.jpg" alt="" class="nk-image-slider-img" data-thumb="/images/slide-1-thumb.jpg">
                    <div class="nk-image-slider-content">
                        <h3 class="h4">As we Passed, I remarked</h3>
                        <p class="text-white">As we passed, I remarked a beautiful church-spire rising above some old elms in the park; and before them, in the midst of a lawn, chimneys covered with ivy, and the windows shining in the sun.</p>
                        <a href="#" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-hover-color-main-1">Read More</a>
                    </div>
                </div>
                <div class="nk-image-slider-item">
                    <img src="/images/slide-2.jpg" alt="" class="nk-image-slider-img" data-thumb="/images/slide-2-thumb.jpg">
                    <div class="nk-image-slider-content">
                        <h3 class="h4">He made his passenger captain of one</h3>
                        <p class="text-white">Now the races of these two have been for some ages utterly extinct, and besides to discourse any further of them would not be at all to my purpose. But the concern I have most at heart is for our Corporation of Poets, from whom I am preparing a petition to your Highness, to be subscribed with the names of one...</p>
                        <a href="#" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-hover-color-main-1">Read More</a>
                    </div>
                </div>
                <div class="nk-image-slider-item">
                    <img src="/images/slide-3.jpg" alt="" class="nk-image-slider-img" data-thumb="/images/slide-3-thumb.jpg">
                </div>
                <div class="nk-image-slider-item">
                    <img src="/images/slide-4.jpg" alt="" class="nk-image-slider-img" data-thumb="/images/slide-4-thumb.jpg">
                    <div class="nk-image-slider-content">
                        <h3 class="h4">At length one of them called out in a clear</h3>
                        <p class="text-white">TJust then her head struck against the roof of the hall: in fact she was now more than nine feet high...</p>
                        <a href="#" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-hover-color-main-1">Read More</a>
                    </div>
                </div>
                <div class="nk-image-slider-item">
                    <img src="/images/slide-5.jpg" alt="" class="nk-image-slider-img" data-thumb="/images/slide-5-thumb.jpg">
                    <div class="nk-image-slider-content">
                        <h3 class="h4">For good, too though, in consequence</h3>
                        <p class="text-white">She gave my mother such a turn, that I have always been convinced I am indebted to Miss Betsey for having been born on a Friday. The word was appropriate to the moment.</p>
                        <p class="text-white">My mother was so much worse that Peggotty, coming in with the teaboard and candles, and seeing at a glance how ill she was, - as Miss Betsey might have done sooner if there had been light enough, - conveyed her upstairs to her own room with all speed; and immediately dispatched Ham Peggotty, her nephew, who had been for some days past secreted in the house...</p>
                        <a href="#" class="nk-btn nk-btn-rounded nk-btn-color-white nk-btn-hover-color-main-1">Read More</a>
                    </div>
                </div>
            </div>
            <!-- END: Image Slider -->
            @livewire('catalog')
        </div>
        <div class="nk-gap-2"></div>


    <x-slot name="metaTitle">
		{{-- {{ $metaTitle }} --}}
	</x-slot>
	
	<x-slot name="metaDescription">
		{{-- {{ $metaDescription }} --}}
	</x-slot>

</x-layout>