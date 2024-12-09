<!-- Add Role Modal -->
<div class="modal fade" id="newPatientRegistration" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%; max-height: 100%">
        <div class="modal-content p-3 p-md-5" style="background-color: rgba(255, 255, 255, 1);">
            <form>
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
            <div class="modal-body" id="modal-container">
                <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
                </button>
                <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">New Patient Registration</h3>
                <form id="new-patient-registration-form" method="POST" onsubmit="return false">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="name-visible" class="form-label">Input 1</label>
                            <input type="text" id="name-visible" class="form-control new-patient-input" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date-of-birthday-visible" class="form-label">Input 2</label>
                            <input type="text" id="date-of-birthday-visible" class="form-control new-patient-input" required>
                        </div>
                        <div class="col-md-6">
                            <label for="region-visible" class="form-label">Input 3</label>
                            <select id="region-visible" class="form-control new-patient-input" required>
                                <option value="1">Region 1</option>
                                <option value="2">Region 2</option>
                                <option value="3">Region 3</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="post-code-visible" class="form-label">Input 4</label>
                            <input type="text" id="post-code-visible" class="form-control new-patient-input" required>
                        </div>
                        <div class="col-md-6">
                            <label for="primary-phone-visible" class="form-label">Input 5</label>
                            <input type="text" id="primary-phone-visible" class="form-control new-patient-input" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email-visible" class="form-label">Input 6</label>
                            <input type="text" id="email-visible" class="form-control new-patient-input" required>
                        </div>
                        <div class="col-md-6">
                            <label for="secondary-phone-visible" class="form-label">Input 7</label>
                            <input type="text" id="secondary-phone-visible" class="form-control new-patient-input" required>
                        </div>
                        <div class="col-md-6 mt-5">
                            <button type="submit" class="btn btn-primary btn-next" id="btn-next">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        let nextButton = document.getElementById('btn-next');
        nextButton.addEventListener('click', function (e) {
            e.preventDefault();

            let name = document.getElementById('name-visible').value;
            let dateOfBirthday = document.getElementById('date-of-birthday-visible').value;
            let region = document.getElementById('region-visible').selectedOptions[0].value;
            let postCode = document.getElementById('post-code-visible').value;
            let primaryPhone = document.getElementById('primary-phone-visible').value;
            let email = document.getElementById('email-visible').value;
            let secondaryPhone = document.getElementById('secondary-phone-visible').value;

            document.getElementById('name').value = name;
            document.getElementById('birthday').value = dateOfBirthday;
            document.getElementById('region_id').value = region;
            document.getElementById('post_code').value = postCode;
            document.getElementById('primary_phone').value = primaryPhone;
            document.getElementById('email').value = email;
            document.getElementById('secondary_phone').value = secondaryPhone;

            let modal = document.getElementById('modal-container');
            // modal.innerHTML = '';
        });
    });
</script>
