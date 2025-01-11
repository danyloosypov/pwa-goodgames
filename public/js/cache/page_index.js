 


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

		this.add = async(id_products, meta = '') => {

			const is_checkout = window.location.href.indexOf("checkout") !== -1 ? 1 : 0

			const route = document.querySelector('#add-to-cart').getAttribute('data-route')

			const response = await req.post(route, {
				id_products: id_products,
				is_checkout: is_checkout,
				meta: meta,
			}, true)

			if (!response.success) {
				alert('Ошибка')
				return
			}

			document.querySelector('#mini-cart').innerHTML = response.data.minicart
			document.querySelector('.header-btn.cart .header-btn-count').innerText = response.data.count
			document.querySelector('#modal-cart-info').innerHTML = response.data.cart_info

			if (response.data.count > 0){
			// 	$('#checkout-submit').css('display', 'flex')
				document.querySelector('#cart-submit').classList.remove('btn-none')
			} else {
			// 	$('#checkout-submit').css('display', 'none')
				document.querySelector('#cart-submit').classList.add('btn-none')
			}

			if (is_checkout) {
				document.querySelector('#checkout-cart').innerHTML = response.data.checkout_cart
				document.querySelector('#checkout-cart-info').innerHTML = response.data.cart_info
				document.querySelector('#checkout-promocode').innerHTML = response.data.promocode
				
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




;
 


;
