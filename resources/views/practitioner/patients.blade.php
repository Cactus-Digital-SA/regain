@php
    /**
    * @var \App\Domains\Patient\Models\PatientData $patients
    */
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Practitioner Dashboard Calendar</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.24.0/dist/tabler-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.js"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css"
    />

    @include('includes.datatable_styles')
    @include('includes.datatable_scripts')
    @vite(['resources/css/practitioner-dashboard.css', 'resources/css/dashboard-common.css'])
</head>
<body>
@include('frontend.content.mock.dashboards.practitioner.includes.patient-information-modal')

@include('frontend.content.mock.dashboards.practitioner.includes.medical-history-modal-alcohol')
@include('frontend.content.mock.dashboards.practitioner.includes.medical-history-modal-hepatitis')

@include('frontend.content.mock.dashboards.includes.success-modal-regain')
@include('backend.components.delete_modal')
<div class="wrapper">
    <div class="container">
        <div class="row h-100 p-4">
            <div class="col-3 col-xxl-2 bg-light me-0 rounded-4 main-menu">
                <div class="h-100 d-flex row flex-column py-xl-3 px-xl-4 p-1">
                    <!-- Logo at the top -->
                    <div class="text-start mb-3 px-0 mt-1">
                        <img src="{{Vite::asset('resources/images/logo/regainLogo.svg')}}" alt="Logo" class="img-fluid">
                    </div>
                    <div class="flex-grow-1 d-flex align-items-top ps-0">
                        <div>
                            <div class="row">
                                <div class="my-1 my-lg-5 ms-2">
                                <span class="nav-link text-left" id="v-pills-patient-registration-tab"
                                      aria-selected="true" style="color:#000; font-weight:bold;">
                                    New Patient <span
                                        class="notification-count-patient d-flex justify-content-center align-items-center">1
                                    </span>
                                </span>
                                </div>
                                <div class="d-flex flex-column justify-content-between ms-0 ps-0">
                                    <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab"
                                         role="tablist"
                                         aria-orientation="vertical">
                                        <a class="active nav-link text-left patient-directory-tab"
                                           id="v-pills-patient-directory-tab"
                                           type="button"
                                           role="tab"
                                           href="{{route("practitioner.patients")}}"
                                           aria-controls="v-pills-patient-directory" aria-selected="true">
                                            <i class="ti ti-man-filled me-2"></i> Patients
                                        </a>
                                        <a class="nav-link text-left disabled" id="v-pills-calendar-tab"
                                           type="button" role="tab"
                                           href="{{route("practitioner.home")}}"
                                           aria-controls="v-pills-calendar" aria-selected="false">
                                            <i class="ti ti-calendar me-2"></i> Calendar
                                        </a>
                                        <a class="nav-link text-left disabled" id="v-pills-help-tab" data-bs-toggle="pill"
                                           data-bs-target="#v-pills-help" type="button" role="tab"
                                           aria-controls="v-pills-help" aria-selected="false">
                                            <i class="ti ti-help me-2"></i> Help Center
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="logout-form-div">
                        @csrf
                        <button type="submit"
                                class="btn text-center mt-md-3 mt-1 d-flex justify-content-center align-items-center"
                                style="border: 2px solid; border-radius: 10px; font-weight: 700; font-size: 15px;">
                            <i class="ti ti-logout me-2"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-9 col-xxl-10">
                <div class="right-side" style="margin-left: 9px;">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light custom-navbar rounded-3">
                        <div class="container-fluid">
                            <div class="nav-brand">
                                <h6 class="navbar-logo mb-0">Dr {{$practitioner->getUser()->getName()}}</h6>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#">Ministry of Regain</a></li>
                                </ol>
                            </div>
                            <div class="nav-search row">
                                <div class="box col-auto">
                                    <form name="search">
                                        <input type="text" class="input" name="search" placeholder="Search ...">
                                    </form>
                                    <i class="ti ti-search"></i>
                                </div>
                                <div class="nav-buttons col-auto">
                                <span class="navbar-status"> Accepting
                                </span>
                                    <button href="#" class="ms-3 btn btn-lg notification-button rounded-pill "
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Notifications"><div
                                            class="notification-count"><span class="notification-span">3</span></div><i class="ti ti-bell"></i></button>
                                    <button href="#" class="btn btn-lg profile-button rounded-pill "
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" title="Profile"><i class="ti ti-user"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="col-35">
                                    <div class="card" style="border-radius: 20px">
                                        <div class="card-body px-xl-5 px-2">
                                            <h5 class="card-title mb-0">142</h5>
                                            <span class="card-subtitle text-muted">Total Practitioners</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-35">
                                    <div class="card" style="border-radius: 20px">
                                        <div class="card-body px-xl-5 px-2">
                                            <h5 class="card-title mb-0">12</h5>
                                            <span class="card-subtitle text-muted">Total Practitioners</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-35">
                                    <div class="card" style="border-radius: 20px">
                                        <div class="card-body px-xl-5 px-2">
                                            <h5 class="card-title mb-0" style="color: rgba(40, 199, 111, 1)">74%</h5>
                                            <span class="card-subtitle text-muted">Capacity</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <select class="dropdown-select" name="month">
                                        <option value="">Filter by month</option>
                                        @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    <select class="dropdown-select mt-3" name="year">
                                        <option value="">Filter by year</option>
                                        @for ($i = date('Y'); $i >= 2020; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-8 col-7">
                            <div class="card overflow-hidden mb-0"
                                 style=" border-radius: 20px; height: 100% !important; ">
                                <div class="card-body p-0 m-0 card-table-body">
                                    <div class="row">
                                        <section id="column-selectors">
                                            <section id="column-selectors">
                                                <div class="table-responsive">
                                                    <table
                                                        class="table patients-datatable general-datatable dt-select-table w-100">
                                                        <thead>
                                                        <tr class="text-left">
                                                            @foreach($columns as $column)
                                                                <th class="text-left"> {{ __($column['name']) }}</th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody class="text-left">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </section>
                                        </section>
                                    </div>
                                </div>
                                <div class="card-footer align-items-center d-flex justify-content-center">
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-5">
                            <div class="card overflow-hidden mb-0 d-flex justify-content-center align-items-center"
                                 style="background-color: #dddef1; border-radius: 20px">
                                <div class="card-body p-0 m-0 card-table-body">
                                    <div id="custom-calendar" class="custom-calendar">

                                    </div>
                                    <div
                                        class="calendar-footer d-flex justify-content-center align-items-center px-2 py-3"
                                        style="background-color: #dddef1">
                                        <button class="appointment-overview position-relative w-100"
                                                style="border-radius: 10px; border: 2px solid; font-weight: 700; font-size: 15px; background-color: transparent">
                                            Appointment Overview
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    new Calendar({
        id: '#custom-calendar',
        theme: 'basic',
        primaryColor: '#0A133A',
        headerBackgroundColor: '#dddef1',
        bodyBackgroundColor: '#dddef1',
        calendarSize: 'large',
        dropShadow: 'false',
        dateChanged: (currentDate, events) => {
            console.log('Selected Date:', currentDate);
        },
        eventsData: [
            {
                start: '2024-12-20',
                end: '2024-12-20',
                name: 'Sample Event 1',
            },
            {
                start: '2024-12-25',
                end: '2024-12-25',
                name: 'Christmas',
            },
        ],
    });
</script>

<script type="module">
    $(function () {
        let dt_basic_table = $('.patients-datatable');

        if (dt_basic_table.length) {
            checkUrlParamsAndSetInputs()

            mySearch();

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
                        url: "{{ route('practitioner.patients.datatable') }}",
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
                        {data: 'id', searchable: false, orderable: false},
                        {data: 'name', name: 'user.name', searchable: false, orderable: true},
                        {data: 'registered', name: 'users.created_at', searchable: false, orderable: false},
                        {data: 'status', name: 'status', searchable: false, orderable: false}
                    ],
                    columnDefs: [],
                    dom: 't<"d-flex justify-content-between mx-0 row"<"d-flex justify-content-left col-12"i><"d-flex justify-content-left col-12"p>>',
                    paginate: {
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    },
                    "search": "",
                    "info": "",
                    "infoEmpty": "",
                    "emptyTable": "",
                    "loadingRecords": "",
                    language: {
                        processing: '',
                    },
                    initComplete: function () {
                        $('.card-footer .dataTables_paginate').remove();

                        var pagination = $('.dataTables_paginate').detach();
                        $('.card-footer').append(pagination);
                    }
                });

            }

            $('#search').on("click", function () {
                mySearch(filters);
            });

            function updateUrlWithFilters(filters) {
                let searchParams = new URLSearchParams(window.location.search);

                Object.keys(filters).forEach(function (key) {
                    if (filters[key] && filters[key] != '') {
                        searchParams.set(key, filters[key]);
                    } else {
                        searchParams.delete(key);
                    }
                });

                const newUrl = window.location.pathname + '?' + searchParams.toString();
                history.pushState(null, '', newUrl);
            }

            function checkUrlParamsAndSetInputs() {
                // let searchParams = new URLSearchParams(window.location.search);
                // if (searchParams.has('filterPatientName')) {
                //     $('#filter_patient_name').val(searchParams.get('filterPatientName'));
                // }
            }

            let elementsArray = document.querySelectorAll(".enter_filter");

            elementsArray.forEach(function (elem) {
                elem.addEventListener("keypress", function () {
                    if (event.key === "Enter") {
                        mySearch();
                    }
                });
            });
        }
    });
</script>

</body>
</html>
