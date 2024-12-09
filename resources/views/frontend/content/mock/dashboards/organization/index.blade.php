<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.24.0/dist/tabler-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js"
            integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
</style>
<body>

@include('includes.datatable_styles')
@include('includes.datatable_scripts')
@vite(['resources/css/organization-dashboard.css'])
@include('frontend.content.mock.dashboards.organization.includes.new-patient-registration-modal')

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
                            <div class="my-1 my-lg-5">
                                <a class="nav-link text-left" id="v-pills-patient-registration-tab" data-bs-toggle="pill"
                                   data-bs-target="#v-pills-patient-registration" type="button" role="tab" aria-controls="v-pills-patient-registration"
                                   aria-selected="true" style="color:#000; font-weight:bold;">
                                    Patient Registration
                                </a>
                                <a class="nav-link text-left mt-1 mt-sm-3" id="v-pills-add-practitioner-tab"
                                   data-bs-toggle="pill" data-bs-target="#v-pills-add-practitioner" type="button" role="tab"
                                   aria-controls="v-pills-add-practitioner" aria-selected="false"
                                   style="color:#000; font-weight:bold;">
                                    Add Practitioner
                                </a>
                            </div>
                            <div class="d-flex flex-column justify-content-between ms-0 ps-0">
                                <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link text-left patient-directory-tab" id="v-pills-patient-directory-tab"
                                       data-bs-toggle="pill" data-bs-target="#v-pills-patient-directory" type="button" role="tab"
                                       aria-controls="v-pills-patient-directory" aria-selected="true">
                                        <i class="ti ti-man-filled me-2"></i> Patient Directory
                                    </a>
                                    <a class="nav-link active text-left practitioner-directory-tab" id="v-pills-practitioner-directory-tab"
                                       data-bs-toggle="pill" data-bs-target="#v-pills-practitioner-directory" type="button" role="tab"
                                       aria-controls="v-pills-practitioner-directory" aria-selected="false">
                                        <i class="ti ti-user-screen me-2"></i> Practitioner Directory
                                    </a>
                                    <a class="nav-link text-left" id="v-pills-calendar-tab" data-bs-toggle="pill"
                                       data-bs-target="#v-pills-calendar" type="button" role="tab"
                                       aria-controls="v-pills-calendar" aria-selected="false">
                                        <i class="ti ti-calendar me-2"></i> Calendar
                                    </a>
                                    <a class="nav-link text-left" id="v-pills-settings-tab" data-bs-toggle="pill"
                                       data-bs-target="#v-pills-settings" type="button" role="tab"
                                       aria-controls="v-pills-settings" aria-selected="false">
                                        <i class="ti ti-settings me-2"></i> Settings
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
                            <h6 class="ministry-logo mb-0">Ministry of Regain</h6>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Organization</li>
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
                                <button type="button" class="btn btn-success add-pract-button" data-bs-toggle="modal"
                                        data-bs-target="#newPatientRegistration"><i
                                        class="ti ti-plus"></i> Add Practitioner
                                </button>
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
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                             aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="col-3">
                                    <div class="card" style="border-radius: 20px">
                                        <div class="card-body px-xl-3 px-2">
                                            <h5 class="card-title mb-0">142</h5>
                                            <span class="card-subtitle text-muted">Total Practitioners</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card" style="border-radius: 20px">
                                        <div class="card-body px-xl-3 px-2">
                                            <h5 class="card-title mb-0">12</h5>
                                            <span class="card-subtitle text-muted">Total Practitioners</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="card" style="border-radius: 20px">
                                        <div class="card-body px-xl-3 px-2">
                                            <h5 class="card-title mb-0" style="color: rgba(40, 199, 111, 1)">74%</h5>
                                            <span class="card-subtitle text-muted">Patient Satisfaction</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <select class="dropdown-select" name="month">
                                        <option value="">Filter by month</option>
                                        @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                            <option value="{{ $month }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    <select class="dropdown-select mt-2" name="year">
                                        <option value="">Filter by year</option>
                                        @for ($i = date('Y'); $i >= 1900; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card overflow-hidden mt-4" style="border-radius: 20px">
                    <div class="card-body p-0 m-0">
                        <div class="row">
                            <section id="column-selectors">
                                <div class="table-responsive">
                                    <table class="table datatable-practitioners dt-select-table">
                                        <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Practitioner ID</th>
                                            <th>Practitioner Name</th>
                                            <th>Description</th>
                                            <th>Registered</th>
                                            <th>Region</th>
                                            <th>Patients</th>
                                            <th>Status</th>
                                            <th class="text-end">##</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">

                                        </tbody>
                                    </table>
                                </div>
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
    let dt_table = $('.datatable-practitioners');
    if (dt_table.length) {
        search();

        function search() {
            if ($.fn.DataTable.isDataTable('.datatable-practitioners')) {
                dt_table.DataTable().destroy();
            }
            dt_table.DataTable({
                scrollX: true,
                responsive: false,
                deferRender: true,
                processing: true,
                serverSide: true,
                searching: false,
                serverMethod: 'post',
                ajax: {
                    url: "",
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    data: function (data) {

                    }
                },
                pageLength: 15,
                lengthMenu: [
                    [15, 30, 100],
                    ['15', '30', '100']
                ],
                columns: [
                    {data: 'id', orderable: false},
                    {data: 'practitioner_id'},
                    {data: 'practitioner_name'},
                    {data: 'description'},
                    {data: 'registered'},
                    {data: 'region'},
                    {data: 'patients'},
                    {data: 'status'},
                ],
                columnDefs: [{
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    visible: false,
                },],
                dom: '<"d-flex justify-content-between align-items-center mx-2 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"<"dt-action-buttons text-end"B>f>>t<"d-flex justify-content-between mx-0 row"<"d-flex justify-content-center col-12"i><"d-flex justify-content-center col-12"p>>',
                "oLanguage": {
                    "sSearch": "Filter Data"
                },
                "iDisplayLength": -1,
                "sPaginationType": "full_numbers",
                buttons: [{
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-2',
                    text: '<i class="ti ti-logout rotate-n90 me-2"></i>' + '{{ __('locale.Export') }}',
                    buttons: [{
                        extend: 'print',
                        text: '<i class="ti ti-printer me-2" ></i>Print',
                        className: 'dropdown-item',
                    },
                        {
                            extend: 'csv',
                            text: '<i class="ti ti-file-text me-2" ></i>Csv',
                            className: 'dropdown-item',
                            charset: 'utf-8',
                            bom: true,
                        },
                        {
                            extend: 'excel',
                            text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                            className: 'dropdown-item',
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="ti ti-file-text me-2"></i>Pdf',
                            className: 'dropdown-item',
                        },
                        {
                            extend: 'copy',
                            text: '<i class="ti ti-copy me-1" ></i>Copy',
                            className: 'dropdown-item',
                        }
                    ],
                }],
            });
        }
    }
</script>

</body>
</html>
