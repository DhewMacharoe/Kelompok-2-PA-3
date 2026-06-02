@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'help' => null,
    'options' => [],
    'rows' => 4,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'multiple' => false,
    'accept' => null,
    'id' => null,
    'wrapperClass' => 'mb-3',
    'labelClass' => 'form-label form-field__label',
    'controlClass' => '',
    'helpClass' => '',
])

@php
    $fieldId = $id ?? $name;
    $hasError = $name ? $errors->has($name) : false;
    $helpId = $help ? $fieldId . '-help' : null;
    $errorId = $hasError ? $fieldId . '-error' : null;
    $describedBy = array_filter([$helpId, $errorId]);
    $value = $name ? old($name, $value) : $value;
    $inputClass = trim('form-control form-field__control ' . $controlClass . ($hasError ? ' is-invalid' : ''));
    $selectClass = trim('form-select form-field__control ' . $controlClass . ($hasError ? ' is-invalid' : ''));
    $textareaClass = trim('form-control form-field__control ' . $controlClass . ($hasError ? ' is-invalid' : ''));
    $sharedAttributes = $attributes->except(['class']);
@endphp

<div class="form-field {{ $wrapperClass }}">
    @if($label)
        <label for="{{ $fieldId }}" class="{{ $labelClass }}">{{ $label }}</label>
    @endif

    @if($type === 'textarea')
        <textarea
            {{ $sharedAttributes->merge(['id' => $fieldId, 'name' => $name, 'class' => $textareaClass]) }}
            rows="{{ $rows }}"
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required aria-required="true" @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled aria-disabled="true" @endif
            @if($describedBy) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
        >{{ $value }}</textarea>
    @elseif($type === 'select')
        <select
            {{ $sharedAttributes->merge(['id' => $fieldId, 'name' => $name, 'class' => $selectClass]) }}
            @if($required) required aria-required="true" @endif
            @if($disabled) disabled aria-disabled="true" @endif
            @if($multiple) multiple @endif
            @if($describedBy) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
        >
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @else
        <input
            {{ $sharedAttributes->merge(['id' => $fieldId, 'type' => $type, 'name' => $name, 'class' => $inputClass]) }}
            @if($type !== 'file') value="{{ $value }}" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($accept) accept="{{ $accept }}" @endif
            @if($required) required aria-required="true" @endif
            @if($readonly) readonly @endif
            @if($disabled) disabled aria-disabled="true" @endif
            @if($multiple) multiple @endif
            @if($describedBy) aria-describedby="{{ implode(' ', $describedBy) }}" @endif
        >
    @endif

    @if($help)
        <div id="{{ $helpId }}" class="form-field__help form-text {{ $helpClass }}">{{ $help }}</div>
    @endif

    @error($name)
        <div id="{{ $errorId }}" class="form-field__error invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
