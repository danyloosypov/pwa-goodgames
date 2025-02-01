 

    async function setPromocode(form) {

        event.preventDefault()

        const route = form.getAttribute('action')

        const response = await req.post(route, {
            promocode: form.elements['promocode'].value,
        }, true)

        if (response.success) {
            form.reset();
            form.querySelector('.checkout-promocode-answer.success').style.display = 'flex';
            form.querySelector('.checkout-promocode-answer.error').style.display = 'none';
			
            document.querySelector('#checkout-info').innerHTML = response.data.checkout_info
        } else {
            form.querySelector('.checkout-promocode-answer.success').style.display = 'none';
            form.querySelector('.checkout-promocode-answer.error').style.display = 'flex';
        }
    }


;
 


;
