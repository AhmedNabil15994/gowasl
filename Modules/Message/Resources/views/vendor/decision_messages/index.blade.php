@extends('apps::vendor.layouts.app')
@section('title', __('message::dashboard.decision_messages.routes.index'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('vendor.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('message::dashboard.decision_messages.routes.index')}}</a>
                </li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">

                    @can('add_decision_messages')
{{--                    <div class="table-toolbar">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="btn-group">--}}
{{--                                    <a href="{{ url(route('vendor.decision_messages.create')) }}"--}}
{{--                                        class="btn sbold green">--}}
{{--                                        <i class="fa fa-plus"></i> {{__('apps::dashboard.buttons.send_message')}}--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    @endcan

                    {{-- DATATABLE FILTER --}}
                    <div class="row">
                        <div class="portlet box grey-cascade">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-gift"></i>
                                    {{__('apps::dashboard.datatable.search')}}
                                </div>
                                <div class="tools">
                                    <a href="javascript:;"
                                        class="collapse"
                                        data-original-title=""
                                        title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="filter_data_table">
                                    <div class="panel-body">
                                        <form id="formFilter"
                                            class="horizontal-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::dashboard.datatable.form.date_range')}}
                                                            </label>
                                                            <div id="reportrange"
                                                                class="btn default form-control">
                                                                <i class="fa fa-calendar"></i> &nbsp;
                                                                <span> </span>
                                                                <b class="fa fa-angle-down"></b>
                                                                <input type="hidden"
                                                                    name="from">
                                                                <input type="hidden"
                                                                    name="to">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                {{__('apps::dashboard.datatable.form.status')}}
                                                            </label>
                                                            <div class="mt-radio-list">
                                                                <label class="mt-radio">
                                                                    {{__('apps::dashboard.datatable.form.active')}}
                                                                    <input type="radio"
                                                                        value="1"
                                                                        name="status" />
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    {{__('apps::dashboard.datatable.form.unactive')}}
                                                                    <input type="radio"
                                                                        value="0"
                                                                        name="status" />
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="form-actions">
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom"
                                                id="search">
                                                <i class="fa fa-search"></i>
                                                {{__('apps::dashboard.datatable.search')}}
                                            </button>
                                            <button class="btn btn-sm red btn-outline filter-cancel">
                                                <i class="fa fa-times"></i>
                                                {{__('apps::dashboard.datatable.reset')}}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END DATATABLE FILTER --}}


                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">
                                {{__('message::dashboard.decision_messages.routes.index')}}
                            </span>
                        </div>
                    </div>

                    {{-- DATATABLE CONTENT --}}
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover"
                            id="dataTable">
                            <thead>
                                <tr>
                                    <th>
                                        <a href="javascript:;"
                                            onclick="CheckAll()">
                                            {{__('apps::dashboard.buttons.select_all')}}
                                        </a>
                                    </th>
                                    <th>#</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.channel')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.message_data')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.whatsapp')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.send_at')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.is_replied')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.progress')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.status')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.created_at')}}</th>
                                    <th>{{__('message::dashboard.decision_messages.datatable.options')}}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <button type="submit"
                                id="deleteChecked"
                                class="btn red btn-sm"
                                onclick="deleteAllChecked('{{ url(route('vendor.decision_messages.deletes')) }}')">
                                {{__('apps::dashboard.datatable.delete_all_btn')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')

<script>
    function tableGenerate(data = '') {

            var dataTable =
                $('#dataTable').DataTable({
                    "createdRow": function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('vendor.decision_messages.datatable')) }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [[1, "desc"]],
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'channel' , className: 'dt-center'},
                        {data: 'message_data.body' , className: 'dt-center pre'},
                        {data: 'whatsapp' , className: 'dt-center pre'},
                        {data: 'send_at' , className: 'dt-center pre'},
                        {data: 'is_replied' , className: 'dt-center'},
                        {data: 'progress' , className: 'dt-center'},
                        {data: 'status' , className: 'dt-center'},
                        {data: 'created_at', className: 'dt-center'},
                        {data: 'id',responsivePriority: 1},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                  <input type="checkbox" value="` + data + `" class="group-checkable" name="ids">
                                  <span></span>
                                </label>
                              `;
                            },
                        },
                        {
                            targets: 3,
                            width: '150px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return data;
                            },
                        },
                        {
                            targets: -5,
                            width: '30px',
                            className: 'dt-center',
                            render: function (data, type, full, meta) {
                                if (data) {
                                    return '<span class="badge badge-success"> {{__('message::dashboard.messages.datatable.true')}} </span>';
                                } else {
                                    return '<span class="badge badge-danger"> {{__('message::dashboard.messages.datatable.false')}} </span>';
                                }
                            },
                        },
                        {
                            targets: -3,
                            width: '30px',
                            className: 'dt-center',
                            render: function (data, type, full, meta) {
                                if (data) {
                                    return '<span class="badge badge-success"> {{__('message::dashboard.messages.datatable.true')}} </span>';
                                } else {
                                    return '<span class="badge badge-danger"> {{__('message::dashboard.messages.datatable.false')}} </span>';
                                }
                            },
                        },
                        {
                            targets: -1,
                            responsivePriority:1,
                            width: '13%',
                            title: '{{__('message::dashboard.decision_messages.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Show
                                var showUrl = '{{ route("vendor.decision_messages.show", ":id") }}';
                                showUrl = showUrl.replace(':id', data);

                                // Delete
                                var deleteUrl = '{{ route("vendor.decision_messages.destroy", ":id") }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                   @can('show_decision_messages')
                  <a href="` + showUrl + `" class="btn btn-sm blue" title="Edit">
                    <i class="fa fa-eye"></i>
                 </a>
                 @endcan
                @can('delete_decision_messages')
                @csrf
                                    <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                    <i class="fa fa-trash"></i>
                  </a>
                @endcan`;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength", className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "print", className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "pdf", className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "excel", className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        },
                        {
                            extend: "colvis", className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5]
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function () {
            tableGenerate();
        });
</script>

@stop
