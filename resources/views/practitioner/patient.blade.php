@php
    use App\Domains\Patient\Models\PatientData;
    use App\Domains\Practitioner\Models\Practitioner;
/**
* @var Practitioner $practitioner
 * @var PatientData $patientData
*/
@endphp

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

@include('practitioner.includes.medical-history-modal')

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
                                    <a class="active nav-link text-left patient-directory-tab"
                                       id="v-pills-patient-directory-tab"
                                       type="button"
                                       role="tab"
                                       href="{{route("practitioner.patients")}}"
                                       aria-controls="v-pills-patient-directory" aria-selected="true">
                                        <i class="ti ti-man-filled me-2"></i> Patients
                                    </a>
                                    <a class="nav-link text-left" id="v-pills-calendar-tab"
                                       type="button" role="tab"
                                       href="{{route("practitioner.home")}}"
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
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn text-center mt-md-3 mt-1 d-flex justify-content-center align-items-center"
                            style="border: 2px solid; border-radius: 10px; font-weight: 700; font-size: 15px;">
                        <i class="ti ti-logout me-2"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
        <div class="col-9 col-xxl-10">
            <div class="right-side">
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

                                        <p class="patient-detail">
                                            <span>Patient ID:</span>&nbsp; #P{{$patientData->getUser()->getId()}}</p>
                                        <p class="patient-detail">
                                            <span>Date of Birth:</span>&nbsp; {{$patientData->getBirthday()->format("d/m/Y")}}
                                        </p>
                                        <p class="patient-detail">
                                            <span>Phone Number:</span>&nbsp; {{$patientData->getPrimaryPhone()}}</p>
                                        <p class="patient-detail">
                                            <span>Email:</span>&nbsp; {{$patientData->getUser()->getEmail()}}</p>
                                        <p class="patient-detail last-detail"><span>Registration:</span>&nbsp;
                                            {{$patientData->getUser()->getCreatedAt()->format("d/m/Y")}}</p>

                                        <a href="#" class="btn pre-assesment-btn">Pre-Assesment Report</a>
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
                                        </div>

                                        <h6 class="section-title">Medication</h6>
                                        <div class="tags-container">
                                            <span class="detail-tag">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="col-12">
                                    <div class="card medical-history-card">
                                        <div class="card-body medical-history-card-body">
                                            <span class="card-label">Medical History</span>
                                            <p class="mh-date"><strong>-</strong></p>
                                            <div class="mh-actions">
                                                <div class="d-flex flex-column align-items-start">
                                                </div>
                                                <a href="#" class="btn mh-btn" data-bs-toggle="modal"
                                                   data-bs-target="#medicalHistory"
                                                   id="load-medical-history">
                                                    Medical History
                                                </a>
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


    document.addEventListener('DOMContentLoaded', function () {
        const modalContainer = document.getElementById('medical-history-content');
        const loadMedicalHistoryBtn = document.getElementById('load-medical-history');
        const medicalHistoryModal = new bootstrap.Modal(document.getElementById('medicalHistory'));  // Initialize modal using Bootstrap

        // Function to fetch medical history data
        function fetchMedicalHistory(userId) {
            // Send POST request to fetch medical history data
            fetch(`{{ route("practitioner.medical-history", $patientData->getUserId()) }}`, {
                method: 'POST',  // Change the method to POST
                headers: {
                    'Content-Type': 'application/json',  // Set content type to JSON
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: userId  // Send any data (e.g., userId) if needed
                })
            })
                .then(response => response.text())
                .then(data => {
                    // Replace modal content with the fetched data
                    modalContainer.innerHTML = data;

                    // Show the modal after the content is fetched and set
                    medicalHistoryModal.show();
                })
                .catch(error => {
                    console.error('Error fetching medical history content:', error);
                });
        }

        // Listen for the modal show event and fetch data when the modal is shown
        loadMedicalHistoryBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = loadMedicalHistoryBtn.getAttribute('data-user-id');

            // Before fetching, make sure the modal is hidden
            modalContainer.innerHTML = ''; // Clear previous content
            medicalHistoryModal.hide(); // Hide modal initially

            // Fetch the medical history and show the modal after content is updated
            fetchMedicalHistory(userId);
        });
    });
</script>
</body>
</html>
