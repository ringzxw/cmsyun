<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
        <label class="btn btn-default btn-sm">
            <input type="radio" class="user-gender" name="employee-list" value="{{ $option }}">{{$label}}
        </label>
    @endforeach
</div>