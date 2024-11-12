<div class="form-group">
    <label for="widget-logo">{{ __('Background Image') }}</label>
    {!! Form::mediaImage('logo', $config['logo']) !!}
    <small>{{ __('If you don\'t set logo image, it will show the site logo') }}</small>
</div>

<div class="form-group">
    <label for="widget_introduction">{{ __('Introduction') }}</label>
    <textarea name="introduction" id="widget_introduction" rows="3" class="form-control">{{ $config['introduction'] }}</textarea>
</div>

@foreach($config['socials'] as $social)
    <div class="form-group">
        <label for="widget_{{ $social }}_url">{{ __('URL :social', ['social' => $social]) }}</label>
        <input type="text" id="widget_{{ $social }}_url" class="form-control" name="{{ $social }}_url" value="{{ $config[$social . '_url'] }}">
    </div>
@endforeach
