<x-layout>

    <div class="nk-main">
        <div class="nk-fullscreen-block">
            <div class="nk-fullscreen-block-top">
                <div class="text-center">
                    <div class="nk-gap-4"></div>
                    <a href="index.html">
                        <img src="/images/logo-2.png" alt="GoodGames">
                    </a>
                    <div class="nk-gap-2"></div>
                </div>
            </div>
            <div class="nk-fullscreen-block-middle">
                <div class="container text-center">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                            <h1 class="text-main-1" style="font-size: 150px;">404</h1>
                            <div class="nk-gap"></div>
                            <h2 class="h4">You chose the wrong path!</h2>
                            <div>Or such a page just doesn't exist... <br> Would you like to go back to the homepage? </div>
                            <div class="nk-gap-3"></div>
                            <a href="index.html" class="nk-btn nk-btn-rounded nk-btn-color-white">Return to Homepage</a>
                        </div>
                    </div>
                    <div class="nk-gap-3"></div>
                </div>
            </div>
            <div class="nk-fullscreen-block-bottom">
                <div class="nk-gap-2"></div>
                <ul class="nk-social-links-2 nk-social-links-center">
                    <li>
                        <a class="nk-social-rss" href="#">
                            <span class="fa fa-rss"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-social-twitch" href="#">
                            <span class="fab fa-twitch"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-social-steam" href="#">
                            <span class="fab fa-steam"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-social-facebook" href="#">
                            <span class="fab fa-facebook"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-social-google-plus" href="#">
                            <span class="fab fa-google-plus"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-social-twitter" href="#" target="_blank">
                            <span class="fab fa-twitter"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nk-social-pinterest" href="#">
                            <span class="fab fa-pinterest-p"></span>
                        </a>
                    </li>
                </ul>
                <div class="nk-gap-2"></div>
            </div>
        </div>
    </div>
    <!-- START: Page Background -->
    <div class="nk-page-background-fixed" style="background-image: url('/images/bg-fixed-2.jpg');"></div>
    <!-- END: Page Background -->
        

    <x-slot name="metaTitle">
		{{-- {{ $metaTitle }} --}}
	</x-slot>
	
	<x-slot name="metaDescription">
		{{-- {{ $metaDescription }} --}}
	</x-slot>

</x-layout>