<div class="footer-col-1 col-md-3 col-sm-12">
    <a href="{{ route('public.index') }}" aria-label="{{ theme_option('site_title') }}">
        <img style="max-height:30px; max-width:75%"
            alt="{{ setting('site_title') }}"
            src="{{ RvMedia::getImageUrl($config['logo'] ?: theme_option('theme-jobbox-logo')) }}"
        >
    </a>
    <div class="mt-20 mb-20 font-xs color-text-paragraph-2" style="text-align: justify;">
        {!! BaseHelper::clean($config['introduction']) !!}
    </div>
    <div class="footer-social">
        @foreach($config['socials'] as $social)
            @if($url = $config[$social . '_url'])
                <a class="icon-socials icon-{{ $social }}" href="{{ $url }}" aria-label="{{ $social }}"></a>
            @endif
        @endforeach
    </div>
</div>
