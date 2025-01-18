<x-layout>
    <div class="nk-main">
        <!-- START: Breadcrumbs -->
        <div class="nk-gap-1"></div>
        <div class="container">
            <ul class="nk-breadcrumbs">
                <li><a href="index.html">Home</a></li>
                <li><span class="fa fa-angle-right"></span></li>
                <li><a href="store.html">Store</a></li>
                <li><span class="fa fa-angle-right"></span></li>
                <li><span>Action Games</span></li>
            </ul>
        </div>
        <div class="nk-gap-1"></div>
        <!-- END: Breadcrumbs -->

        <div class="container">
            <x-inc.banner />
            <div>
                <!-- START: Categories -->
                <div class="nk-gap-2"></div>
                <div class="row vertical-gap">
                    @foreach ($platforms as $platform)
                        <div class="col-lg-4">
                            <div class="nk-feature-1 platform" 
                                data-platform="{{ $platform->id }}"
                                style="{{ $platformActive == $platform->id ? 'background-color: #75001c;' : '' }}">
                                <div class="nk-feature-icon">
                                    <img src="{{ $platform->icon }}" alt="">
                                </div>
                                <div class="nk-feature-cont">
                                    <h3 class="nk-feature-title">
                                        <div>{{ $platform->title }}</div>
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
                                            <img src="{{ $product->image }}" alt="Product image">
                                        </a>
                                        <div class="nk-product-cont">
                                            <h3 class="nk-product-title h5">
                                                <a href="{{ route('product', ['product' => $product->slug]) }}">{{ $product->title }}</a>
                                            </h3>
                                            <div class="nk-gap-1"></div>
                                            <div class="nk-product-rating" data-rating="{{ $product->reviews_avg_rating }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $product->reviews_avg_rating)
                                                        <i class="fa fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <div class="nk-gap-1"></div>
                                            <div class="nk-product-price">₴ {{ $product->price }}</div>
                                            <div class="nk-gap-1"></div>
                                            <div class="nk-btn nk-btn-rounded nk-btn-color-dark-3 nk-btn-hover-color-main-1 add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</div>
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
                                        <span class="text-main-1">Category</span> Menu 
                                    </span>
                                </h4>
                                <div class="nk-widget-content">
                                    <ul class="nk-widget-categories">
                                        @foreach ($categoriesCollection as $category)
                                            <li>
                                                <input type="checkbox" class="category-filter" data-category-id="{{ $category->id }}">
                                                <label>{{ $category->title }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="nk-widget nk-widget-highlighted">
                                <h4 class="nk-widget-title">
                                    <span>
                                        <span class="text-main-1">Genres</span> Menu 
                                    </span>
                                </h4>
                                <div class="nk-widget-content">
                                    <ul class="nk-widget-categories">
                                        @foreach ($genresCollection as $genre)
                                            <li>
                                                <input type="checkbox" class="genre-filter" data-genre-id="{{ $genre->id }}">
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
                                        <input type="range" id="price-range" min="{{ $minPriceValue }}" max="{{ $maxPriceValue }}" value="{{ $minPriceValue }}">
                                        <div class="nk-gap"></div>
                                        <div>
                                            <div class="text-white mt-4 float-left">
                                                PRICE: 
                                                <strong class="text-main-1">₴ <span id="price-min">{{ $minPriceValue }}</span></strong> 
                                                - <strong class="text-main-1">₴ <span id="price-max">{{ $maxPriceValue }}</span></strong>
                                            </div>
                                            <button class="nk-btn nk-btn-rounded nk-btn-color-white float-right" id="apply-price-filter">Apply</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>            
        </div>
        <div class="nk-gap-2"></div>

    <x-slot name="metaTitle"></x-slot>
    <x-slot name="metaDescription"></x-slot>

</x-layout>

<script>
    // Handle platform selection
    document.querySelectorAll('.platform').forEach(platform => {
        platform.addEventListener('click', function() {
            document.querySelectorAll('.platform').forEach(p => p.style.backgroundColor = '');
            this.style.backgroundColor = '#75001c';
            const platformId = this.dataset.platform;

            // Make AJAX request using custom req object
            req.post('/catalog-offline', { platform: platformId }).then(response => {
                if (response.success) {
                    console.log('Filtered Products:', response.data);
                    // Update the products UI with the response data
                } else {
                    console.error('Failed to fetch products');
                }
            });
        });
    });


    document.querySelectorAll('.category-filter').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const categoryId = this.dataset.categoryId;
            const checked = this.checked;

            // Make AJAX request using custom req object
            req.post('/catalog-offline', { categories: checked ? [categoryId] : [] }).then(response => {
                if (response.success) {
                    console.log('Filtered Products:', response.data);
                    // Update the products UI with the response data
                } else {
                    console.error('Failed to fetch products');
                }
            });
        });
    });

    document.querySelectorAll('.genre-filter').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const genreId = this.dataset.genreId;
            const checked = this.checked;

            // Make AJAX request using custom req object
            req.post('/catalog-offline', { genres: checked ? [genreId] : [] }).then(response => {
                if (response.success) {
                    console.log('Filtered Products:', response.data);
                    // Update the products UI with the response data
                } else {
                    console.error('Failed to fetch products');
                }
            });
        });
    });


    // Handle price filter
    const priceRange = document.getElementById('price-range');
    const priceMin = document.getElementById('price-min');
    const priceMax = document.getElementById('price-max');
    const applyPriceFilter = document.getElementById('apply-price-filter');

    priceRange.addEventListener('input', function() {
        priceMin.textContent = this.value;
    });

    applyPriceFilter.addEventListener('click', function() {
        const minPrice = document.getElementById('min-price').value;
        const maxPrice = document.getElementById('max-price').value;

        // Make AJAX request using custom req object
        req.post('/catalog-offline', { minPrice, maxPrice }).then(response => {
            if (response.success) {
                console.log('Filtered Products:', response.data);
                // Update the products UI with the response data
            } else {
                console.error('Failed to fetch products');
            }
        });
    });

    const req = {
		count: 0,
		loader: document.getElementById('loader'),
		async request(method, endpoint, obj, isFile = false, isLoader = true) {
			try {

				if (isLoader) {
					this.count++
					this.loader.classList.add('active')
				}

				let headers = {
					'Accept': 'application/json',
					'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
				}

				if (method == 'GET') {

					var response = await fetch(endpoint + '?' + this.serialize(obj), {
						method: method,
						headers: headers,
					})

				} else if (isFile) {

					// headers['Content-Type'] = 'multipart/form-data'

					var response = await fetch(endpoint, {
						method: method,
						headers: headers,
						body: this.formdata(obj)
					})

				} else {

					// headers['Content-Type'] = 'application/x-www-form-urlencoded'
					headers['Content-Type'] = 'application/json'

					var response = await fetch(endpoint, {
						method: method,
						headers: headers,
						body: JSON.stringify(obj),
						// body: this.serialize(obj)
					})
				}
				
				let json = []
				let success = true

				try {
					json = await response.json()
				} catch (error) {
					success = false
				}

				// TODO: add HTTP response code

				if (isLoader) {
					
					this.count--

					if (this.count == 0) {

						this.loader.classList.remove('active')
					}
				}

				return {
					success: success && response.status === 200,
					status: response.status,
					data: json,
				}

			} catch (error) {

				console.error(error)
			}

			return {success: false, status: 0, data: {}}
		},
		async post(endpoint, obj, isFile = false, isLoader = true) {

			return await this.request("POST", endpoint, obj, isFile, isLoader)
		},
		async get(endpoint, obj, isFile = false, isLoader = true) {

			return await this.request("GET", endpoint, obj, isFile, isLoader)
		},
		async put(endpoint, obj, isFile = false, isLoader = true) {

			return await this.request("PUT", endpoint, obj, isFile, isLoader)
		},
		async delete(endpoint, obj, isFile = false, isLoader = true) {

			return await this.request("DELETE", endpoint, obj, isFile, isLoader)
		},
		serialize(obj, prefix) {
            let str = [], p;
            for (p in obj) {
                if (obj.hasOwnProperty(p)) {
                    let k = prefix ? prefix + "[" + p + "]" : p,
                        v = obj[p];
                    str.push((v !== null && typeof v === "object") ?
                        this.serialize(v, k) :  // Use 'this.serialize' to recursively call the method
                        encodeURIComponent(k) + "=" + encodeURIComponent(v));
                }
            }
            return str.join("&");
        },
		formdata(obj) {

			let formData = new FormData()

			for (const i in obj) {

				formData.append(i, obj[i])
			}

			return formData
		},
	}
	// ajax request END

</script>
