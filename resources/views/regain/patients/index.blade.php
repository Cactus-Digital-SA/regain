@extends('backend.layouts.app')

@section('title', 'Prospects')

@section('content-header-breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('admin.home')}}">{{__('Home')}}</a>
    <li class="breadcrumb-item">Patients</li>
@endsection

@section('vendor-style')
    @include('includes.datatable_styles')
@endsection

@section('content-header')
    <div class="col-md-5 content-header-right text-md-end col-md-auto d-md-block d-none mb-2">
        <div class="mb-1 breadcrumb-right">
            <a class="btn btn-success waves-effect waves-float waves-light me-2"
               href="{{route('regain.patients.create')}}"><i
                    class="ti ti-user-plus ti-xs me-1"></i>
                {{ __("Create Patient") }}
            </a>
{{--            <button class="btn btn-info btn-round waves-effect waves-float waves-light"--}}
{{--                    onclick="jQuery('#filters').toggle()">--}}
{{--                <i class="ti ti-filter"></i> {{ __('Filters') }}--}}
{{--            </button>--}}
        </div>
    </div>
@endsection

@section('content')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <table class="datatables-basic patients-datatable table">
                        <thead>
                        <tr>
                            @foreach($columns as $column)
                                <th> {{ __($column['name']) }}</th>
                            @endforeach
                            <th> {{ __('Actions') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @include('backend.components.delete_modal')
@endsection


@section('vendor-script')

@endsection

@section('page-script')
    @include('includes.datatable_scripts')
    @vite([])
    <script type="module">

        $(function () {
            let dt_basic_table = $('.patients-datatable');

            if (dt_basic_table.length) {
                let filters = [];
                checkUrlParamsAndSetInputs()

                filters = getFiltersFromInputs();

                mySearch(filters);

                function mySearch(filters) {
                    if ($.fn.DataTable.isDataTable('.patients-datatable')) {
                        dt_basic_table.DataTable().destroy();
                    }

                    let currentFilters = filters;

                    let dt_basic = dt_basic_table.DataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        serverMethod: 'post',
                        ajax: {
                            url: "{{ route('regain.patients.datatable') }}",
                            headers: {
                                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                            },
                            data: function (data) {
                                if (currentFilters && typeof currentFilters === 'object') {
                                    Object.keys(currentFilters).forEach(function (key) {
                                        data[key] = currentFilters[key];
                                    });
                                }
                            }
                        },
                        columns: [
                            @foreach($columns as $key => $column)
                            {
                                data: '{{$key}}',
                                name: '{{$column['table']}}',
                                searchable: '{{ $column['searchable'] }}',
                                sortable: '{{ $column['sortable'] }}'
                            },
                            @endforeach
                            {data: 'actions', searchable: false, orderable: false},
                        ],
                        columnDefs: [
                            {
                                // For Responsive
                                className: 'control',
                                orderable: false,
                                responsivePriority: 2,
                                targets: 0
                            }
                        ],
                        order: [[1, 'desc']],
                        dom: '<"d-flex justify-content-between align-items-center mx-2 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"<"dt-action-buttons text-end"B>f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                        displayLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        buttons: [
                            {
                                extend: 'collection',
                                className: 'btn btn-outline-secondary dropdown-toggle me-2',
                                text: '<i class="ti ti-logout rotate-n90 me-2"></i>' + '{{ __('locale.Export')  }}',
                                {{--text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + '{{ __('locale.Export')  }}',--}}
                                buttons: [
                                    {
                                        extend: 'print',
                                        text: '<i class="ti ti-printer me-2" ></i>Print',
                                        className: 'dropdown-item',
                                        exportOptions: {
                                            columns: ':visible'
                                        }
                                    },
                                    {
                                        extend: 'csv',
                                        text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                        className: 'dropdown-item',
                                        exportOptions: {
                                            columns: ':visible'
                                        }
                                    },
                                    {
                                        extend: 'excel',
                                        text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                        className: 'dropdown-item',
                                        exportOptions: {
                                            columns: ':visible'
                                        }
                                    },
                                    {
                                        extend: 'pdf',
                                        text: '<i class="ti ti-file-text me-2"></i>Pdf',
                                        className: 'dropdown-item',
                                        exportOptions: {
                                            columns: ':visible'
                                        }
                                    },
                                    {
                                        extend: 'copy',
                                        text: '<i class="ti ti-copy me-1" ></i>Copy',
                                        className: 'dropdown-item',
                                        exportOptions: {
                                            columns: ':visible'
                                        }
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
                        ],
                        language: {
                            paginate: {
                                // remove previous & next text from pagination
                                previous: '&nbsp;',
                                next: '&nbsp;'
                            },
                            "lengthMenu": "{{__('locale.Show')}} _MENU_ {{__('locale.Entries')}}",
                            "zeroRecords": "{{__('locale.Nothing Found')}}",
                            "info": "{{__('locale.Showing')}} _START_ {{__('until')}} _END_ {{__('locale.Entries')}}",
                            "infoEmpty": "{{__('locale.Nothing Found')}}",
                            "loadingRecords": "{{ __('locale.Loading')  }}",
                            sProcessing: '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
                            "search": "{{ __('locale.Search') }}",
                        },
                    });

                }

                $('#search').on("click", function () {

                    let filters = getFiltersFromInputs();

                    updateUrlWithFilters(filters)
                    mySearch(filters);
                });

                function getFiltersFromInputs(){
                    filters = [];
                    // filters.filterPatientName = $('#filter_patient_name').val();

                    return filters;
                }

                // Function to update URL with filters as query parameters
                function updateUrlWithFilters(filters) {
                    let searchParams = new URLSearchParams(window.location.search);

                    // Append filters to the search parameters
                    Object.keys(filters).forEach(function (key) {
                        if (filters[key] && filters[key]!='') { // Only append if the filter is not empty or null
                            searchParams.set(key, filters[key]);
                        } else {
                            searchParams.delete(key); // Remove empty filters from URL
                        }
                    });

                    // Update the URL without reloading the page
                    const newUrl = window.location.pathname + '?' + searchParams.toString();
                    history.pushState(null, '', newUrl);
                }
                function checkUrlParamsAndSetInputs() {
                    let searchParams = new URLSearchParams(window.location.search);

                    if (searchParams.has('filterPatientName')) {
                        $('#filter_patient_name').val(searchParams.get('filterPatientName'));
                    }

                }

                let elementsArray = document.querySelectorAll(".enter_filter");

                elementsArray.forEach(function (elem) {
                    elem.addEventListener("keypress", function () {
                        if (event.key === "Enter") {
                            let filters = getFiltersFromInputs();
                            mySearch(filters);
                        }
                    });
                });


            }


        });
    </script>

@endsection
