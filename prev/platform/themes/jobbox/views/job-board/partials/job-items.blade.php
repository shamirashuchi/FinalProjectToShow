@php
    $layout = BaseHelper::stringify(request()->query('layout'));
    if (! in_array($layout, ['list', 'grid', 'map'])) {
        $layout = 'list';
    }
    $isMapActive = (theme_option('show_map_on_jobs_page', 'yes') === 'yes' && $layout === 'map') && $jobs->isNotEmpty();
    $template = $isMapActive ? 'map' : $layout;
@endphp

<div class="content-page job-content-section">
    <div class="box-filters-job">
        <div class="row">
            <div class="col-xl-6 col-lg-5 jobs-listing-container">
                <span class="text-small text-showing showing-of-results">
                    @if ($jobs->total() > 0)
                        {{ __('Showing :from-:to of :total job(s)', [
                            'from' => $jobs->firstItem(),
                            'to' => $jobs->lastItem(),
                            'total' => $jobs->total(),
                        ]) }}
                    @endif
                </span>
            </div>
            <div class="col-xl-6 col-lg-7 text-lg-end mt-sm-15">
                <div class="display-flex2">
                    <div class="box-border mr-10">
                        <span class="text-sort_by">{{ __('Show') }}:</span>
                        <div class="dropdown dropdown-sort">
                            <button class="btn dropdown-toggle" id="dropdownSort" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                <span>{{ $jobs->perPage() }}</span>
                                <i class="fi-rr-angle-small-down"></i>
                            </button>
                            <ul class="dropdown-menu js-dropdown-clickable dropdown-menu-light" aria-labelledby="dropdownSort">
                                <li>
                                    <a class="dropdown-item per-page-item" href="#" data-per-page="10">10</a>
                                    <a class="dropdown-item per-page-item" href="#" data-per-page="20">20</a>
                                    <a class="dropdown-item per-page-item" href="#" data-per-page="40">40</a>
                                    <a class="dropdown-item per-page-item" href="#" data-per-page="60">60</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="box-border"><span class="text-sort_by">{{ __('Sort by') }}:</span>
                        @php($orderByParams = JobBoardHelper::getSortByParams())
                        <div class="dropdown dropdown-sort">
                            <button class="btn dropdown-toggle" id="dropdownSort2" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                <span>{{ __(ucfirst(BaseHelper::stringify(request()->query('sort_by', $orderByParams[0])))) }}</span>
                                <i class="fi-rr-angle-small-down"></i>
                            </button>
                            <ul class="dropdown-menu js-dropdown-clickable dropdown-menu-light" aria-labelledby="dropdownSort2">
                                @foreach ($orderByParams as $orderByParam)
                                    <li>
                                        <a
                                            @class(['dropdown-item dropdown-sort-by', 'active' => BaseHelper::stringify(request()->query('sort_by', $orderByParams[0])) === $orderByParam])
                                            data-sort-by="{{ $orderByParam }}"
                                            href="#"
                                        >
                                            {{ __(ucfirst($orderByParam)) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="box-view-type">
                        <a class="view-type layout-job" href="#" data-layout="list">
                            <img src="{{ Theme::asset()->url('imgs/template/icons/icon-list' . ($layout === 'list' ? '-hover' : null) . '.svg') }}" alt="{{ __('List layout') }}">
                        </a>
                        <a class="view-type layout-job" href="#" data-layout="grid">
                            <img src="{{ Theme::asset()->url('imgs/template/icons/icon-grid' . ($layout === 'grid' ? '-hover' : null) . '.svg') }}" alt="{{ __('Grid layout') }}">
                        </a>
                        @if (theme_option('show_map_on_jobs_page', 'yes') === 'yes' && $jobs->isNotEmpty())
                            <a @class(['view-type layout-job map', 'active' => $layout === 'map']) href="#" data-layout="map">
                                <img src="{{ Theme::asset()->url('imgs/template/map/map' . ($layout === 'map' ? '-active' : null) . '.png') }}" alt="{{ __('Map layout') }}">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row showing-of-results">
        {!! Theme::partial('loading') !!}

        @forelse($jobs as $job)
            @include(Theme::getThemeNamespace('views.job-board.partials.job-item-' . $template), ['job' => $job])
        @empty
            @include(Theme::getThemeNamespace('views.job-board.partials.job-item-empty'))
        @endforelse

        @if($isMapActive)
            <div class="col-12">
                <div class="col-lg-12 jobs-list-sidebar job-map-section d-lg-block">
                    <div class="right-map h-100">
                        <div class="position-sticky sticky-top">
                            <div class="w-100 bg-light" style="height: 100vh; width:100%">
                                <div class="jobs-list-map h-100" data-center="{{ get_lat_long_theme_option() }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{!! $jobs->withQueryString()->links(Theme::getThemeNamespace('partials.pagination')) !!}
