@inject('channels','Modules\Channel\Entities\Channel')

{!! field()->select('channel_id', __('contact::dashboard.contacts.form.channel') , $channels->pluck('name','id')->toArray()) !!}
<div class="form-group row mb-2 ">
    <label class="col-md-2">{{__('message::dashboard.messages.group_numbers')}} </label>
    <div class="col-md-9">
        <select name="numbers_groups[]" class="form-control select2" multiple>
            <option value=""></option>
        </select>
    </div>
</div>

{!! field()->text('name', __('contact::dashboard.contacts.form.name')) !!}
{!! field()->text('whatsapp', __('contact::dashboard.contacts.form.whatsapp')) !!}
{!! field()->text('mobile', __('contact::dashboard.contacts.form.mobile')) !!}
{!! field()->email('email', __('contact::dashboard.contacts.form.email')) !!}
{!! field()->checkBox('status', __('contact::dashboard.contacts.form.status')) !!}


@if ($model->trashed())
    {!! field()->checkBox('trash_restore', __('contact::dashboard.contacts.form.restore')) !!}
@endif

@section('additional_scripts')
    <script>
        function buildSelect(element,data){
            element.empty().select2('destroy');
            let x = '<option value=""></option>';
            $.each(data ,function (index,item) {
                x+= '<option value="'+(item.title ? item.id : item.whatsapp)+'">'+(item.title ?? item.name)+'</option>';
            })

            element.append(x).select2({
                placeholder: "Select"
            });
        }
        $('select[name="channel_id"]').on('change',function (){
            $.ajax({
                url: '{{route('dashboard.messages.getChannelData',":id")}}'.replace(':id',$(this).val()),
                type: 'GET',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data){
                    if(data.success){
                        buildSelect($('select[name="numbers_groups[]"]'),data.data.numbers_groups)
                        @if($model->id)
                        $('select[name="numbers_groups[]"]').val(@json($model->numbers_groups->pluck('id')->toArray())).trigger('change')
                        @endif
                    }
                },
                error: function (error){
                    toastr['error'](error.responseJSON.message)
                }
            })
        })

        @if($model->id)
        $('select[name="channel_id"]').val("{{$model->channel_id}}").trigger('change')
        @endif
    </script>
@endsection
