<!--
    Additional Classes:
        .nk-header-opaque
-->
<header class="nk-header nk-header-opaque">
    <!-- START: Top Contacts -->
    <div class="nk-contacts-top">
        <div class="container">
            <div class="nk-contacts-left">
                <ul class="nk-social-links">
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
            </div>
            <div class="nk-contacts-right">
                <ul class="nk-contacts-icons">
                    <li>
                        <a href="#" data-toggle="modal" data-target="#modalSearch">
                            <span class="fa fa-search"></span>
                        </a>
                    </li>
                    <li>
                        @if (Auth::user())
                            <a href="{{route('account')}}">
                                <span class="fa fa-user"></span>
                            </a>
                        @else
                            <a href="#" data-toggle="modal" data-target="#modalLogin">
                                <span class="fa fa-user"></span>
                            </a>
                        @endif
                        
                    </li>
                    <li>
                        <span class="nk-cart-toggle">
                            <span class="fa fa-shopping-cart"></span>
                            <span class="nk-badge header-btn-count">{{Cart::count()}}</span>
                        </span>
                        <div class="nk-cart-dropdown">
                            <div id="mini-cart">
                                <x-cart.items />
                            </div>
                            <div class="nk-gap-2"></div>
                            <div class="text-center @if(Cart::count() < 1) btn-none @endif" id="cart-submit">
                                <a href="{{route('checkout')}}" class="nk-btn nk-btn-rounded nk-btn-color-main-1 nk-btn-hover-color-white">Proceed to Checkout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END: Top Contacts -->
    <nav class="nk-navbar nk-navbar-top nk-navbar-sticky nk-navbar-autohide">
        <div class="container">
            <div class="nk-nav-table">
                <a href="{{route('home')}}" class="nk-nav-logo">
                    <img src="/images/logo.png" alt="GoodGames" width="199">
                </a>
                <ul class="nk-nav nk-nav-right d-none d-lg-table-cell" data-nav-mobile="#nk-nav-mobile">
                    <li class=" nk-item">
                        <a href="{{route('blog')}}"> Blog </a>
                    </li>
                    <li class=" nk-item">
                        <a href="{{route('tournaments')}}"> Tournaments </a>
                    </li>
                    <li class=" nk-item">
                        <a href="{{route('catalog')}}"> Catalog </a>
                    </li>
                </ul>
                <ul class="nk-nav nk-nav-right nk-nav-icons">
                    <li class="single-icon d-lg-none">
                        <a href="#" class="no-link-effect" data-nav-toggle="#nk-nav-mobile">
                            <span class="nk-icon-burger">
                                <span class="nk-t-1"></span>
                                <span class="nk-t-2"></span>
                                <span class="nk-t-3"></span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END: Navbar -->
</header>
	
<div id="nk-nav-mobile" class="nk-navbar nk-navbar-side nk-navbar-right-side nk-navbar-overlay-content d-lg-none">
    <div class="nano">
        <div class="nano-content">
            <a href="{{route('home')}}" class="nk-nav-logo">
                <img src="assets/images/logo.png" alt="" width="120">
            </a>
            <div class="nk-navbar-mobile-content">
                <ul class="nk-nav">
                    <!-- Here will be inserted menu from [data-mobile-menu="#nk-nav-mobile"] -->
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END: Navbar Mobile -->

@desktopcss
<style>

</style>
@mobilecss
<style>

</style>
@endcss

@startjs
<script>

</script>
@endjs
