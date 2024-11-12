<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Description') }}</label>
    <input type="text" name="description" value="{{ Arr::get($attributes, 'description') }}" class="form-control" placeholder="{{ __('Description') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('City') }}</label>
    <input name="city" data-member-text=" {{ __('cities') }}" data-add-all-text="{{ __('Add all') }}" class="form-control list-tagify" data-list="{{ $cities }}" value="{{ Arr::get($attributes, 'city') }}" placeholder='{{ __('Select city from the list') }}'>
</div>

@php($random = Str::random(20))

<div class="form-group">
    <label class="control-label" for="style_{{ $random }}">{{ __('Style') }}</label>
    {!! Form::customSelect('style', [
            'style-1' => __('Style 1'),
            'style-2' => __('Style 2'),
            'style-3' => __('Style 3'),
        ], Arr::get($attributes, 'style'), ['id' => 'style_' . $random]) !!}
</div>

<style>
    .tagify__dropdown.users-list {
        z-index: 9999999;
    }
</style>
