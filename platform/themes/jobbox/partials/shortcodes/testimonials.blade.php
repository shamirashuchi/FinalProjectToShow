@switch($shortcode->style)
    @case('style-2')
        <section class="section-box mt-0">
            <div class="section-box wow animate__animated animate__fadeIn">
                <div class="container">
                    <div class="text-center">
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">
                            {!! BaseHelper::clean($shortcode->title) !!}
                        </h2>
                        <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">
                            {!! BaseHelper::clean($shortcode->description) !!}
                        </p>
                    </div>
                    <div class="box-swiper mt-50" id="app-testimonials">
                        <testimonial-style-two-component url="{{ route('public.ajax.testimonials') }}"></testimonial-style-two-component>
                    </div>
                </div>
            </div>
        </section>
        @break
    @default
        <section class="section mt-50">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-title text-center mb-4 pb-2">
                            <h2 class="text-center mb-15 wow animate__animated animate__fadeInUp">
                                {!! BaseHelper::clean($shortcode->title) !!}
                            </h2>
                            <div class="font-lg color-text-paragraph-2 text-center wow animate__animated animate__fadeInUp">
                                {!! BaseHelper::clean($shortcode->description) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-50 justify-content-center" id="app-testimonials">
                    <testimonials-component url="{{ route('public.ajax.testimonials') }}"></testimonials-component>
                </div>
            </div>
        </section>
    @break
@endswitch

