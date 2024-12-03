@php
    /**
     * @var
    */
@endphp
@extends('backend.layouts.app')

@section('title', 'All Instructions')

@section('vendor-style')
    @include('includes.datatable_styles')
    @vite([])
@endsection

@section('content-header-breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{ __('Home') }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{route('admin.tests.instructions.index')}}">{{ __('All Instructions') }}</a>
    </li>
@endsection

@section('content-header')

    <div class="col-md-5 content-header-right text-md-end col-md-auto d-md-block d-none mb-2">
        <div class="mb-1 breadcrumb-right">
            <a class="btn btn-success waves-effect waves-float waves-light me-2" href="{{route('admin.tests.instructions.create')}}"><i class="ti ti-package ti-xs me-1"></i> {{ __("Create Instruction") }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic instructions-datatable table">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{__('Content')}}</th>
                            <th>{{__('Language')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('vendor-script')
    @include('includes.datatable_scripts')
@endsection

@section('page-script')
    @include('includes.datatable_scripts')
    @vite(['resources/assets/js/ui-popover.js'])

    <script type="module">
        $(document).ready(function () {


            var dt_basic_table = $('.instructions-datatable');
            if (dt_basic_table.length) {
                search();

                function search() {
                    if ($.fn.DataTable.isDataTable('.instructions-datatable')) {
                        dt_basic_table.DataTable().destroy();
                    }

                    let dt_basic = dt_basic_table.DataTable({
                        processing: true,
                        serverSide: true,
                        serverMethod: 'post',
                        ajax: {
                            url: "{{ route('admin.tests.datatable.instructions') }}",
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                        },
                        columns: [
                            {data: 'id'},
                            {data: 'id'},
                            {data: 'id'}, // used for sorting so will hide this column
                            {data: 'content', name: 'content'},
                            {data: 'language.name', name: 'language.name'},
                        ],
                        columnDefs: [
                            {
                                // For Responsive
                                className: 'control',
                                orderable: false,
                                responsivePriority: 2,
                                targets: 0
                            },
                            {
                                // For Checkboxes
                                targets: 1,
                                orderable: false,
                                responsivePriority: 3,
                                render: function (data, type, full, meta) {
                                    return (
                                        '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="checkbox' +
                                        data +
                                        '" /><label class="form-check-label" for="checkbox' +
                                        data +
                                        '"></label></div>'
                                    );
                                },
                                checkboxes: {
                                    selectAllRender:
                                        '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>'
                                }
                            },
                            {
                                targets: 2,
                                visible: true
                            },
                        ],
                        order: [[2, 'desc']],
                        dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                        displayLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        buttons: [
                                {{--{--}}
                                {{--    text: feather.icons['upload'].toSvg({ class: 'me-50 font-small-4' }) + '{{ __('Upload') }}',--}}
                                {{--    className: 'create-new mx-50 btn btn-dark',--}}
                                {{--    attr: {--}}
                                {{--        'data-bs-toggle': 'modal',--}}
                                {{--        'data-bs-target': '#upload'--}}
                                {{--    },--}}
                                {{--    init: function (api, node, config) {--}}
                                {{--        $(node).removeClass('btn-secondary');--}}
                                {{--    }--}}
                                {{--},--}}
                            {
                                extend: 'collection',
                                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                                text: '<i class="ti ti-logout rotate-n90 me-2"></i>' + '{{ __('Export')  }}',
                                {{--text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + '{{ __('Export')  }}',--}}
                                buttons: [
                                    {
                                        extend: 'print',
                                        text: '<i class="ti ti-printer me-2" ></i>Print',
                                        className: 'dropdown-item',
                                        exportOptions: {columns: [3, 4]}
                                    },
                                    {
                                        extend: 'csv',
                                        text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                        className: 'dropdown-item',
                                        exportOptions: {columns: [3, 4]}
                                    },
                                    {
                                        extend: 'excel',
                                        text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                        className: 'dropdown-item',
                                        exportOptions: {columns: [3, 4]}
                                    },
                                    {
                                        extend: 'pdf',
                                        text: '<i class="ti ti-file-text me-2"></i>Pdf',
                                        className: 'dropdown-item',
                                        exportOptions: {columns: [3, 4]}
                                    },
                                    {
                                        extend: 'copy',
                                        text: '<i class="ti ti-copy me-1" ></i>Copy',
                                        className: 'dropdown-item',
                                        exportOptions: {columns: [3, 4]}
                                    }
                                ],
                                init: function (api, node, config) {
                                    $(node).removeClass('btn-secondary');
                                    $(node).parent().removeClass('btn-group');
                                    setTimeout(function () {
                                        $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                                    }, 50);
                                }
                            },
                            {{--{--}}
                            {{--    text: feather.icons['plus'].toSvg({ class: 'me-50 font-small-4' }) + '{{ __('New Record')  }}',--}}
                            {{--    className: 'create-new btn btn-primary',--}}
                            {{--    attr: {--}}
                            {{--        'data-bs-toggle': 'modal',--}}
                            {{--        'data-bs-target': '#add-user'--}}
                            {{--    },--}}
                            {{--    init: function (api, node, config) {--}}
                            {{--        $(node).removeClass('btn-secondary');--}}
                            {{--    }--}}
                            {{--}--}}
                        ],
                        responsive: {
                            details: {
                                display: $.fn.dataTable.Responsive.display.modal({
                                    header: function (row) {
                                        var data = row.data();
                                        return 'Details of ' + data['full_name'];
                                    }
                                }),
                                type: 'column',
                                renderer: function (api, rowIdx, columns) {
                                    var data = $.map(columns, function (col, i) {
                                        return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                            ? '<tr data-dt-row="' +
                                            col.rowIdx +
                                            '" data-dt-column="' +
                                            col.columnIndex +
                                            '">' +
                                            '<td>' +
                                            col.title +
                                            ':' +
                                            '</td> ' +
                                            '<td>' +
                                            col.data +
                                            '</td>' +
                                            '</tr>'
                                            : '';
                                    }).join('');

                                    return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                                }
                            }
                        },
                        language: {
                            paginate: {
                                // remove previous & next text from pagination
                                previous: 'Back',
                                next: 'Next'
                            },
                            "lengthMenu": "{{__('Show')}} _MENU_ {{__('Entries')}}",
                            "zeroRecords": "{{__('Nothing Found')}}",
                            "info": "{{__('Showing')}} _START_ {{__('until')}} _END_ {{__('Entries')}}",
                            "infoEmpty": "{{__('Nothing Found')}}",
                            "loadingRecords": "{{ __('Loading')  }}",
                            sProcessing: '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
                            "search": "{{ __('Search') }}",
                        },
                    });

                    // Initialize popovers on DataTable draw
                    dt_basic.on('draw', function () {
                        $('[data-bs-toggle="popover"]').each(function () {
                            var popover = new bootstrap.Popover(this);
                            $(this).on('shown.bs.popover', function () {
                                setTimeout(function () {
                                    popover.hide();
                                }, 1500); // 1.5 second delay
                            });
                        });
                    });
                }

                $('div.head-label').html('<h6 class="mb-0">{{ __('Instructions') }}</h6>');


                $('#Instructions_search').on("click", function () {
                    search();
                });

            }


            $(".filter_test").select2({
                placeholder: '{{__('Search')}}...',
                allowClear: true,
                ajax: {
                    type: 'POST',
                    delay: 500,
                    url: "{{ route('admin.tests.testsPaginated') }}",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    // processResults: function (data, params) {
                    //     return data
                    // },
                    processResults: function (data, params) {
                        return {
                            results: $.map(data.results, function (obj) {
                                return {id: obj.text, text: obj.text}; // Use email as both id and text
                            })
                        };
                    },
                    cache: true
                }
            });

            $(".filter_category").select2({
                placeholder: '{{__('Search')}}...',
                allowClear: true,
                ajax: {
                    type: 'POST',
                    delay: 500,
                    url: "{{ route('admin.tests.categoriesPaginated') }}",
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        }
                    },
                    // processResults: function (data, params) {
                    //     return data
                    // },
                    processResults: function (data, params) {
                        return {
                            results: $.map(data.results, function (obj) {
                                return {id: obj.text, text: obj.text}; // Use email as both id and text
                            })
                        };
                    },
                    cache: true
                }
            });


        });
    </script>
@endsection
