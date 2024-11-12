@if (setting('payment_paypal_status') == 1)
<div >
    <li class="list-group-item  mt-1 d-flex justify-content-between  align-items-center">
      <div>
      <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_paypal"
               @if ($selecting == PAYPAL_PAYMENT_METHOD_NAME) checked @endif
               value="paypal" data-bs-toggle="collapse" data-bs-target=".payment_paypal_wrap" data-toggle="collapse" data-target=".payment_paypal_wrap" data-parent=".list_payment_method">
       
       <label for="payment_paypal" class="text-start">{{ setting('payment_paypal_name', trans('plugins/payment::payment.payment_via_paypal')) }}</label>
      </div>
       <svg width="100" height="28" viewBox="0 0 142 58" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <rect x="0.5" y="0.5" width="141" height="57" rx="7.5" fill="url(#pattern0_57_1638)" stroke="#DFDFDF"/>
        <defs>
        <pattern id="pattern0_57_1638" patternContentUnits="objectBoundingBox" width="1" height="1">
        <use xlink:href="#image0_57_1638" transform="matrix(0.00507432 0 0 0.00858741 -0.157124 -0.332978)"/>
        </pattern>
        <image id="image0_57_1638" width="259" height="194" xlink:href="data:image/png;base64,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"/>
        </defs>
        </svg>
</div>
        <div class="payment_paypal_wrap payment_collapse_wrap collapse @if ($selecting == PAYPAL_PAYMENT_METHOD_NAME) show @endif" style="padding: 15px 0;">
            <p>{!! BaseHelper::clean(setting('payment_paypal_description')) !!}</p>

            @php $supportedCurrencies = (new \Botble\Paypal\Services\Gateways\PayPalPaymentService)->supportedCurrencyCodes(); @endphp
            @if (function_exists('get_application_currency') && !in_array(get_application_currency()->title, $supportedCurrencies) && !get_application_currency()->replicate()->where('title', 'USD')->exists())
                <div class="alert alert-warning" style="margin-top: 15px;">
                    {{ __(":name doesn't support :currency. List of currencies supported by :name: :currencies.", ['name' => 'PayPal', 'currency' => get_application_currency()->title, 'currencies' => implode(', ', $supportedCurrencies)]) }}

                    <div style="margin-top: 10px;">
                        {{ __('Learn more') }}: <a href="https://developer.paypal.com/docs/api/reference/currency-codes" target="_blank" rel="nofollow">https://developer.paypal.com/docs/api/reference/currency-codes</a>
                    </div>

                    @php
                        $currencies = get_all_currencies();

                        $currencies = $currencies->filter(function ($item) use ($supportedCurrencies) { return in_array($item->title, $supportedCurrencies); });
                    @endphp
                    @if (count($currencies))
                        <div style="margin-top: 10px;">{{ __('Please switch currency to any supported currency') }}:&nbsp;&nbsp;
                            @foreach ($currencies as $currency)
                                <a href="{{ route('public.change-currency', $currency->title) }}" @if (get_application_currency_id() == $currency->id) class="active" @endif><span>{{ $currency->title }}</span></a>
                                @if (!$loop->last)
                                    &nbsp; | &nbsp;
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </li>
@endif
