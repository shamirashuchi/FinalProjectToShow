<section class="section-box mt-90 mb-50">
    <div class="container ">
        <h2 class="text-center mb-15 wow animate__ animate__fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
            {!! BaseHelper::clean($shortcode->title) !!}
        </h2>
        <div class="font-lg color-text-paragraph-2 text-center wow animate__ animate__fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
            {!! BaseHelper::clean($shortcode->subtitle) !!}
        </div>
        <div class="row mt-50">
            @foreach ($faqs as $faq)
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card-grid-border hover-up wow animate__ animate__fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
                        <h4 class="mb-20">{!! BaseHelper::clean($faq->question) !!}</h4>
                        <p class="font-sm mb-20 color-text-paragraph">{!! BaseHelper::clean($faq->answer) !!}</p>
                        <a class="link-arrow" href="{{ $faq->url }}">{{ __('Keep Reading') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
