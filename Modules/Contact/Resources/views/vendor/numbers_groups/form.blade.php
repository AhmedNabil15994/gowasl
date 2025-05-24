@inject('channels','Modules\Channel\Entities\Channel')

{!! field()->langNavTabs() !!}

<div class="tab-content reply_msg">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
             id="first_{{$code}}">
            {!! field()->text('title['.$code.']',
            __('contact::dashboard.numbers_groups.form.title').'-'.$code ,
            $model->getTranslation('title',$code),
            ['data-name' => 'title.'.$code]
            ) !!}
            <div class="form-group">
                <label for="" class="col-md-2">{{__('contact::dashboard.numbers_groups.form.description').'-'.$code}}</label>
                <div class="col-md-9">
                    <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control " data-name="description.{{$code}}">{{ $model->description }}</textarea>
                    <div class="help-block"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{!! field()->select('channel_id', __('contact::dashboard.numbers_groups.form.channel') , $channels->where('id_users',auth()->user()->id)->pluck('name','id')->toArray()) !!}

{!! field()->file('excel_file',__('message::dashboard.messages.excel_file'),null,['accept'=>".xlsx,.xls,application/vnd.openxmlformatsofficedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",]) !!}
<div class="form-group" style="margin-top: -15px;">
    <label for="" class="col-md-2"></label>
    <div class="col-md-9">
        <p style="margin: 0">
            مثال لملف الاكسيل من هنا
            <a target="_blank" href="{{asset('uploads/GroupNumbers.xlsx')}}">تحميل</a>
        </p>
    </div>
</div>


{!! field()->checkBox('status', __('contact::dashboard.numbers_groups.form.status')) !!}

@if ($model->trashed())
    {!! field()->checkBox('trash_restore', __('contact::dashboard.numbers_groups.form.restore')) !!}
@endif

