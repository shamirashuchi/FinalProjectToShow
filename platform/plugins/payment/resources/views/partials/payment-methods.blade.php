<div class="card"  style="background-color: #F1F3F9; padding: 30px">
<ul class="list-group list_payment_method">
    {!! apply_filters(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, null, [
        'name' => $name,
        'amount' => $amount,
        'currency' => $currency,
        'selected' => PaymentMethods::getSelectedMethod(),
        'default' => PaymentMethods::getDefaultMethod(),
        'selecting' => PaymentMethods::getSelectingMethod(),
     ]) !!}

    {!! PaymentMethods::render() !!}
</ul>
    </div>

