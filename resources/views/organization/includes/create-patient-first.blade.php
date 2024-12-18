<div class="modal-body" id="modal-container" data-page-id="1">
    <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
    </button>
    <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">New Patient Registration</h3>
    <form id="new-patient-registration-form" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label for="name" class="form-label">Name and Surname</label>
                <input type="text" id="name" class="form-control new-patient-input" placeholder="ex. Olha Maximova" required>
            </div>
            <div class="col-md-6">
                <label for="date-of-birthday" class="form-label">Date of Birth</label>
                <input type="text" id="date-of-birthday" class="form-control new-patient-input" placeholder="DD/MM/YYYY" required>
            </div>
            <div class="col-md-6">
                <label for="region" class="form-label">Region</label>
                <select id="region" class="form-control new-patient-input" placeholder="Select region" required>
                    <option value="" selected disabled>Select region</option>
                    @foreach ($regions as $region)
                        <option value="{{$region->getId()}}">{{$region->getName()}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="post-code" class="form-label">Post Code</label>
                <input type="text" id="post-code" class="form-control new-patient-input" placeholder="ex. 54624" required>
            </div>
            <div class="col-md-6">
                <label for="primary-phone" class="form-label">Primary Phone Number</label>
                <input type="text" id="primary-phone" class="form-control new-patient-input" placeholder="ex. +123 456 789" required>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="text" id="email" class="form-control new-patient-input" placeholder="ex. maximova@gmail.com" required>
            </div>
            <div class="col-md-6">
                <label for="secondary-phone" class="form-label">Secondary Phone Number (Optional)</label>
                <input type="text" id="secondary-phone" class="form-control new-patient-input" placeholder="ex. +123 456 789" required>
            </div>
            <div class="col-md-6 mt-5 d-flex justify-content-end align-items-center">
                <button type="submit" class="custom-next-btn" id="btn-next">Next</button>
            </div>
        </div>
    </form>
</div>