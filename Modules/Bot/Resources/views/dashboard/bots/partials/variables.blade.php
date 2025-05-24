<div class="form-group variables">
    <label for="" class="col-md-2">{{__('bot::dashboard.bots.form.message_variables')}}</label>
    <div class="col-md-9">
        @foreach(['CUSTOMER_NAME','CUSTOMER_PHONE','MESSAGE_TIMESTAMPS'] as $variable)
            <a href="#" class="tag btn btn-xs btn-success {{$variable == 'MESSAGE_TIMESTAMPS' ? 'hidden' : ''}}" data-time="{{$variable == 'MESSAGE_TIMESTAMPS' ? 1 : 0}}" data-area="{{'{'.$variable.'}'}}">{{$variable}}</a>
        @endforeach
        <div class="help-block"></div>
    </div>
</div>

@section('additional_scripts')
    <script>
        $('.tag').on('click',function (e){
            e.preventDefault();
            let variable = $(this).data('area');
            let textItem;
            @if(request()->segment(3) == 'templates')
                textItem = $(this).parents('.form-group').siblings('.reply_msg').children('.tab-pane.active').find('textarea');
            @else
                textItem = $(this).parents('.form-group').siblings('.reply_msg').not('.hidden').find('textarea');
                if(!textItem.length){
                    textItem = $(this).parents('.form-group').siblings('.reply_msg').not('.hidden').find('input[type="text"][name="caption"]');
                }
            @endif
            let oldValue = textItem.val();
            textItem.val(oldValue + " \r\n" + variable);
        });
    </script>
@endsection

