
{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
        id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('addon::dashboard.addons.form.title').'-'.$code ,
        $model->getTranslation('title',$code),
        ['data-name' => 'title.'.$code]
        ) !!}
        <div class="form-group">
            <label for="" class="col-md-2">{{__('addon::dashboard.addons.form.description').'-'.$code}}</label>
            <div class="col-md-9">
                <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control" data-name="description.{{$code}}">{{ $model->description }}</textarea>
                <div class="help-block"></div>
            </div>
        </div>

    </div>
    @endforeach
</div>



{!! field()->number('order', __('addon::dashboard.addons.form.order')) !!}
{!! field()->number('monthly_price', __('addon::dashboard.addons.form.monthly_price')) !!}
{!! field()->number('annual_price', __('addon::dashboard.addons.form.annual_price')) !!}
{!! field()->file('image', __('addon::dashboard.addons.form.image'), $model->getFirstMediaUrl('images')) !!}
{!! field()->checkBox('status', __('addon::dashboard.addons.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('addon::dashboard.addons.form.restore')) !!}
@endif



@push('scripts')
<script>
    $('input[name=type]').change(function () {
            $('.hide-inputs').hide();
            $('#' + this.value + '-input').show();
        });
        $('#add_dates').change(function () {
            if (this.checked) {
                $('#dates_container').show();
            }else{

                $('#dates_container').hide();
            }
        });
</script>
@endpush
