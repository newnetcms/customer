<option value="">-- {{ setting_trans('intake') }} --</option>
@foreach(json_decode($intake) as $option)
    <option value="{{ $option }}" >
        {{ find_intake($option) }}
    </option>
@endforeach
