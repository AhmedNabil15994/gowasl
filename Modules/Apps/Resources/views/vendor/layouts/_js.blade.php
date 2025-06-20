@if (is_rtl() == 'rtl')
    <script src="{{asset('/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-rtl.min.js')}}" type="text/javascript"></script>
@else
    <script src="{{asset('/admin/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
@endif
{{--<script src="{{ mix('js/app.js') }}"></script>--}}
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>


<script>
		$(document).ready(function()
		{
				$('#clickmewow').click(function()
				{
						$('#radio1003').attr('checked', 'checked');
				});
		})
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".emojioneArea").emojioneArea();
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $(".emojioneArea").emojioneArea();
  });
</script>

<style>

  .emojionearea .emojionearea-picker.emojionearea-picker-position-top {
  	margin-bottom: -286px!important;
  	right: -14px;
  	z-index: 90000000000000;
  }

  .emojionearea .emojionearea-button.active+.emojionearea-picker-position-top {
      margin-top: 0px!important;
  }
</style>

<script>

  $(document).ready(function()
  {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {


        if ((isNaN(start) && isNaN(end)) || (start == null && end == null)) {

            $('#reportrange span').html('{{__('apps::vendor.buttons.datapicker.all')}}');
            $('input[name="from"]').val('');
            $('input[name="to"]').val('');

        } else if (start.isValid() && end.isValid()) {

            $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="from"]').val(start.format('YYYY-MM-DD'));
            $('input[name="to"]').val(end.format('YYYY-MM-DD'));
        }
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            '{{__('apps::vendor.buttons.datapicker.all')}}': [NaN, NaN],
           '{{__('apps::vendor.buttons.datapicker.today')}}'         : [moment(), moment()],
           '{{__('apps::vendor.buttons.datapicker.yesterday')}}'     : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '{{__('apps::vendor.buttons.datapicker.7days')}}'         : [moment().subtract(6, 'days'), moment()],
           '{{__('apps::vendor.buttons.datapicker.30days')}}'        : [moment().subtract(29, 'days'), moment()],
           '{{__('apps::vendor.buttons.datapicker.month')}}'         : [moment().startOf('month'), moment().endOf('month')],
           '{{__('apps::vendor.buttons.datapicker.last_month')}}'    : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        },
          @if (is_rtl() == 'rtl')
          opens: 'left',
          @endif
          buttonClasses	 : ['btn'],
          applyClass	   : 'btn-primary',
          cancelClass	   : 'btn-danger',
          format 		     : 'YYYY-MM-DD',
          separator		   : 'to',
          locale: {
              applyLabel		    : '{{__('apps::vendor.buttons.save')}}',
              cancelLabel		    : '{{__('apps::vendor.buttons.cancel')}}',
              fromLabel			    : '{{__('apps::vendor.buttons.from')}}',
              toLabel			      : '{{__('apps::vendor.buttons.to')}}',
              customRangeLabel	: '{{__('apps::vendor.buttons.custom')}}',
              firstDay: 1
          }
    }, cb);

    cb(NaN,NaN);

  });

</script>

<script>

  $('.delete').click(function() {
      $(this).closest('.form-group').find($('.' + $(this).data('input'))).val('');
      $(this).closest('.form-group').find($('.' + $(this).data('preview'))).html('');
  });

</script>
@stack('scripts')
