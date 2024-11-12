@if($candidates->total())
    @foreach($candidates as $candidate)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card-grid-2 hover-up">
                <div class="card-grid-2-image-left">
                    <div @class(['card-grid-2-image-rd', 'online' => $candidate->available_for_hiring])>
                        <a href="{{ $candidate->url }}">
                            <figure>
                                <img alt="{{ $candidate->name }}" src="{{ $candidate->avatar_thumb_url }}">
                            </figure>
                        </a>
                    </div>
                    <div class="card-profile pt-10">
                        <a href="{{ $candidate->url }}">
                            <h5>{{ $candidate->name }}</h5>
                        </a>
                        <span class="font-xs color-text-mutted text-truncate">{{ $candidate->description }}</span>
                    </div>
                </div>
                <div class="card-block-info">
                    <p class="font-xs color-text-paragraph-2">{{ Str::limit(strip_tags(BaseHelper::clean($candidate->bio))) }}</p>
                    <div class="employers-info align-items-center justify-content-center mt-15">
                        <div class="row">
                            <div class="col-12">
                                <span class="d-flex align-items-center">
                                    <i class="fi-rr-marker mr-5 ml-0"></i>
                                    <span class="font-sm color-text-mutted text-truncate">
                                        {{ $candidate->state_name ? $candidate->state_name . ',' : null }} {{ $candidate->country->code }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{ $candidates->withQueryString()->links(Theme::getThemeNamespace('partials.pagination')) }}
@else
    <p class="text-center text-muted">{{ __('No candidates!') }}</p>
@endif
