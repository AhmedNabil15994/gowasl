@inject('channels','Modules\Channel\Entities\Channel')

{!! field()->select('channel_id', __('message::dashboard.messages.form.channel') , $channels->where('id_users',auth()->user()->id)->pluck('name','id')->toArray()) !!}

{!! field()->text('name', __('message::dashboard.messages.form.name')) !!}
{!! field()->text('whatsapp', __('message::dashboard.messages.form.whatsapp')) !!}
{!! field()->text('mobile', __('message::dashboard.messages.form.mobile')) !!}
{!! field()->email('email', __('message::dashboard.messages.form.email')) !!}
{!! field()->checkBox('status', __('message::dashboard.messages.form.status')) !!}

@if ($model->trashed())
    {!! field()->checkBox('trash_restore', __('message::dashboard.messages.form.restore')) !!}
@endif

