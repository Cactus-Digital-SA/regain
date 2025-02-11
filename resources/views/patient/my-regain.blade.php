<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Regain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <div class="card-body">

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
