@php
    use App\Domains\Patient\Models\PatientData;
    use App\Domains\Practitioner\Models\Practitioner;
    use App\Domains\Reports\Dtos\MedicalHistoryReport\MedicalHistoryResult;use App\Domains\Reports\Http\Presenters\FlowsPresenter;
/**
* @var Practitioner $practitioner
 * @var PatientData $patientData
 * @var FlowsPresenter $presenter
 * @var bool $medicalHistoryCompleted
 * @var MedicalHistoryResult $medicalHistoryResult
 * @var array $medicalHistoryPresenter
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
@if(isset($presenter))
    @foreach($presenter->getFlows() as $flow)
        @include('practitioner.includes.report-modal', [
            "flow" => $flow,
            "userId" => $patientData->getUser()->getId()
        ])
    @endforeach
@endif

<div class="modal fade" id="medicalHistory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%; max-height: 100%">
        <div id="medical-history-content" class="modal-content p-3 p-md-5"
             style="background-color: rgba(255, 255, 255, 1);">
        </div>
    </div>
</div>

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
                                      aria-selected="true"
                                      style="color:#000; font-weight:bold; cursor: pointer !important">
                                    New Patient <span
                                        class="notification-count-patient d-flex justify-content-center align-items-center">1</span>
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
                                        <a class="nav-link text-left" id="v-pills-calendar-tab"
                                           type="button"
                                           aria-controls="v-pills-calendar" aria-selected="false">
                                            <i class="ti ti-calendar me-2"></i> Calendar
                                        </a>
                                        <a class="nav-link text-left" id="v-pills-help-tab"
                                           data-bs-target="#v-pills-help" type="button"
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
                                            title="Notifications">
                                        <div
                                            class="notification-count"><span class="notification-span">3</span>
                                        </div>
                                        <i class="ti ti-bell"></i></button>
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
                                <div class="col-4">
                                    <div class="card patient-card">
                                        <div class="card-body patient-card-body">
                                            <span class="patient-profile-label">Patient Profile</span>
                                            <h5 class="patient-name">{{$patientData->getUser()->getName()}}</h5>
                                            <p class="patient-detail">
                                                <span>Patient ID:</span>&nbsp; #P{{$patientData->getUser()->getId()}}
                                            </p>
                                            <p class="patient-detail">
                                                <span>Date of Birth:</span>&nbsp; {{$patientData->getBirthday()->format("d/m/Y")}}
                                            </p>
                                            <p class="patient-detail">
                                                <span>Phone Number:</span>&nbsp; {{$patientData->getPrimaryPhone()}}
                                            </p>
                                            <p class="patient-detail">
                                                <span>Email:</span>&nbsp; {{$patientData->getUser()->getEmail()}}
                                            </p>
                                            <p class="patient-detail
                                        last-detail
                                         ">
                                                <span>Registration:</span>&nbsp; {{$patientData->getUser()->getCreatedAt()->format("d/m/Y")}}
                                            </p>
                                            <div class="dropdown">
                                                <button class="pre-assessment-btn btn dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">Reports
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @foreach($presenter->getFlows() as $flow)
                                                        <li>
                                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                                    data-bs-target="#flow-{{$flow->getFlowType()}}">
                                                                {{$flow->getName()}}
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
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
                                                @foreach($medicalHistoryPresenter["details"] as $presenter)
                                                    <span class="detail-tag tag-purple">{{ $presenter }}</span>
                                                @endforeach

                                            </div>

                                            <h6 class="section-title">Medication</h6>
                                            <div class="tags-container">
                                                @foreach($medicalHistoryPresenter["medication"] as $presenter)
                                                    <span class="detail-tag">{{ ucfirst($presenter) }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 d-flex flex-column">
                                    <div class="col-12 flex-grow-1 d-flex">
                                        <div class="card medical-history-card w-100">
                                            <div class="card-body medical-history-card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex flex-column flex-grow-1">
                                                        <span class="patient-profile-label" style="padding-bottom: 5px">Medical History</span>
                                                        <div class="d-flex flex-column" style="margin-top: 0;">
                                                            @if ($medicalHistoryCompleted !== null)
                                                                <p class="mh-date">
                                                                    <strong>Date of Medical
                                                                        History:</strong> {{$medicalHistoryCompleted->format("d/m/Y")}}
                                                                    <span
                                                                        class="mh-self-filled text-nowrap">(Completed)</span>
                                                                </p>
                                                            @else
                                                                <p class="mh-date">
                                                                    <strong>-</strong>
                                                                </p>
                                                            @endif
                                                            <div class="d-flex flex-column align-items-start mt-2">
                                                                @if ($medicalHistoryCompleted !== null)
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                        <div class="d-flex flex-column ">
                                                                            <a href="{{route("practitioner.medical-history-report", [ "userId" => $patientData->getUser()->getId()])}}"
                                                                               class="mh-link"
                                                                               data-bs-toggle="modal"
                                                                               data-bs-target="#medicalHistoryResult">
                                                                                <i class="ti ti-eye"></i> View
                                                                            </a>
                                                                            <a target="_blank" href="{{route("practitioner.medical-history-report-download", ["userId" => $patientData->getUser()->getId()] )}}"
                                                                               class="mh-link mt-1">
                                                                                <i class="ti ti-download"></i> Download
                                                                            </a>
                                                                        </div>
                                                                        <div class="d-flex align-items-end">
                                                                            <a href="#" class="btn mh-btn"
                                                                               data-bs-toggle="modal"
                                                                               data-bs-target="#medicalHistory"
                                                                               id="load-medical-history">
                                                                                <i class="ti ti-pencil"></i>
                                                                                Medical History
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <a href="#" class="btn mh-btn"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#medicalHistory"
                                                                       id="load-medical-history">
                                                                        Medical History
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 flex-grow-1 d-flex mt-3">
                                        <div class="card appointment-card w-100">
                                            <div class="card-body appointment-card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="appointment-info">
                                                        <span class="card-label mb-2" style="padding-bottom: 8px">Appointment</span>
                                                        <div class="appointment-date">{{ $nextAppointmentDate->format("d/m/Y") }}</div>
                                                        <div class="appointment-subtext">Next Appointment</div>
                                                    </div>
                                                    <div class="appointment-actions d-flex flex-column me-2" style="width: 40%">
                                                        <a href="#" class="btn app-create-btn">Create</a>
                                                        <a href="#" class="btn app-cancel-btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card overflow-hidden mb-0"
                         style=" border-radius: 20px; height: 100% !important; min-height: 190px !important">
                        <div class="card-body p-0 m-0 card-table-body" style="min-height: 150px !important">
                            <div class="row">
                                <section id="column-selectors">
                                    <section id="column-selectors">
                                        <div class="table-responsive">
                                            <table
                                                class="table patient-datatable general-datatable dt-select-table w-100">
                                                <thead>
                                                <tr class="text-center">

                                                    <th class="text-left">{{ __('Appointment Date') }}</th>
                                                    <th class="text-left">{{ __('Reports') }}</th>
                                                    <th class="text-left">{{ __('Notes') }}</th>
                                                    <th class="text-left">{{ __('Regain Progress') }}</th>
                                                    <th class="text-left">{{ __('Actions') }}</th>
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
                        <div class="card-footer align-items-center d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module">
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
                    bootModal();
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

        $('#medicalHistory').on('hidden.bs.modal', function () {
            window.location.reload();
        });

    });
</script>
<script>
    function bootModal() {
        const nextButton = document.getElementById('next-button');
        const forms = document.querySelectorAll('form.collect-question');
        const checkboxes = document.querySelectorAll('.select-response');
        document.getElementById('overlay').style.visibility = 'hidden';

        // Function to handle checkbox change and update the 'Next' button state
        function updateNextButtonState() {
            let missing = false;
            forms.forEach(form => {
                    const container = form.closest('.question-container');
                    questionId = form.dataset.questionId;
                    if (container && container.dataset.hide !== "true") {
                        if (container.dataset.userInput === "false") {
                            const checkboxesForQuestion = form.querySelectorAll('input[name="response-' + questionId + '"]:checked');
                            if (checkboxesForQuestion.length === 0) {
                                missing = true;
                            }
                        } else {
                            if (form.querySelector(`.select-response`).value.trim().length === 0) {
                                missing = true;
                            }
                        }
                    }
                }
            )
            nextButton.disabled = missing;
        }

        function handleInputChange(e) {
            const questionId = this.dataset.questionId;
            const inputForm = document.getElementById(`input-form_${questionId}`);
            const maxSelections = inputForm.dataset.maxSelections;
            const formAvailableCheckBoxes = inputForm.querySelectorAll(`input[name="response-${questionId}"]`);
            const formCheckedBoxes = Array.from(formAvailableCheckBoxes).filter(checkbox => checkbox.checked);

            if (formCheckedBoxes.length > maxSelections) {
                formAvailableCheckBoxes.forEach(cb => {
                    if (cb !== event.currentTarget) {
                        cb.checked = false;
                    }
                });
            }

            const dependantForms = document.querySelectorAll('form[data-condition-question-id]:not([data-condition-question-id=""])');
            dependantForms.forEach(form => {
                const requiredQuestionId = form.dataset.conditionQuestionId;
                const requiredForm = document.getElementById(`input-form_${requiredQuestionId}`);
                const requiredQuestionResponseIds = JSON.parse(form.dataset.conditionRequiredResponseIds);
                const parentForm = document.getElementById(`input-form_${requiredQuestionId}`);
                const questionContainer = form.closest('.question-container');

                if (parentForm) {
                    const requiredFormInputs = parentForm.querySelectorAll('input:checked');
                    if (requiredFormInputs.length > 0) {
                        // Check if any selected inputs have a response ID that matches any in the required response IDs array
                        const containsAnyId = Array.from(requiredFormInputs).some(input =>
                            requiredQuestionResponseIds.includes(parseInt(input.dataset.responseId))
                        );

                        if (containsAnyId) {
                            if (questionContainer) {
                                questionContainer.classList.remove('hidden');
                                questionContainer.dataset.hide = "false";
                            }
                        } else {
                            questionContainer.classList.add('hidden');
                            questionContainer.dataset.hide = "true";
                        }
                    } else {
                        questionContainer.classList.add('hidden');
                        questionContainer.dataset.hide = "true";
                    }
                }
            });

            updateNextButtonState();
        }


        // Event listener for checkboxes
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', handleInputChange);
            checkbox.addEventListener('keydown', handleInputChange);
        });


        // Handle Next button click
        nextButton.addEventListener('click', function (e) {
                e.preventDefault();

                // Show the overlay and disable the button
                overlay.style.display = 'flex';
                nextButton.disabled = true;

                // Collect the selected response IDs for this question
                let selectedResponsesFinal = {};
                selectedResponsesFinal.questions = [];
                selectedResponsesFinal.textQuestions = [];
                document.querySelectorAll(`.collect-question`)
                    .forEach(questionForm => {
                        questionContainer = questionForm.closest('.question-container');
                        if (questionContainer.dataset.hide === "false") {
                            questionData = {};
                            questionData.questionId = parseInt(questionForm.dataset.questionId);

                            if (questionContainer.dataset.userInput === "false") {
                                questionData.responses = [];
                                responses = questionForm.querySelectorAll(`.select-response:checked`).forEach(response => {
                                    questionData.responses.push(parseInt(response.dataset.responseId));
                                });
                                selectedResponsesFinal.questions.push(questionData);
                            } else {
                                questionData.response = '';
                                textResponse = questionForm.querySelector(`.select-response`);
                                if (textResponse) {
                                    questionData.response = textResponse.value;
                                }
                                selectedResponsesFinal.textQuestions.push(questionData);
                            }

                        }
                    });

                if (selectedResponsesFinal.questions.length > 0 || selectedResponsesFinal.textQuestions.length > 0) {
                    const modalContainer = document.getElementById('medical-history-content');
                    document.getElementById('overlay').style.visibility = 'visible';
                    // Send the collected data via JSON
                    fetch('{{ route('practitioner.medical-history-submit', $patientData->getUserId()) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({data: selectedResponsesFinal})
                    })
                        .then(response => response.text())
                        .then(data => {
                            // Replace modal content with the fetched data
                            modalContainer.innerHTML = data;
                            bootModal();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }
        );

        nextButton.disabled = false;

        updateNextButtonState();
    }
</script>

<div class="modal fade" id="medicalHistoryResult" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%; max-height: 100%">
        <div id="medical-history-result-content" class="modal-content p-3 p-md-5"
             style="background-color: rgba(255, 255, 255, 1);">
            @include('reports.medicalHistory.index', ["result" => $medicalHistoryResult])
        </div>
    </div>
</div>

<div class="modal fade" id="scientificDetailsModal" tabindex="-10" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%;">
        <div class="modal-content p-3 p-md-5">
            <div id="vue-scientific-references"></div>
        </div>
    </div>
</div>

@vite(['resources/js/app.js'])
<script>
    function triggerReferencesModal(e) {
        showReferences(e.dataset.id, e.dataset.references)
    }
</script>
</body>
</html>
