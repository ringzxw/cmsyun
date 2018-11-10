<div class="btn-group" data-toggle="buttons" style="margin-left: 15px;">
    @foreach($options as $option => $label)
        <label class="btn btn-default btn-sm {{ \App\Utils\FormatUtil::getCustomerStatusCss($option) }}" style="width: 58px;">
            <input type="radio" class="customer-status" name="status-list" value="{{ $option }}">{{$label}}
        </label>
    @endforeach
</div>
