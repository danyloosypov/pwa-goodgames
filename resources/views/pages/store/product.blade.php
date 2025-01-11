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
                    <span>{{$product->title}}</span>
                </li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->
        <div class="container">
            <div class="row vertical-gap">
                <div class="col-lg-8">
                    <div class="nk-store-product">
                        <div class="row vertical-gap">
                            <div class="col-md-6">
                                <!-- START: Product Photos -->
                                <div class="nk-popup-gallery">
                                    <div class="nk-gallery-item-box">
                                        <a href="{{$product->image}}" class="nk-gallery-item" data-size="1200x554">
                                            <div class="nk-gallery-item-overlay">
                                                <span class="ion-eye"></span>
                                            </div>
                                            <img src="{{$product->image}}" alt="">
                                        </a>
                                    </div>
                                    <div class="nk-gap-1"></div>
                                    <div class="row vertical-gap sm-gap">
                                        @foreach (array_slice(json_decode($product->gallery), 0, 3) as $galleryItem)
                                            <div class="col-6 col-md-4">
                                                <div class="nk-gallery-item-box">
                                                    <a href="{{$galleryItem}}" class="nk-gallery-item" data-size="622x942">
                                                        <div class="nk-gallery-item-overlay">
                                                            <span class="ion-eye"></span>
                                                        </div>
                                                        <img src="{{$galleryItem}}" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- END: Product Photos -->
                            </div>
                            <div class="col-md-6">
                                <h2 class="nk-product-title h3">{{$product->title}}</h2>
                                <select class="form-control">
                                    <option value="" disabled selected>Select Platform</option>
                                    @foreach ($product->platforms as $platform)
                                        <option value="{{$platform->id}}">{{$platform->title}}</option>
                                    @endforeach
                                </select>
                                <div class="nk-product-description">
                                    {!! $product->excerpt !!}
                                </div>
                                <!-- START: Add to Cart -->
                                <div class="nk-gap-2"></div>
                                <div class="nk-product-price">₴ 32.00</div>
                                <div class="nk-gap-1"></div>
                                <button class="nk-btn nk-btn-rounded nk-btn-color-main-1" onclick="Cart.add({{$product->id}}, 1)">Add to Cart</button>
                                <div class="nk-gap-3"></div>
                                <!-- END: Add to Cart -->
                                <!-- START: Meta -->
                                <div class="nk-product-meta">
                                    <div>
                                        <strong>SKU</strong>: {{$product->sku}}
                                    </div>
                                    <div class="product-meta-values-container">
                                        <strong>Categories: </strong>
                                        <div class="product-meta-values">
                                            @foreach ($product->productCategories as $category)
                                                <div class="product-meta-value">
                                                    {{$category->title}}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="product-meta-values-container">
                                        <strong>Genres: </strong>
                                        <div class="product-meta-values">
                                            @foreach ($product->genres as $genre)
                                                <div class="product-meta-value">
                                                    {{$genre->title}}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="product-meta-values-container">
                                        <strong>Tags: </strong>
                                        <div class="product-meta-values">
                                            @foreach ($product->productTags as $tag)
                                                <div class="product-meta-value">
                                                    {{$tag->title}}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Meta -->
                            </div>
                        </div>
                        <!-- START: Share -->
                        <div class="nk-gap-2"></div>
                        <div class="nk-post-share">
                            <span class="h5">Share Product:</span>
                            <ul class="nk-social-links-2">
                                <li>
                                    <span class="nk-social-facebook" title="Share page on Facebook" data-share="facebook">
                                        <span class="fab fa-facebook"></span>
                                    </span>
                                </li>
                                <li>
                                    <span class="nk-social-google-plus" title="Share page on Google+" data-share="google-plus">
                                        <span class="fab fa-google-plus"></span>
                                    </span>
                                </li>
                                <li>
                                    <span class="nk-social-twitter" title="Share page on Twitter" data-share="twitter">
                                        <span class="fab fa-twitter"></span>
                                    </span>
                                </li>
                                <li>
                                    <span class="nk-social-pinterest" title="Share page on Pinterest" data-share="pinterest">
                                        <span class="fab fa-pinterest-p"></span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <!-- END: Share -->
                        <div class="nk-gap-2"></div>
                        <!-- START: Tabs -->
                        <div class="nk-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab-description" role="tab" data-toggle="tab">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab-reviews" role="tab" data-toggle="tab">Reviews ({{$product->reviews->count()}})</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- START: Tab Description -->
                                <div role="tabpanel" class="tab-pane fade show active" id="tab-description">
                                    <div class="nk-gap"></div>
                                    <strong class="text-white">Release Date: {{$product->release_date}}</strong>
                                    <div class="nk-gap"></div>
                                    <div class="product-content">
                                        {!! $product->content !!}
                                    </div>
                                    <div class="nk-product-info-row row vertical-gap">
                                        <div class="col-md-5">
                                            <div class="nk-product-pegi">
                                                <div class="nk-gap"></div>
                                                <img src="/images/pegi-icon.jpg" alt="">
                                                <div class="nk-product-pegi-cont">
                                                    <strong class="text-white">Pegi Rating:</strong>
                                                    <div class="nk-gap"></div>{{$product->pegi_rating}}
                                                </div>
                                                <div class="nk-gap"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="nk-gap"></div>
                                            <strong class="text-white">Customer Rating:</strong>
                                            <div class="nk-gap"></div>
                                            <div class="nk-product-rating" data-rating="{{$product->reviews_avg_rating}}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $product->reviews_avg_rating)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="nk-gap"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Tab Description -->
                                <!-- START: Tab Reviews -->
                                <div role="tabpanel" class="tab-pane fade" id="tab-reviews">
                                    <div class="nk-gap-2"></div>
                                    <!-- START: Reply -->
                                    <h3 class="h4">Add a Review</h3>
                                    <livewire:submit-review :product-id="$product->id" />
                                    <!-- END: Reply -->
                                    <div class="clearfix"></div>
                                    <div class="nk-gap-2"></div>
                                    @livewire('reviews', ['productId' => $product->id])
                                </div>
                                <!-- END: Tab Reviews -->
                            </div>
                        </div>
                        <!-- END: Tabs -->
                    </div>
                    <!-- START: Related Products -->
                    <div class="nk-gap-3"></div>
                    <h3 class="nk-decorated-h-2">
                        <span>
                            <span class="text-main-1">Related</span> Products </span>
                    </h3>
                    <div class="nk-gap"></div>
                    <div class="row vertical-gap">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="col-md-6">
                                <div class="nk-product-cat">
                                    <a class="nk-product-image" href="{{ route('product', ['product' => $relatedProduct->slug]) }}">
                                        <img src="{{$relatedProduct->image}}" alt="She gave my mother">
                                    </a>
                                    <div class="nk-product-cont">
                                        <h3 class="nk-product-title h5">
                                            <a href="{{ route('product', ['product' => $relatedProduct->slug]) }}">{{$relatedProduct->title}}</a>
                                        </h3>
                                        <div class="nk-gap-1"></div>
                                        <div class="nk-product-rating" data-rating="{{$relatedProduct->reviews_avg_rating}}">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $relatedProduct->reviews_avg_rating)
                                                    <i class="fa fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="nk-gap-1"></div>
                                        <div class="nk-product-price">₴ {{$relatedProduct->price}}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- END: Related Products -->
                </div>
                <div class="col-lg-4">
                    <x-widgets.sidebar />
                </div>
            </div>
        </div>
        <div class="nk-gap-2"></div>


    <x-slot name="metaTitle">
		{{-- {{ $metaTitle }} --}}
	</x-slot>
	
	<x-slot name="metaDescription">
		{{-- {{ $metaDescription }} --}}
	</x-slot>

</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all tab links
        const tabLinks = document.querySelectorAll('.nav-link');
        
        // Add click event listener to each tab link
        tabLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default anchor behavior
                
                // Remove 'active' class from all tab links and tab panes
                tabLinks.forEach(link => link.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });
                
                // Add 'active' class to the clicked tab link
                this.classList.add('active');
                
                // Find the corresponding tab content and activate it
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.classList.add('show', 'active');
                }
            });
        });
    });

</script>