<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Practitioner Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.24.0/dist/tabler-icons.min.css">

    @include('includes.datatable_styles')
    @include('includes.datatable_scripts')
    @vite(['resources/css/practitioner-dashboard.css', 'resources/css/dashboard-common.css'])
</head>
<body>
@include('frontend.content.mock.dashboards.practitioner.includes.patient-information-modal')

@include('frontend.content.mock.dashboards.practitioner.includes.medical-history-modal-alcohol')
@include('frontend.content.mock.dashboards.practitioner.includes.medical-history-modal-hepatitis')
@include('frontend.content.mock.dashboards.practitioner.includes.pre-assessment-report-modal')


@include('frontend.content.mock.dashboards.includes.success-modal-regain')
@include('backend.components.delete_modal')
<div class="container">
    <div class="row h-100 p-4">
        <div class="col-3 col-xxl-2 bg-light me-0 rounded-4 main-menu">
            <div class="h-100 d-flex row flex-column p-xl-3 p-1">
                <!-- Logo at the top -->
                <div class="text-center mb-3">
                    <img src="{{Vite::asset('resources/images/logo/regainLogo.svg')}}" alt="Logo" class="img-fluid">
                </div>
                <div class="flex-grow-1 d-flex align-items-top ps-0">
                    <div>
                        <div class="row">
                            <div class="my-1 my-lg-5 ms-2">
                                <span class="nav-link text-left" id="v-pills-patient-registration-tab"
                                      aria-selected="true" style="color:#000; font-weight:bold;">
                                    New Patient <span
                                        class="notification-count-patient d-flex justify-content-center align-items-center">1</span>
                                </span>
                            </div>
                            <div class="d-flex flex-column justify-content-between ms-0 ps-0">
                                <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link text-left patient-directory-tab"
                                       id="v-pills-patient-directory-tab"
                                       data-bs-toggle="pill" data-bs-target="#v-pills-patient-directory" type="button"
                                       role="tab"
                                       aria-controls="v-pills-patient-directory" aria-selected="true">
                                        <i class="ti ti-man-filled me-2"></i> Patients
                                    </a>
                                    <a class="nav-link text-left" id="v-pills-calendar-tab" data-bs-toggle="pill"
                                       data-bs-target="#v-pills-calendar" type="button" role="tab"
                                       aria-controls="v-pills-calendar" aria-selected="false">
                                        <i class="ti ti-calendar me-2"></i> Calendar
                                    </a>
                                    <a class="nav-link text-left" id="v-pills-help-tab" data-bs-toggle="pill"
                                       data-bs-target="#v-pills-help" type="button" role="tab"
                                       aria-controls="v-pills-help" aria-selected="false">
                                        <i class="ti ti-help me-2"></i> Help Center
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn text-center mt-md-3 mt-1 d-flex justify-content-center align-items-center"
                        style="border: 2px solid; border-radius: 10px; font-weight: 700; font-size: 15px;">
                    <i class="ti ti-logout me-2"></i> Log Out
                </button>
            </div>
        </div>
        <div class="col-9 col-xxl-10">
            <div class="right-side">
                <nav class="navbar navbar-expand-lg navbar-light bg-light custom-navbar rounded-3">
                    <div class="container-fluid">
                        <div class="nav-brand">
                            <h6 class="navbar-logo mb-0">Dr Andriy Semikhodov</h6>
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
                                <button href="#" class="btn btn-lg notification-button rounded-pill"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifications"><span
                                        class="notification-count">3</span><i class="ti ti-bell"></i></button>
                                <button href="#" class="btn btn-lg profile-button rounded-pill" data-bs-toggle="tooltip"
                                        data-bs-placement="bottom" title="Profile"><i class="ti ti-user"></i></button>
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="tab-content mt-4" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                         aria-labelledby="v-pills-home-tab">
                        <div class="row">
                            <div class="col-4">
                                <div class="card patient-card">
                                    <div class="card-body patient-card-body">
                                        <span class="patient-profile-label">Patient Profile</span>
                                        <button class="more-button position-absolute btn"
                                                style="right: 1rem; top: 1rem;"
                                                data-bs-toggle="modal" data-bs-target="#patientInformation"><i
                                                class="ti ti-dots-vertical"></i>
                                        </button>
                                        <h5 class="patient-name">Olha Maximova</h5>

                                        <p class="patient-detail"><span>Patient ID:</span>&nbsp; #P12345</p>
                                        <p class="patient-detail"><span>Date of Birth:</span>&nbsp; 04/03/1985</p>
                                        <p class="patient-detail"><span>Phone Number:</span>&nbsp; (123) 456-789</p>
                                        <p class="patient-detail"><span>Email:</span>&nbsp; maximova85@gmail.com</p>
                                        <p class="patient-detail last-detail"><span>Registration:</span>&nbsp;
                                            07/11/2024</p>

                                        <button
                                                data-bs-toggle="modal" data-bs-target="#preAssessmentReportModal"

                                            class="btn pre-assesment-btn">Pre-Assesment Report</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card info-card">
                                    <div class="card-body info-card-body">
                                        <span class="patient-profile-label">Information</span>
                                        <button class="info-icon-button btn" type="button">
                                            <i class="ti ti-info-circle-filled"></i>
                                        </button>

                                        <h6 class="section-title">Details</h6>
                                        <div class="tags-container">
                                            <span class="detail-tag tag-purple">-</span>
                                            {{--                                            <span class="detail-tag tag-purple">Accessible Mobility</span>--}}
                                            {{--                                            <span class="detail-tag tag-purple">Diabetes</span>--}}
                                            {{--                                            <span class="detail-tag tag-purple">COPD</span>--}}
                                            {{--                                            <span class="detail-tag tag-purple">Depression</span>--}}
                                            {{--                                            <button class="view-more-btn">View More</button>--}}
                                        </div>

                                        <h6 class="section-title">Medication</h6>
                                        <div class="tags-container">
                                            <span class="detail-tag">-</span>
                                            {{--                                            <span class="detail-tag">Tiotropium</span>--}}
                                            {{--                                            <span class="detail-tag">Carbocisteine</span>--}}
                                            {{--                                            <span class="detail-tag">Mirtazapine</span>--}}
                                            {{--                                            <button class="view-more-btn">View More</button>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="col-12">
                                    <div class="card medical-history-card">
                                        <div class="card-body medical-history-card-body">
                                            <span class="card-label">Medical History</span>
                                            {{--                                            <p class="mh-date"><strong>Date of Medical History:</strong> 06/11/2024 <span class="mh-self-filled">(self-filled)</span></p>--}}
                                            <p class="mh-date"><strong>-</strong></p>
                                            <div class="mh-actions">
                                                <div class="d-flex flex-column align-items-start">
                                                    {{--                                                    <a href="#" class="mh-link">--}}
                                                    {{--                                                        <i class="ti ti-eye"></i> View--}}
                                                    {{--                                                    </a>--}}
                                                    {{--                                                    <a href="#" class="mh-link mt-1">--}}
                                                    {{--                                                        <i class="ti ti-download"></i> Download--}}
                                                    {{--                                                    </a>--}}
                                                </div>
                                                <a href="#" class="btn mh-btn" data-bs-toggle="modal"
                                                   data-bs-target="#medicalHistoryHepatitis">Medical History</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="card appointment-card">
                                        <div class="card-body appointment-card-body">
                                            <span class="card-label">Appointment</span>
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="appointment-info">
                                                    <div class="appointment-date">-</div>
                                                    {{--                                                    <div class="appointment-date">19/11/2024</div>--}}
                                                    <div class="appointment-subtext">Next Appointment</div>
                                                </div>
                                                <div class="appointment-actions d-flex flex-column align-items-end">
                                                    <a href="#" class="btn app-create-btn disabled">Create</a>
                                                    <a href="#" class="btn app-cancel-btn disabled">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card overflow-hidden mb-0 mt-4"
                     style=" border-radius: 20px; height: 100% !important">
                    <div class="card-body p-0 m-0">
                        <div class="row">
                            <section id="column-selectors">
                                <section id="column-selectors">
                                    <div class="table-responsive">
                                        <table class="table patients-datatable general-datatable dt-select-table w-100">
                                            <thead>
                                            <tr class="text-center">
                                                @foreach($columns as $column)
                                                    <th> {{ __($column['name']) }}</th>
                                                @endforeach
                                                <th class="text-end">{{ __('Actions') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-center">

                                            </tbody>
                                        </table>
                                    </div>
                                </section>
                            </section>
                        </div>
                    </div>
                    <div class="card-footer align-items-center d-flex justify-content-between">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
                        url: "{{ route('mock.patients.datatable') }}",
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
                        {data: 'status', name: 'status', searchable: false, orderable: false},
                        {data: 'actions', searchable: false, orderable: false, className: 'text-end'},
                    ],
                    columnDefs: [],
                    dom: 't<"d-flex justify-content-between mx-0 row"<"d-flex justify-content-center col-12"i><"d-flex justify-content-center col-12"p>>',
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
                        $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
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

<style>

</style>

</body>
</html>
