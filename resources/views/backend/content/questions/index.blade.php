@php
    /**
     * @var
    */
@endphp
@extends('backend.layouts.app')

@section('title', 'All Questions')

@section('vendor-style')
    @include('includes.datatable_styles')
    @vite([])
@endsection

@section('content-header-breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{ __('Home') }}</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{route('admin.tests.questions.index')}}">{{ __('All Questions') }}</a>
    </li>
@endsection

@section('content-header')
    <div class="col-md-5 content-header-right text-md-end col-md-auto d-md-block d-none mb-2">
        <div class="mb-1 breadcrumb-right">
            <a class="btn btn-success waves-effect waves-float waves-light me-2" href="{{route('admin.tests.questions.create')}}"><i class="ti ti-package ti-xs me-1"></i> {{ __("Create Question") }}
            </a>
            <button class="btn btn-info btn-round waves-effect waves-float waves-light" onclick="jQuery('#filters').toggle()">
                <i class="ti ti-filter"></i> {{__("Filters")}}
            </button>
            <a href="javascript:void(0)" class="btn btn-secondary waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#importModal"><i class="ti ti-package-import ti-xs me-1"></i> {{ __("Import Questions") }}
            </a>

        </div>
    </div>
@endsection

@section('content')
    <!-- Search Bar -->
    <div class="col-12 mb-4">
        <div id="filters" class="col-12 card card-accent-info mt-card-accent">
            <div class="card-body p-0">
                <div class="row justify-content-end card-header">
                    <div class="col-md-2 col-12">
                        <input type="text" class="form-control" placeholder="Name" id="filter_name"/>
                    </div>
                    <div class="col-md-2-5 col-12">
                        <select name="filter_test" id="filter_test" class="form-control select2 filter_test" data-placeholder="Test">
                        </select>
                    </div>
                    <div class="col-md-2-5 col-12">
                        <select name="filter_category" id="filter_category" class="form-control select2 filter_category" data-placeholder="Category">
                        </select>
                    </div>
                    <div class="col-md-2 col-12">
                        <div class="form-group row p-0 m-0">
                            <div class="col-md-12">
                                <div class="ButtonToolbar" style="position:relative; top:10%;" role="toolbar" aria-label="Toolbar with button groups">
                                    <button style="width: 90%;" id="questions_search" name="search" class="btn btn-success mr-1 mb-1 waves-effect waves-light" data-toggle="tooltip">
                                        <i class="fa fa-search me-2"></i>
                                        {{__('Search')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Search Bar -->


    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic questions-datatable table">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>id</th>
                            <th>{{__('Test')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Category')}}</th>
                            <th>{{__('Subscale')}}</th>
                            <th>{{__('Instruction')}}</th>
                            <th>{{__('References')}}</th>
                            <th>{{__('Responses')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('modals')
    @parent
    <!-- Enable OTP Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                        <h4 class="mb-2">Upload the Excel with the questions</h4>
                        <p>Verify that your excel is in the correct format</p>
                    </div>
                    <form action="{{ route('admin.tests.import.questions') }}" method="post" class="row g-5" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <div class="mb-4">
                                <label class="form-label" for="formFile">Excel File</label>
                                <input class="form-control" name="file" type="file" id="formFile">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-3">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Enable OTP Modal -->

@endsection

@section('vendor-script')
    @include('includes.datatable_scripts')
@endsection

@section('page-script')
    @include('includes.datatable_scripts')
    @vite(['resources/assets/js/ui-popover.js'])

    <script type="module">
        $(document).ready(function () {


            var dt_basic_table = $('.questions-datatable');
            if (dt_basic_table.length) {
                search();

                function search() {
                    if ($.fn.DataTable.isDataTable('.questions-datatable')) {
                        dt_basic_table.DataTable().destroy();
                    }

                    let dt_basic = dt_basic_table.DataTable({
                        processing: true,
                        serverSide: true,
                        serverMethod: 'post',
                        ajax: {
                            url: "{{ route('admin.tests.datatable.questions') }}",
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            data: function (data) {
                                data.filterName = $('#filter_name').val();
                                data.filterTest = $('#filter_test').val();
                                data.filterCategory = $('#filter_category').val();
                            }
                        },
                        columns: [
                            {data: 'id'},
                            {data: 'id'},
                            {data: 'id'}, // used for sorting so will hide this column
                            {data: 'test.name', name: 'test.name'},
                            {data: 'languages', name: 'languages.name'},
                            {data: 'test.category.name', name: 'test.category.name'},
                            {data: 'subscale.name', name: 'subscale.name'},
                            {data: 'instruction.content', name: 'instruction.content'},
                            {data: 'references', name: 'references.title'},
                            {data: 'responses', name: 'responses.title'}
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
                                render: function (data) {
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
                                init: function (api, node) {
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
                                    var data = $.map(columns, function (col) {
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
                                previous: 'Previous',
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

                $('div.head-label').html('<h6 class="mb-0">{{ __('Questions') }}</h6>');


                $('#questions_search').on("click", function () {
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
                    processResults: function (data) {
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
                    processResults: function (data) {
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
