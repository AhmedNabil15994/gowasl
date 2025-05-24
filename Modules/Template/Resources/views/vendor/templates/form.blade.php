@inject('channels','Modules\Channel\Entities\Channel')

{!! field()->langNavTabs() !!}

<div class="tab-content reply_msg">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
             id="first_{{$code}}">
            {!! field()->text('title['.$code.']',
            __('template::dashboard.templates.form.title').'-'.$code ,
            $model?->getTranslation('title',$code),
            ['data-name' => 'title.'.$code]
            ) !!}
            <div class="form-group">
                <label for="" class="col-md-2">{{__('template::dashboard.templates.form.description').'-'.$code}}</label>
                <div class="col-md-9">
                    <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control " data-name="description.{{$code}}">{{ $model?->getTranslation('description',$code) }}</textarea>
                    <div class="help-block"></div>
                </div>
            </div>

        </div>
    @endforeach
</div>

@include('bot::vendor.bots.partials.variables')

{!! field()->select('channel_id', __('template::dashboard.templates.form.channel') , $channels->where('id_users',auth()->user()->id)->pluck('name','id')->toArray()) !!}

{!! field()->number('order', __('template::dashboard.templates.form.order')) !!}
{!! field()->checkBox('status', __('template::dashboard.templates.form.status')) !!}

@if ($model?->trashed())
    {!! field()->checkBox('trash_restore', __('template::dashboard.templates.form.restore')) !!}
@endif

