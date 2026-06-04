@aware(['model'])
@props([
    'id',
    'name',
    'label' => '',
    'value' => null,
    'required' => false,
])

<input name="{{ $name }}" id="{{ $id }}" type="checkbox" value="{{$value ?? ($model ? data_get($model, $name) : '')}}" {{ $attributes }} class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft" {{$value ? 'checked' : ''}}>
@if($label != '')<label for="{{ $id }}" class="select-none ms-2 text-sm font-medium text-heading">{!! $label !!}</label>@endif