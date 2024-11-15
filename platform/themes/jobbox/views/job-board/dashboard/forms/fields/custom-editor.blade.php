@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
            @endif
            @endif

            @if ($showLabel && $options['label'] && $options['label_show'])
                {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
            @endif

            @if ($showField)
                {!! Form::customEditor($name, $options['value'], $options['attr']) !!}
                @include('core/base::forms.partials.help-block')
            @endif

            @include('core/base::forms.partials.errors')

            @if ($showLabel && $showField)
                @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif
