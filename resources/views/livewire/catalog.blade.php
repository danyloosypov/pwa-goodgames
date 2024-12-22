<div>
    <!-- START: Categories -->
    <div class="nk-gap-2"></div>
    <div class="row vertical-gap">
        @foreach ($platforms as $platform)
            <div class="col-lg-4">
                <div class="nk-feature-1" 
                wire:click="updatePlatform('{{ $platform->id }}')"
                style="{{ $this->platform == $platform->id ? 'background-color: #75001c;' : '' }}"
                >
                    <div class="nk-feature-icon">
                        <img src="{{$platform->icon}}" alt="">
                    </div>
                    <div class="nk-feature-cont">
                        <h3 class="nk-feature-title">
                            <div>{{$platform->title}}</div>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- END: Categories -->
    <div class="nk-gap-2"></div>
    <div class="row vertical-gap">
        <div class="col-lg-8">
            <!-- START: Products -->
            <div class="row vertical-gap">
                @foreach ($products as $product)
                    <div class="col-md-6">
                        <div class="nk-product-cat">
                            <a class="nk-product-image" href="{{ route('product', ['product' => $product->slug]) }}">
                                <img src="{{$product->image}}" alt="So saying he unbuckled">
                            </a>
                            <div class="nk-product-cont">
                                <h3 class="nk-product-title h5">
                                    <a href="{{ route('product', ['product' => $product->slug]) }}">{{$product->title}}</a>
                                </h3>
                                <div class="nk-gap-1"></div>
                                <div class="nk-product-rating" data-rating="{{$product->reviews_avg_rating}}">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $product->reviews_avg_rating)
                                            <i class="fa fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="nk-gap-1"></div>
                                <div class="nk-product-price">₴ {{$product->price}}</div>
                                <div class="nk-gap-1"></div>
                                <div class="nk-btn nk-btn-rounded nk-btn-color-dark-3 nk-btn-hover-color-main-1">Add to Cart</div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
            <div class="nk-gap-2"></div>
            <!-- END: Products -->
            {{ $products->links() }}
        </div>
        <div class="col-lg-4">
            <aside class="nk-sidebar nk-sidebar-right nk-sidebar-sticky">
                <div class="nk-widget nk-widget-highlighted">
                    <h4 class="nk-widget-title">
                        <span>
                            <span class="text-main-1">Category</span> Menu </span>
                    </h4>
                    <div class="nk-widget-content">
                        <ul class="nk-widget-categories">
                            @foreach ($categoriesCollection as $category)
                                <li>
                                    <input type="checkbox" wire:model="categories" value="{{ $category->id }}" wire:click.prevent="updateCategories('{{ $category->id }}')" 
                                        {{ in_array($category->id, $this->categories) ? 'checked' : '' }}>
                                    <label>{{ $category->title }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="nk-widget nk-widget-highlighted">
                    <h4 class="nk-widget-title">
                        <span>
                            <span class="text-main-1">Genres</span> Menu </span>
                    </h4>
                    <div class="nk-widget-content">
                        <ul class="nk-widget-categories">
                            @foreach ($genresCollection as $genre)
                                <li>
                                    <input type="checkbox" wire:model="genres" value="{{ $genre->id }}" wire:click.prevent="updateGenres('{{ $genre->id }}')" 
                                        {{ in_array($genre->id, $this->genres) ? 'checked' : '' }}>
                                    <label>{{ $genre->title }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="nk-widget nk-widget-highlighted">
                    <h4 class="nk-widget-title">
                        <span>
                            <span class="text-main-1">Price</span> Filter
                        </span>
                    </h4>

                    <div class="nk-widget-content">
                        <div class="nk-input-slider">
                            <input type="text" name="price-filter"
                                   data-slider-min="{{ $minPriceValue }}" 
                                   data-slider-max="{{ $maxPriceValue }}" 
                                   data-slider-step="1" 
                                   data-slider-value="[{{ $minPriceValue ?? 0 }}, {{ $maxPriceValue ?? 0 }}]" 
                                   data-slider-tooltip="hide">
                            <div class="nk-gap"></div>
                            <div>
                                <div class="text-white mt-4 float-left">
                                    PRICE: 
                                    <strong class="text-main-1">₴ <span class="nk-input-slider-value-0"></span></strong> 
                                    - <strong class="text-main-1">₴ <span class="nk-input-slider-value-1"></span></strong>
                                </div>
                                <a href="#" class="nk-btn nk-btn-rounded nk-btn-color-white float-right" 
                                   wire:click.prevent="updatePrice([{{ $minPriceValue ?? 0 }}, {{ $maxPriceValue ?? 0 }}])">Apply</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>                
                <div class="nk-widget nk-widget-highlighted">
                    <h4 class="nk-widget-title">
                        <span>
                            <span class="text-main-1">We</span> Are Social </span>
                    </h4>
                    <div class="nk-widget-content">
                        <ul class="nk-social-links-3 nk-social-links-cols-4">
                            <li>
                                <a class="nk-social-twitch" href="#">
                                    <span class="fab fa-twitch"></span>
                                </a>
                            </li>
                            <li>
                                <a class="nk-social-instagram" href="#">
                                    <span class="fab fa-instagram"></span>
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
                                <a class="nk-social-youtube" href="#">
                                    <span class="fab fa-youtube"></span>
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
                            <li>
                                <a class="nk-social-rss" href="#">
                                    <span class="fa fa-rss"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <x-widgets.popular-products />
            </aside>
            <!-- END: Sidebar -->
        </div>
    </div>
</div>
