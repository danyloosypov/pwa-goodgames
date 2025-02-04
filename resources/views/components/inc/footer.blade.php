<!-- START: Footer -->
<footer class="nk-footer">
	<div class="" id="add-to-cart" data-route="{{route('api-add-to-cart')}}"></div>
    <div class="container">
        <div class="nk-gap-3"></div>
        <div class="row vertical-gap">
            <div class="col-md-6">
                <div class="nk-widget">
                    <h4 class="nk-widget-title">
                        <span class="text-main-1">Contact</span> With Us
                    </h4>
                    @livewire('contact-form')
                </div>
            </div>
            <div class="col-md-6">
                <div class="nk-widget">
                    <h4 class="nk-widget-title">
                        <span class="text-main-1">Latest</span> Posts
                    </h4>
                    <div class="nk-widget-content">
                        <div class="row vertical-gap sm-gap">
                            @foreach ($articles as $article)
                                <div class="col-lg-6">
                                    <div class="nk-widget-post-2">
                                        <a href="{{ route('article', ['article' => $article->slug]) }}" class="nk-post-image">
                                            <img src="{{$article->image}}" alt="">
                                        </a>
                                        <div class="nk-post-title">
                                            <a href="{{ route('article', ['article' => $article->slug]) }}">{{$article->title}}</a>
                                        </div>
                                        <div class="nk-post-date">
                                            <span class="fa fa-calendar"></span> {{ \Carbon\Carbon::parse($article->date)->locale(app()->getLocale())->translatedFormat('M d, Y') }} <span class="fa fa-comments"></span>
                                            <a href="{{ route('article', ['article' => $article->slug]) }}">{{$article->reviews_count}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nk-gap-3"></div>
    </div>
    <div class="nk-copyright">
        <div class="container">
            <div class="nk-copyright-left">
                <a target="_blank" href="">Danylo Osypov</a>
            </div>
            <div class="nk-copyright-right">
                <ul class="nk-social-links-2">
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
        </div>
    </div>
</footer>
<!-- END: Footer -->
</div>
<!-- START: Page Background -->
<img class="nk-page-background-top" src="/images/bg-top.png" alt="">
<img class="nk-page-background-bottom" src="/images/bg-bottom.png" alt="">
<!-- END: Page Background -->

<livewire:search-component />	
<livewire:forgot-password />
<livewire:register />	
<livewire:login />		
<livewire:loading />

<!-- START: Scripts -->

<!-- Object Fit Polyfill -->
<script src="assets/object-fit-images/dist/ofi.min.js"></script>

<!-- GSAP -->
<script src="assets/gsap/src/minified/TweenMax.min.js"></script>
<script src="assets/gsap/src/minified/plugins/ScrollToPlugin.min.js"></script>

<!-- Popper -->
<script src="assets/popper.js/dist/umd/popper.min.js"></script>

<!-- Bootstrap -->
<script src="assets/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Sticky Kit -->
<script src="assets/sticky-kit/dist/sticky-kit.min.js"></script>

<!-- Jarallax -->
<script src="assets/jarallax/dist/jarallax.min.js"></script>
<script src="assets/jarallax/dist/jarallax-video.min.js"></script>

<!-- imagesLoaded -->
<script src="assets/imagesloaded/imagesloaded.pkgd.min.js"></script>

<!-- Flickity -->
<script src="assets/flickity/dist/flickity.pkgd.min.js"></script>

<!-- Photoswipe -->
<script src="assets/photoswipe/dist/photoswipe.min.js"></script>
<script src="assets/photoswipe/dist/photoswipe-ui-default.min.js"></script>

<!-- Jquery Validation -->
<script src="assets/jquery-validation/dist/jquery.validate.min.js"></script>

<!-- Jquery Countdown + Moment -->
<script src="assets/jquery-countdown/dist/jquery.countdown.min.js"></script>
<script src="assets/moment/min/moment.min.js"></script>
<script src="assets/moment-timezone/builds/moment-timezone-with-data.min.js"></script>

<!-- Hammer.js -->
<script src="assets/hammerjs/hammer.min.js"></script>

<!-- NanoSroller -->
<script src="assets/nanoscroller/bin/javascripts/jquery.nanoscroller.js"></script>

<!-- SoundManager2 -->
<script src="assets/soundmanager2/script/soundmanager2-nodebug-jsmin.js"></script>

<!-- Seiyria Bootstrap Slider -->
<script src="assets/bootstrap-slider/dist/bootstrap-slider.min.js"></script>

<!-- Summernote -->
<script src="assets/summernote/dist/summernote-bs4.min.js"></script>

<!-- nK Share -->
<script src="plugins/nk-share/nk-share.js"></script>

<!-- GoodGames -->
<script src="goodjs/goodgames.js"></script>
<script src="goodjs/goodgames-init.js"></script>
<script src="goodjs/demo.js"></script>
<!-- END: Scripts -->

<script>
	// lazy load START
	/**
	 * Usage: <img srcset="/images/lazy.svg" src="/images/original.png" alt="">
	 */
	function checkLazy() {
		for (var i = lazy_imgs.length - 1; i >= 0; i--) {
			var img = lazy_imgs[i]
			if (img.srcset == '/images/lazy.svg' && img.getBoundingClientRect().top - 100 < window.innerHeight) {
				(function(img) {
					img.onload = () => {
						img.removeAttribute('srcset')
					}
				})(img)
				img.srcset = img.src
			}
		}
	}
	var lazy_imgs = []
	window.addEventListener('DOMContentLoaded', () => {
		lazy_imgs = Array.prototype.slice.call(document.querySelectorAll('img[srcset]'))
		setTimeout(() => {
			checkLazy()
		}, 200)
	})
	window.addEventListener('scroll', () => {
		checkLazy()
	})
	// lazy load END


	function scrollIt(destination, duration = 500, easing = 'easeInOutCubic', callback) {

		const easings = {
			easeInOutCubic(t) {
				return t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
			},
		};

		const start = window.scrollY;
		const startTime = 'now' in window.performance ? performance.now() : new Date().getTime();

		const documentHeight = Math.max(document.body.scrollHeight, document.body.offsetHeight, document.documentElement.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight);
		const windowHeight = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
		const destinationOffset = typeof destination === 'number' ? destination : destination.offsetTop;
		const destinationOffsetToScroll = Math.round(documentHeight - destinationOffset < windowHeight ? documentHeight - windowHeight : destinationOffset);

		if ('requestAnimationFrame' in window === false) {
			window.scroll(0, destinationOffsetToScroll);
			if (callback) {
				callback();
			}
			return;
		}

		function scroll() {
			const now = 'now' in window.performance ? performance.now() : new Date().getTime();
			const time = Math.min(1, ((now - startTime) / duration));
			const timeFunction = easings[easing](time);
			window.scroll(0, Math.ceil((timeFunction * (destinationOffsetToScroll - start)) + start));

			if (Math.abs(window.scrollY - destinationOffsetToScroll) < 2) {
				if (callback) {
					callback();
				}
				return;
			}

			requestAnimationFrame(scroll);
		}

		scroll();
	}


	// ajax request START
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
					serialize(v, k) :
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

	const Cart = new function() {

		this.add = async(id_products, count, meta = '') => {

			const is_checkout = window.location.href.indexOf("checkout") !== -1 ? 1 : 0

			const route = document.querySelector('#add-to-cart').getAttribute('data-route')

			const response = await req.post(route, {
				id_products: id_products,
				count: count,
				is_checkout: is_checkout,
				meta: meta,
			}, true)

			if (!response.success) {
				alert('Ошибка')
				return
			}

			document.querySelector('#mini-cart').innerHTML = response.data.minicart
			document.querySelector('.header-btn-count').innerText = response.data.count
			//document.querySelector('#checkout-info').innerHTML = response.data.cart_info

			if (response.data.count > 0){
			// 	$('#checkout-submit').css('display', 'flex')
				document.querySelector('#cart-submit').classList.remove('btn-none')
			} else {
			// 	$('#checkout-submit').css('display', 'none')
				document.querySelector('#cart-submit').classList.add('btn-none')
			}

			if (is_checkout) {
				document.querySelector('#checkout-products').innerHTML = response.data.checkout_products
				document.querySelector('#checkout-info').innerHTML = response.data.checkout_info
				//document.querySelector('#checkout-promocode').innerHTML = response.data.promocode
				
				const event = new CustomEvent('change_isFreeDelivery', { 
					detail: {
						isFreeDelivery: response.data.is_free_delivery,
					}, 
				});

				document.dispatchEvent(event)

				const eventPayments = new CustomEvent('change_payments', { 
					detail: {
						payments: response.data.payments,
					}, 
				});

				document.dispatchEvent(eventPayments)
			}
		}
	}
		

	function resize() {
        document.body.style.setProperty('--width', document.body.clientWidth)
    }
    resize()
    window.addEventListener('resize', resize)

	function appHeight() {
		const doc = document.documentElement
		doc.style.setProperty('--app-height', `${window.innerHeight}px`)
	}
	appHeight()
	window.addEventListener('resize', appHeight)

	async function logout(route) {
        const response = await req.post(route, {})

		if (response.success) {
			location.href = response.data.link
		}
    }

</script>
