<div class="modal fade" id="newPatientRegistrationSecond" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%; max-height: 100%">
        <div class="modal-content p-3 p-md-5" style="background-color: rgba(255, 255, 255, 1);">
            <form>
                <div class="form-group">
                    <input type="hidden" id="mobility" class="form-control" name="accessible_mobility">
                    <input type="hidden" id="notes" class="form-control" name="notes">
                </div>
            </form>
            <div class="modal-body" id="modal-container">
                <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
                </button>
                <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">New Patient Registration</h3>
                <form id="new-patient-registration-form" method="POST" onsubmit="return false">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label for="mobility-visible" class="form-label">Accessible Mobility</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="mobility-visible" id="mobility-yes" value="yes" required>
                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="mobility-yes">Yes</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="mobility-visible" id="mobility-no" value="no" required>
                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="mobility-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="note-visible" class="form-label">Notes (Optional)</label>
                            <textarea id="note-visible" class="form-control new-patient-input" style="min-height: 200px"></textarea>
                        </div>
                        <div class="col-md-12 mt-5 d-flex justify-content-between">
                            <button type="button" class="custom-back-btn" id="btn-back">Back</button>
                            <button type="submit" class="custom-next-btn" id="btn-next">Register</button>
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

            let mobility = document.getElementById('name-visible').value;
            let note = document.querySelector('input[name="mobility-visible"]:checked').value;

            document.getElementById('mobility').value = mobility;
            document.getElementById('notes').value = note;

            let modal = document.getElementById('modal-container');
            // modal.innerHTML = '';
        });
    });
</script>
