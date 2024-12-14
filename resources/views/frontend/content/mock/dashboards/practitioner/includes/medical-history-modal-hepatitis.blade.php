<div class="modal fade" id="medicalHistoryHepatitis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 60%; max-height: 100%">
        <div class="modal-content p-3 p-md-5" style="background-color: rgba(255, 255, 255, 1);">
            <form>
                <div class="form-group">
                    <input type="hidden" id="hepatitisC" class="form-control" name="diagnosed_hepatitis_c">
                    <input type="hidden" id="penicillinAllergy" class="form-control" name="penicillin_allergy">
                    <input type="hidden" id="hereditaryConditions" class="form-control" name="hereditary_conditions">
                </div>
            </form>
            <div class="modal-body" id="modal-container-hepatitis">
                <button type="button" class="btn-close btn-pinned btn-right" data-bs-dismiss="modal" aria-label="Close">
                </button>
                <h3 class="text-center mb-4" style="color: rgba(10, 19, 58, 1); font-weight: 700; font-size: 24px;">Medical History</h3>
                <form id="medical-history-hepatitis-form" method="POST" onsubmit="return false">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label for="hepatitis-diagnosis" class="form-label">Has the patient been diagnosed with Hepatitis C?</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="hepatitis" id="hepatitis-yes" value="yes" required>
                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="hepatitis-yes">Yes</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="hepatitis" id="hepatitis-no" value="no" required>
                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="hepatitis-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="penicillin-allergy" class="form-label">Is the patient allergic to penicillin?</label>
                            <div class="row">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="penicillin" id="penicillin-yes" value="yes" required>
                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="penicillin-yes">Yes</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="penicillin" id="penicillin-no" value="no" required>
                                    <label class="btn w-100 mobility-button new-patient-input d-flex align-items-center justify-content-center" for="penicillin-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="hereditary-conditions" class="form-label">Any hereditary conditions within the patient’s extended family?</label>
                            <select id="hereditary-conditions" class="form-select new-patient-input" multiple required>
                                <option value="diabetes">Diabetes</option>
                                <option value="hypertension">Hypertension</option>
                                <option value="heart_disease">Heart Disease</option>
                                <option value="cancer">Cancer</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-5 d-flex justify-content-end">
{{--                            <button type="button" class="custom-back-btn" id="btn-back-hepatitis">Back</button>--}}
                            <button type="submit" class="custom-next-btn" id="btn-next-hepatitis">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        let nextButtonHepatitis = document.getElementById('btn-next-hepatitis');
        nextButtonHepatitis.addEventListener('click', function (e) {
            e.preventDefault();

            let hepatitisC = document.querySelector('input[name="hepatitis"]:checked')?.value || '';
            let penicillinAllergy = document.querySelector('input[name="penicillin"]:checked')?.value || '';
            let hereditaryConditions = Array.from(document.getElementById('hereditary-conditions').selectedOptions)
                .map(option => option.value);

            document.getElementById('hepatitisC').value = hepatitisC;
            document.getElementById('penicillinAllergy').value = penicillinAllergy;
            document.getElementById('hereditaryConditions').value = hereditaryConditions.join(', ');

            let modal = document.getElementById('modal-container-hepatitis');
            // modal.innerHTML = '';
        });
    });
</script>
