<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Regain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/color-calendar/dist/bundle.js"></script>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/color-calendar/dist/css/theme-basic.css"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.28.1/tabler-icons.min.css" integrity="sha512-UuL1Le1IzormILxFr3ki91VGuPYjsKQkRFUvSrEuwdVCvYt6a1X73cJ8sWb/1E726+rfDRexUn528XRdqrSAOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
@include('patient.includes.navbar')
@vite(['resources/css/my-regain.css'])

<div class="basic-wrapper">
    <div class="row w-100 h-100 g-2">
        <div class="col-md-30 left-side">
            <div class="card">
                <div class="card-body">
                    <div class="profile-title text-left">Profile</div>
                    <div class="profile-avatar-name d-flex align-items-center">
                        <div class="profile-image">
                            <img src="{{ Vite::asset('resources/images/profile-image-girl.svg') }}" alt="Profile Image">
                        </div>
                        <div class="profile-name-id text-left ms-3">
                            <div class="profile-name">User</div>
                            <div class="profile-id">#123</div>
                        </div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-info-item">
                            <div class="profile-info-label">Date of Birth</div>
                            <div class="profile-info-value">16 / 01 / 1989</div>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Registration Date</div>
                            <div class="profile-info-value">02/10/2024</div>
                        </div>
                        <div class="profile-info-item">
                            <div class="profile-info-label">Region</div>
                            <div class="profile-info-value">Cherkaska oblast</div>
                        </div>
                    </div>
                    <div class="contact-info">
                        <div class="contact-title">
                            Contact Details
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-label">Date of Birth</div>
                            <div class="contact-info-value">16 / 01 / 1989</div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-label">Registration Date</div>
                            <div class="contact-info-value">02/10/2024</div>
                        </div>
                        <div class="contact-info-item">
                            <div class="contact-info-label">Region</div>
                            <div class="contact-info-value">Cherkaska oblast</div>
                        </div>
                    </div>
                    <div class="details-button-container">
                        <button type="button" class="main-btn-border">Edit Contact Details</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-70 right-side">
            <div class="card">
                <div class="card-body row d-flex align-items-center justify-content-between">
                    <div class="col-6 left-subsection d-flex flex-column justify-content-between" style="row-gap: 14px">
                        <div class="mini-card d-flex flex-column">
                            <div class="mini-card-title appointment-title">
                                <span class="opacity-50">Next Appointment</span> <span class="text-large" style="font-size: 30px; color: rgba(255, 0, 0, 1); opacity: 100%!important">•</span>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <span class="col-6 date"><i class="ti ti-calendar"></i> 02/10/2020 </span>
                                <span class="col-6 hour"><i class="ti ti-clock"></i> 17:20 </span>
                            </div>
                            <div class="d-flex" style="margin-top: auto">
                                <button type="button" class="main-btn-border">Cancel and Reschedule</button>
                            </div>
                        </div>
                        <div class="mini-card d-flex flex-column" style="border: 1px solid #0A133A !important;">
                            <span class="mini-card-title">My Regain Progress</span>
                            <span class="module-3-sub-title"><i class="ti ti-pencil me-1"></i>Module 3</span>
                            <div>
                                <div class="progress-container row d-flex align-items-center justify-content-center" style="gap: 10px">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 16%"></div>
                                    <div class="progress-bar" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 16%"></div>
                                    <div class="progress-bar bg-light-purple" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 16%"></div>
                                    <div class="progress-bar bg-light-purple" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 16%"></div>
                                    <div class="progress-bar bg-light-purple" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 16%"></div>
                                </div>
                            </div>
                            <div class="d-flex" style="margin-top: auto">
                                <button type="button" class="main-btn-purple">Start Module 3</button>
                            </div>
                        </div>
                        <div class="mini-card">
                            <span class="mini-card-title">My Treatment Progress</span>

                        </div>
                    </div>
                    <div class="col-6 right-subsection d-flex flex-column justify-content-between" style="row-gap: 14px">
                        <div class="mini-card">
                            <span class="mini-card-title">Referrer Information</span>
                            <div class="contact-info" style="margin-top: 16px">
                                <div class="contact-info-item">
                                    <div class="contact-info-label">Organisation:</div>
                                    <div class="contact-info-value">Ministry of Regain</div>
                                </div>
                                <div class="contact-info-item">
                                    <div class="contact-info-label">Practitioner:</div>
                                    <div class="contact-info-value">Dr. Natalya Schevchenko</div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-hidden mb-0 d-flex justify-content-center align-items-center"
                             style="border: 1px solid rgba(219, 209, 199, 1); border-radius: 20px; min-height: 387px">
                            <div class="card-body p-0 m-0 card-table-body">
                                <div id="custom-calendar" class="custom-calendar">

                                </div>
                                <div
                                    class="calendar-footer d-flex justify-content-center align-items-center"
                                    style="background-color: transparent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer text-center mb-1">
    <button type="button" class="btn btn-link">Privacy Settings</button>
    <button type="button" class="btn btn-link">Privacy Policy</button>
</div>
</body>
</html>

<script>
    new Calendar({
        id: '#custom-calendar',
        theme: 'basic',
        primaryColor: '#0A133A',
        headerBackgroundColor: '#DDDEF1',
        bodyBackgroundColor: '#DDDEF1',
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
                start: '2024-12-20',
                end: '2024-12-20',
                name: 'Christmas',
            },
        ],
    });
</script>
