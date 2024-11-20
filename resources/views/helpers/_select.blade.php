<select name="{{ $name }}"
	{{ isset($disabled) && $disabled == true ? ' disabled="disabled"' : "" }}
	@if(isset($placeholder))
		data-placeholder="{{ $placeholder }}"
	@endif
		class="select select-search{{ $classes }} {{ isset($class) ? $class : "" }}
			{{ isset($required) && !empty($required) ? 'required' : '' }}"
			{{ isset($multiple) && $multiple == true ? "multiple='multiple'" : "" }}
			{{ isset($readonly) && $readonly == true ? "readonly='readonly'" : "" }}
		>
	@if (isset($include_blank) && $include_blank !== false)
		<option value="">{{ $include_blank }}</option>
	@endif
	@foreach($options as $option)
		<option
			@if (is_array($value))
				{{ (is_array($option) && isset($option['value']) && in_array($option['value'], $value)) ? " selected" : "" }}
			@else
				{{ (is_array($option) && isset($option['value']) && in_array($option['value'], explode(",", $value))) ? " selected" : "" }}
			@endif
			value="{{ is_array($option) && isset($option['value']) ? $option['value'] : '' }}"
		>{{ is_array($option) && isset($option['text']) ? htmlspecialchars($option['text']) : '' }}</option>
	@endforeach
</select>
