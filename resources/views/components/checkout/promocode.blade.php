<form action="{{ route('api-set-promocode', [], false) }}" class="checkout-promocode" onsubmit="setPromocode(this); return false;">
    <div class="">
        <label for="promocode">Promocode:</label>
        <input type="text" class="form-control required" name="promocode" id="promocode">
    </div>
    <div class="nk-gap"></div>
    <button type="submit" class="nk-btn nk-btn-rounded nk-btn-color-main-1">Активувати</button>
    <div class="checkout-promocode-answer success">Промокод успішно активований</div>
    <div class="checkout-promocode-answer error">Відбулася помилка</div>
</form>

<style>

    .checkout-promocode-answer {
        display: none;
        justify-content: center;
        margin-top: 5px;
    }

    .checkout-promocode-answer.success {
        color: #1bda09;
    }

    .checkout-promocode-answer.error {
        color: #f50b0b;
    }

</style>

<script>

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

</script>
