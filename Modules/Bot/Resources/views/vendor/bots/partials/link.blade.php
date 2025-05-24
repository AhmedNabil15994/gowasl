<div class="reply_msg {{$model && $model->reply_type == 'link' ? '' : 'hidden'}}" id="item-link-inputs">
    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.url')}} </label>
        <div class="col-xs-9">
            <input type="text" name="reply[url]" class="form-control" value="{{isset($model) && $model?->reply ? $model?->reply?->url : ''}}" placeholder="{{__('message::dashboard.messages.url')}}">
        </div>
    </div>
    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.url_title')}} </label>
        <div class="col-xs-9">
            <input type="text" name="reply[title]" class="form-control" value="{{isset($model) && $model?->reply ? $model?->reply?->title : ''}}" placeholder="{{__('message::dashboard.messages.url_title')}}">
        </div>
    </div>

    <div class="form-group row mb-2">
        <label class="col-xs-2">{{__('message::dashboard.messages.url_description')}} </label>
        <div class="col-xs-9">
            <textarea name="reply[description]" cols="30" rows="10" class="form-control" placeholder="{{__('message::dashboard.messages.url_description')}}">{{isset($model) && $model?->reply ? $model?->reply?->description : ''}}</textarea>
        </div>
    </div>
</div>
