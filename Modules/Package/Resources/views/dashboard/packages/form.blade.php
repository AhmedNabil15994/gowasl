
{!! field()->langNavTabs() !!}

<div class="tab-content">
    @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
    <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}"
        id="first_{{$code}}">
        {!! field()->text('title['.$code.']',
        __('package::dashboard.packages.form.title').'-'.$code ,
        $model->getTranslation('title',$code),
        ['data-name' => 'title.'.$code]
        ) !!}
        <div class="form-group">
            <label for="" class="col-md-2">{{__('package::dashboard.packages.form.description').'-'.$code}}</label>
            <div class="col-md-9">
                <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control" data-name="description.{{$code}}">{{ $model->description }}</textarea>
                <div class="help-block"></div>
            </div>
        </div>

    </div>
    @endforeach
</div>



{!! field()->number('order', __('package::dashboard.packages.form.order')) !!}
{!! field()->number('monthly_price', __('package::dashboard.packages.form.monthly_price')) !!}
{!! field()->number('annual_price', __('package::dashboard.packages.form.annual_price')) !!}
{!! field()->number('daily_limit', __('package::dashboard.packages.form.daily_limit')) !!}
{!! field()->file('image', __('package::dashboard.packages.form.image'), $model->getFirstMediaUrl('images')) !!}
{!! field()->checkBox('status', __('package::dashboard.packages.form.status')) !!}

@if ($model->trashed())
{!! field()->checkBox('trash_restore', __('package::dashboard.packages.form.restore')) !!}
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
