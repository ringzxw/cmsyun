<div class="btn-group" data-toggle="buttons" style="margin-left: 15px;">
    @foreach($options as $option => $label)
        <label class="btn btn-default btn-sm {{ \App\Utils\FormatUtil::getLabelCss($option) }}">
            <input type="radio" class="customer-label" name="label-list" value="{{ $option }}">{{$label}}
        </label>
    @endforeach
</div>