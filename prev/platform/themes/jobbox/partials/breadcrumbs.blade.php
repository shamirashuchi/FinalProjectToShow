<section class="section-box">
    <div
        @class(['breadcrumb-cover', 'bg-img-about' => Theme::get('pageCoverImage')])
        style="background-image: url({{ RvMedia::getImageUrl(Theme::get('pageCoverImage') ?: theme_option('background_breadcrumb'), null, false, RvMedia::getDefaultImage()) }})"
    >
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="mb-10">{{ Theme::get('pageTitle') }}</h2>
                    <p class="font-lg color-text-paragraph-2">{{ Theme::get('pageDescription') }}</p>
                </div>
                <div class="col-lg-6 text-end">
                    <ul class="breadcrumbs mt-40">
                        @foreach (Theme::breadcrumb()->getCrumbs() as $crumb)
                            @if ($loop->first)
                                <li>
                                    <a href="{{ $crumb['url'] }}">
                                        <span class="fi-rr-home icon-home"></span>
                                        {{ $crumb['label'] }}
                                    </a>
                                </li>
                            @elseif (! $loop->last)
                                <li>
                                    <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                                </li>
                            @else
                                <li>{{ $crumb['label'] }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
