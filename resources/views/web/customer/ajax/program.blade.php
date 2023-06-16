<option value="">-- {{ setting_trans('programs') }} --</option>
@foreach($programs as $option)
    <option value="{{ $option->id }}" >
        {{ $option->name }}
    </option>
@endforeach
