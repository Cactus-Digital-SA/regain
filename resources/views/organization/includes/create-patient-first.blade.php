<form id="patient-registration-form">
    <div class="form-group">
        <input type="hidden" id="name" class="form-control" name="name">
        <input type="hidden" id="birthday" class="form-control" name="birthday">
        <input type="hidden" id="region_id" class="form-control" name="region_id">
        <input type="hidden" id="post_code" class="form-control" name="post_code">
        <input type="hidden" id="primary_phone" class="form-control" name="primary_phone">
        <input type="hidden" id="email" class="form-control" name="email">
        <input type="hidden" id="secondary_phone" class="form-control" name="secondary_phone">
    </div>
</form>
<div class="modal-body" id="modal-container" data-page-id="1">
    <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
    </button>
    <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">New Patient Registration</h3>
    <form id="new-patient-registration-form" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label for="name-visible" class="form-label">Name and Surname</label>
                <input type="text" id="name-visible" class="form-control new-patient-input" placeholder="ex. Olha Maximova" required>
            </div>
            <div class="col-md-6">
                <label for="date-of-birthday-visible" class="form-label">Date of Birth</label>
                <input type="text" id="date-of-birthday-visible" class="form-control new-patient-input" placeholder="DD/MM/YYYY" required>
            </div>
            <div class="col-md-6">
                <label for="region-visible" class="form-label">Region</label>
                <select id="region-visible" class="form-control new-patient-input" placeholder="Select region" required>
                    <option value="" selected disabled>Select region</option>
                    @foreach ($regions as $region)
                        <option value="{{$region->getName()}}">{{$region->getName()}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="post-code-visible" class="form-label">Post Code</label>
                <input type="text" id="post-code-visible" class="form-control new-patient-input" placeholder="ex. 54624" required>
            </div>
            <div class="col-md-6">
                <label for="primary-phone-visible" class="form-label">Primary Phone Number</label>
                <input type="text" id="primary-phone-visible" class="form-control new-patient-input" placeholder="ex. +123 456 789" required>
            </div>
            <div class="col-md-6">
                <label for="email-visible" class="form-label">Email</label>
                <input type="text" id="email-visible" class="form-control new-patient-input" placeholder="ex. maximova@gmail.com" required>
            </div>
            <div class="col-md-6">
                <label for="secondary-phone-visible" class="form-label">Secondary Phone Number (Optional)</label>
                <input type="text" id="secondary-phone-visible" class="form-control new-patient-input" placeholder="ex. +123 456 789" required>
            </div>
            <div class="col-md-6 mt-5 d-flex justify-content-end align-items-center">
                <button type="submit" class="custom-next-btn" id="btn-next">Next</button>
            </div>
        </div>
    </form>
</div>